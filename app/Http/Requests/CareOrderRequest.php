<?php

namespace App\Http\Requests;

use App\Rules\AfterHour;
use Illuminate\Foundation\Http\FormRequest;

class CareOrderRequest extends FormRequest
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
            'pet_service_id.*' => 'nullable|exists:pet_services,pet_service_id',
            'from_datetime' => ['nullable', 'date', 'after:today'],
            'to_datetime' => ['nullable', 'date', 'after:from_datetime', new AfterHour(1, 'from_datetime')],
            'order_note' => 'nullable|string',
            'coupon_code' => 'nullable|string|min:10|max:10',
            'branch_id' => 'required|exists:branches,branch_id',
        ];
    }
}
