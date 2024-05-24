<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatusEnum;
use App\Http\Requests\CareOrderManageRequest;
use App\Models\Branch;
use App\Models\CareOrder;
use App\Models\CareOrderDetail;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CareOrderController extends Controller
{
    public function index(CareOrderManageRequest $request)
    {
        $conditions = formatQuery($request->query());
        $careOrders = CareOrder::with([
            'pet',
            'user',
            'assignTask',
            'branch',
            'coupon',
            'hotelService',
            'careOrderDetail',
            'petServices',
        ])
            ->where($conditions)
            ->paginate(config('constant.data_table.care_order_page'));
        $orderStatusOptions = CareOrder::getStatusOptions();
        $extraOrderStatusOptions = $orderStatusOptions;
        $extraOrderStatusOptions[__('All')] = '';

        $branchOptions = Branch::pluck('branch_id', 'branch_name');
        $branchOptions[__('All')] = '';
        $oldInput = $request->all();

        return view(
            'care-order.index',
            [
                'careOrders' => $careOrders,
                'orderStatusOptions' => $orderStatusOptions,
                'extraOrderStatusOptions' => $extraOrderStatusOptions,
                'branchOptions' => $branchOptions,
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

            $careOrder = CareOrder::with([
                'careOrderDetail',
                'hotelService',
                'pet',
                'petServices',
                'coupon',
                'assignTask',
            ])
                ->findOrFail($id);

            $petServicePrice = CareOrderDetail::where('order_id', $id)
                ->sum('pet_service_price');

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

            $careOrder = CareOrder::findOrFail($id);
            if (Gate::denies('update', $careOrder)) {
                throw new Exception(trans('permission.update_fail'));
            }

            $careOrder = $careOrder->update(['order_status' => $request->input('order_status')]);

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
