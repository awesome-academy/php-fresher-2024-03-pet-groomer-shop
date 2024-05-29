<?php

namespace App\Repositories\CareOrder;

use App\Repositories\RepositoryInterface;

interface CareOrderRepositoryInterface extends RepositoryInterface
{
    public function getCareOrderList($conditions = []);

    public function getCareOrderOption();

    public function getCareOrder($careOrderID);

    public function updateCareOrderStatus($orderStatus, $id);

    public function updateOrderStatusForCustomer($id);

    public function assignTaskList($branchID);

    public function getCareOrderHistory($conditions);
}
