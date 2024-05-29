<?php

namespace App\Repositories\CareOrder;

use App\Enums\OrderStatusEnum;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Gate;

class CareOrderRepository extends BaseRepository implements CareOrderRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\CareOrder::class;
    }

    public function getCareOrderList($conditions = [])
    {
        return $this->model->with([
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
    }

    public function getCareOrderOption()
    {
        $orderStatusOptions = array_flip(OrderStatusEnum::getTranslated());

        $extraOrderStatusOptions = $orderStatusOptions;
        $extraOrderStatusOptions[__('All')] = '';

        return [$orderStatusOptions, $extraOrderStatusOptions];
    }

    public function getCareOrder($careOrderID)
    {
        return $this->model->with([
            'careOrderDetail',
            'hotelService',
            'pet',
            'petServices',
            'coupon',
            'assignTask',
        ])->findOrFail($careOrderID);
    }

    public function updateOrderStatusForCustomer($id)
    {
        $careOrder = $this->findOrFail($id);
        if (!$careOrder->checkOwner()) {
            throw new \Exception(trans('care-order.update_fail'));
        }

        $careOrder->order_status = OrderStatusEnum::CANCELLED;
        $careOrder->update();
    }

    public function updateCareOrderStatus($orderStatus, $id)
    {
        $careOrder = $this->findOrFail($id);
        if (Gate::denies('update', $careOrder)) {
            throw new \Exception(trans('permission.update_fail'));
        }

        $careOrder = $careOrder->update(['order_status' => $orderStatus]);

        if ($orderStatus === OrderStatusEnum::COMPLETED) {
            $careOrder->update(['returned_date' => now()]);
        }
    }

    public function assignTaskList($branchID)
    {
        return $this->model
            ->where('branch_id', $branchID)
            ->with('assignTask')
            ->orderBy('updated_at', 'desc')
            ->paginate(config('constant.data_table.item_per_page'))
            ->withQueryString();
    }

    public function getCareOrderHistory($conditions)
    {
        $careOrders = $this->model->where('user_id', getUser()->user_id)
            ->where($conditions)
            ->with(['careOrderDetail', 'hotelService', 'pet', 'branch']);
        $careOrders = searchDate($careOrders, 'order_received_date', $conditions['order_received_date']);
        $careOrders = $careOrders
            ->orderBy('created_at', 'desc')
            ->paginate(config('constant.data_table.order_history_page'));

        return $careOrders;
    }
}
