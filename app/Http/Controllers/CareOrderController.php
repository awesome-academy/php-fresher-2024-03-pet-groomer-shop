<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatusEnum;
use App\Http\Requests\CareOrderManageRequest;
use App\Jobs\SendOrderStatusChangeEmail;
use App\Repositories\Branch\BranchRepositoryInterface;
use App\Repositories\CareOrder\CareOrderRepositoryInterface;
use App\Repositories\CareOrderDetail\CareOrderDetailRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CareOrderController extends Controller
{
    protected $careOrderRepo;
    protected $careOrderDetailRepo;

    protected $branchRepo;

    public function __construct(
        CareOrderRepositoryInterface $careOrderRepo,
        BranchRepositoryInterface $branchRepo,
        CareOrderDetailRepositoryInterface $careOrderDetailRepo
    ) {
        $this->careOrderRepo = $careOrderRepo;
        $this->branchRepo = $branchRepo;
        $this->careOrderDetailRepo = $careOrderDetailRepo;
    }

    public function index(CareOrderManageRequest $request)
    {
        $conditions = formatQuery($request->query());
        $careOrders = $this->careOrderRepo->getCareOrderList($conditions);
        [$orderStatusOptions, $extraOrderStatusOptions] = $this->careOrderRepo->getCareOrderOption();
        $branchOptions = $this->branchRepo->getBranchOption(true);

        return view(
            'care-order.index',
            [
                'careOrders' => $careOrders,
                'orderStatusOptions' => $orderStatusOptions,
                'extraOrderStatusOptions' => $extraOrderStatusOptions,
                'branchOptions' => $branchOptions,
                'oldInput' => $request->all(),
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
                    'text' => trans('care-order.care-order'),
                    'url' => route('care-order-manage.index'),
                ],
                [
                    'text' => trans('Detail'),
                    'url' => route(
                        'care-order-manage.show',
                        ['care_order_manage' => $id]
                    ),
                ],
            ];

            $careOrder = $this->careOrderRepo->getCareOrder($id);

            $petServicePrice = $this->careOrderDetailRepo->getPetServicePrice($id);

            return view(
                'care-order.show',
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
        try {
            $validator = Validator::make($request->all(), [
                'order_status' => [Rule::in(OrderStatusEnum::getValues())],
            ]);

            if ($validator->fails()) {
                flashMessage('error', trans('care-order.update_fail'));
            }

            $orderStatus = (int) $request->input('order_status');
            $order = $this->careOrderRepo->updateCareOrderStatus($orderStatus, $id);
            SendOrderStatusChangeEmail::dispatch($order, $order->user()->get()->user_email);
            flashMessage('success', trans('care-order.update_success'));
        } catch (Exception $e) {
            flashMessage('error', $e->getMessage());
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
