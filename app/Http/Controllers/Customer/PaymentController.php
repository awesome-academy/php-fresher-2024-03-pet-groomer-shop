<?php

namespace App\Http\Controllers\Customer;

use App\Enums\OrderStatusEnum;
use App\Enums\PaymentMethodEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Jobs\SendPaymentSuccessEmail;
use App\Notifications\PaymentPaidNotification;
use App\Repositories\CareOrder\CareOrderRepositoryInterface;
use App\Repositories\Coupon\CouponRepositoryInterface;
use App\Repositories\HotelService\HotelServiceRepositoryInterface;
use App\Repositories\Pet\PetRepositoryInterface;
use App\Repositories\PetService\PetServiceRepositoryInterface;
use App\Repositories\PetServicePrice\PetServicePriceRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    protected $couponRepo;
    protected $petRepo;
    protected $petServiceRepo;
    protected $petServicePriceRepo;

    protected $hotelServiceRepo;
    protected $careOrderRepo;

    public function __construct(
        CouponRepositoryInterface $couponRepo,
        PetRepositoryInterface $petRepo,
        PetServiceRepositoryInterface $petServiceRepo,
        PetServicePriceRepositoryInterface $petServicePriceRepo,
        HotelServiceRepositoryInterface $hotelServiceRepo,
        CareOrderRepositoryInterface $careOrderRepo
    ) {
        $this->couponRepo = $couponRepo;
        $this->petRepo = $petRepo;
        $this->petServiceRepo = $petServiceRepo;
        $this->petServicePriceRepo = $petServicePriceRepo;
        $this->hotelServiceRepo = $hotelServiceRepo;
        $this->careOrderRepo = $careOrderRepo;
    }

    public function index($petID)
    {
        try {
            $careOrder = session('careOrder');
            if (!isset($careOrder)) {
                return redirect()->route('care-order.index');
            }

            $breadcrumbItems = [
                ['text' => trans('care-order.care-order'), 'url' => route('care-order.index')],
                ['text' => trans('care-order.request'), 'url' => route('care-order.request-page', ['pet' => $petID])],
                ['text' => trans('payment.payment'), 'url' => route('payment.index', ['pet' => $petID])],
            ];
            $pet = $this->petRepo->findOrFail($petID);
            $petServices = $this->getPetService($pet);
            $hotel = $this->getHotelPrice();
            $totalPrice = $this->getTotalPrice($pet);

            return view('customer.payment.index', [
                'breadcrumbItems' => $breadcrumbItems,
                'pet' => $pet,
                'petServices' => $petServices,
                'careOrder' => $careOrder,
                'hotel' => $hotel,
                'totalPrice' => $totalPrice,
            ]);
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function getCoupon(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'coupon_code' => 'nullable|string',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()]);
        }

        $coupon = $this->couponRepo->getCoupon($request->query('coupon_code'));

        return response()->json($coupon);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentRequest $request, $petID)
    {
        DB::beginTransaction();
        try {
            $pet = $this->petRepo->findOrFail($petID);
            if (!$pet->checkOwner()) {
                throw new \Exception(trans('pet.not_found'));
            }

            $petServices = session('petServicePrice') ?? [];
            $coupon = null;
            if (isset($request->coupon_code)) {
                $coupon = $this->couponRepo->getCoupon($request->coupon_code);
            }

            $order = $this->createOrder($request, $pet, $coupon);
            $this->attachPetService($order, $petServices);
            $this->setHotelService($order);
            DB::commit();

            SendPaymentSuccessEmail::dispatch($order, getUser()->user_email);
            $order->user->notify(new PaymentPaidNotification($order));
            session()->forget(['petServicePrice', 'careOrder', 'hotelServicePrice']);

            return response()
                ->json([
                    'status' => 200,
                    'success' => trans('payment.success'),
                    'url' => route('payment.confirm'),
                ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function confirmPage()
    {
        return view('customer.payment.confirm-page.index');
    }

    private function getPetService($pet)
    {
        $careOrder = session('careOrder');
        $totalPrice = 0;
        if (isset($careOrder['pet_service_id'])) {
            $petServices = $this->petServiceRepo->findMany($careOrder['pet_service_id']);
            foreach ($petServices as $petService) {
                $petService->price = $this->petServicePriceRepo->getPriceByWeight($petService
                    ->pet_service_id, $pet
                    ->pet_weight);
            }

            session()->put('petServicePrice', $petServices);
            $totalPrice = $petServices->sum('price');

            return [$petServices, $totalPrice];
        }

        return [[], $totalPrice];
    }

    private function getHotelPrice()
    {
        $careOrder = session('careOrder');
        if (!isset($careOrder['from_datetime']) || !isset($careOrder['to_datetime'])) {
            return [0, 0];
        }

        $fromDate = Carbon::parse($careOrder['from_datetime']);
        $toDate = Carbon::parse($careOrder['to_datetime']);
        $hours = $toDate->diffInHours($fromDate);
        $hotelHourPrice = config('constant.hotel_hour_prices');
        $hotelPrice = 0;
        if ($hours <= 1) {
            $hotelPrice = $hotelHourPrice['one'];
        } elseif ($hours <= 2) {
            $hotelPrice = $hotelHourPrice['two'];
        } elseif ($hours <= 50) {
            $hotelPrice = $hotelHourPrice['fifty'] * $hours;
        } else {
            $remainHour = $hours - 50;
            $hotelPrice = $hotelHourPrice['fifty'] * 50 + $hotelHourPrice['other'] * $remainHour;
        }

        session()->put('hotelPrice', $hotelPrice);

        return [$hotelPrice, $hours];
    }

    private function getTotalPrice($pet)
    {
        $petServicePrice = $this->getPetService($pet)[1];
        $hotelPrice = $this->getHotelPrice()[0];

        return $petServicePrice + $hotelPrice;
    }

    private function attachPetService($order, $petServices)
    {
        foreach ($petServices as $petService) {
            $order->careOrderDetail()
                ->attach(
                    $petService->pet_service_id,
                    ['pet_service_price' => $petService->price]
                );
        }
    }

    private function setHotelService($order)
    {
        $careOrder = session('careOrder');
        $hotelPrice = session('hotelPrice');
        if (isset($careOrder['from_datetime']) && isset($hotelPrice)) {
            $this->hotelServiceRepo->create([
                'from_datetime' => $careOrder['from_datetime'],
                'to_datetime' => $careOrder['to_datetime'],
                'hotel_price' => $hotelPrice,
                'order_id' => $order->order_id,
            ]);
        }
    }

    private function createOrder($request, $pet, $coupon)
    {
        if ($coupon) {
            if ($coupon->careOrders()->where('user_id', getUser()->user_id)->exists()) {
                throw new Exception(trans('coupon.used_user'));
            }

            $currentNumber = $coupon->current_number + 1;
            if ($currentNumber > $coupon->max_number) {
                throw new Exception(trans('coupon.max_limit'));
            }

            $coupon->current_number++;
            $coupon->save();
        }

        $careOrder = session('careOrder');

        $data = [
            'pet_id' => $pet->pet_id,
            'branch_id' => $careOrder['branch_id'],
            'user_id' => getUser()->user_id,
            'order_status' => OrderStatusEnum::CREATED,
            'order_note' => $careOrder['order_note'],
            'order_total_price' => $request->input('total_price', 0),
            'order_coupon_price' => $request->input('coupon_price', 0),
            'coupon_id' => isset($request->coupon_code) ? $coupon->coupon_id : null,
            'payment_method' => $request->input('payment_method', PaymentMethodEnum::COD),
            'order_hotel_price' => $this->getHotelPrice()[0],
            'order_received_date' => Carbon::now(),
        ];

        if (isset($careOrder['from_datetime']) && isset($careOrder['to_datetime'])) {
            $data['order_received_date'] = $careOrder['from_datetime'];
            $data['returned_date'] = $careOrder['to_datetime'];
        }

        return $this->careOrderRepo->create($data);
    }
}
