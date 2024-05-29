<?php

namespace App\Repositories\Coupon;

use App\Repositories\RepositoryInterface;

interface CouponRepositoryInterface extends RepositoryInterface
{
    public function getCouponList();

    public function getCoupon($code);

    public function storeCoupon($data, $isActive);

    public function updateCoupon($data, $isActive, $id);

    public function deleteCoupon($id);
}
