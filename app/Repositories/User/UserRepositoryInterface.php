<?php

namespace App\Repositories\User;

use App\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function getUserOption();

    public function getUserList($condition);

    public function storeUser($data, $isActive);

    public function getDetailUser($id);

    public function updateUser($data, $id, $isActive);

    public function deleteUser($id);

    public function getEmployeeList($conditions = []);

    public function checkValid($id);

    public function assignTask($id, $orderID, $fromDate, $toDate);

    public function isAssigned($orderID);

    public function isOverlappingTask($fromTime, $toTime);

    public function unAssignTask($userID, $careOrderID);

    public function updateAssignTask($userID, $orderID, $fromDate, $toDate);

    public function updateProfile($data, $id);

    public function getUserByEmail($email);
}
