<?php

namespace App\Http\Controllers\Customer;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Search\CareOrderHistorySearchRequest;
use App\Models\CareOrder;
use App\Models\CareOrderDetail;
use App\Models\Pet;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CareOrderHistoryController extends Controller
{
    public function index(CareOrderHistorySearchRequest $request)
    {
        $conditions = formatQuery($request->query());
        $careOrders = CareOrder::where('user_id', getUser()->user_id)
            ->where($conditions)
            ->with(['careOrderDetail', 'hotelService', 'pet', 'branch']);
        $careOrders = searchDate($careOrders, 'order_received_date', $request->query('order_received_date'));
        $careOrders = $careOrders
            ->orderBy('created_at', 'desc')
            ->paginate(config('constant.data_table.order_history_page'));
        $petOptions = Pet::getPetOptions(true);
        $oldInput = $request->all();

        return view(
            'customer.care-order-history.index',
            [
                'careOrders' => $careOrders,
                'petOptions' => $petOptions,
                'oldInput' => $oldInput,
            ]
        );
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
    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        try {
            $breadcrumbItems = [
                [
                    'text' => trans('care-order.history'),
                    'url' => route('care-order-history.index'),
                ],
                [
                    'text' => trans('Detail'),
                    'url' => route('care-order-history.show', ['care_order_history' => $id]),
                ],
            ];

            $careOrder = CareOrder::with(['careOrderDetail', 'hotelService', 'pet', 'petServices', 'coupon'])
                ->findOrFail($id);

            $petServicePrice = CareOrderDetail::where('order_id', $id)->sum('pet_service_price');

            return view(
                'customer.care-order-history.show',
                [
                    'breadcrumbItems' => $breadcrumbItems,
                    'careOrder' => $careOrder,
                    'petServicePrice' => $petServicePrice,
                ]
            );
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $orderID)
    {
        try {
            $careOrder = CareOrder::findOrFail($orderID);
            if (!$careOrder->checkOwner()) {
                throw new Exception(trans('care-order.update_fail'));
            }

            $careOrder->order_status = OrderStatusEnum::CANCELLED;
            $careOrder->update();

            return response()->json(['message' => trans('care-order.update_success')]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
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
}
