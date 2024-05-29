<?php

namespace App\Repositories\CareOrderDetail;

use App\Repositories\RepositoryInterface;

interface CareOrderDetailRepositoryInterface extends RepositoryInterface
{
    public function getPetServicePrice($orderID);

    public function getSumPrice($orderID);
}
