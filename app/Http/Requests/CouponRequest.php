<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'coupon_name' => ['required', 'string', 'min:3', 'max:255'],
            'coupon_code' => ['required', 'string', 'min:10', 'max:10', 'unique:coupons'],
            'coupon_price' => ['required', 'numeric', 'min:0', 'max:10000000'],
            'expiry_date' => ['required', 'date', 'after:today'],
            'current_number' => ['required', 'numeric', 'min:0', 'max:10000000', 'lt:max_number'],
            'max_number' => ['required', 'numeric', 'min:0', 'max:10000000'],
        ];
    }
}
