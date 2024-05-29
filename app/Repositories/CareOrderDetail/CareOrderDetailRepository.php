<?php

namespace App\Repositories\CareOrderDetail;

use App\Repositories\BaseRepository;

class CareOrderDetailRepository extends BaseRepository implements CareOrderDetailRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\CareOrderDetail::class;
    }

    public function getPetServicePrice($orderID)
    {
        return $this->model->where('order_id', $orderID)
            ->sum('pet_service_price');
    }

    public function getSumPrice($orderID)
    {
        return $this->model->where('order_id', $orderID)->sum('pet_service_price');
    }
}
