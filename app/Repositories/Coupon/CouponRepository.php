<?php

namespace App\Repositories\Coupon;

use App\Models\User;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class CouponRepository extends BaseRepository implements CouponRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Coupon::class;
    }

    public function getCouponList()
    {
        return $this->model->paginate(config('constant.data_table.item_per_page'))->withQueryString();
    }

    public function storeCoupon($data, $isActive)
    {
        if (Gate::denies('create', User::class)) {
            throw new \Exception(trans('coupon.create_error'));
        }

        $this->model->fill($data);
        $this->model->created_by = getUser()->user_id;
        $this->model->is_active  = $isActive;
        $this->model->save();
    }

    public function updateCoupon($data, $isActive, $id)
    {
        $coupon = $this->findOrFail($id);
        if (Gate::denies('update', $coupon)) {
            throw new \Exception(trans('coupon.update_error'));
        }

        $coupon->fill($data);
        $coupon->is_active  = $isActive;
        $coupon->save();
    }

    public function deleteCoupon($id)
    {
        $coupon = $this->findOrFail($id);
        if (Gate::denies('delete', $coupon)) {
            throw new \Exception(trans('coupon.delete_error'));
        }

        $coupon->delete();
    }

    public function getCoupon($code)
    {
        $coupon = $this->model->where('coupon_code', trim($code))->first();
        if ($coupon) {
            // Check if the coupon has expired
            $expiryDate = Carbon::parse($coupon->expiry_date);
            if ($expiryDate->isPast()) {
                return 'expired';
            }

            return $coupon;
        }

        return 'not_found';
    }
}
