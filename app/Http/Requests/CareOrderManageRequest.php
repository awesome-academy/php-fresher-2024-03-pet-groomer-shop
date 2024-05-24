<?php

namespace App\Http\Requests;

use App\Enums\OrderStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CareOrderManageRequest extends FormRequest
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
            'order_received_date' => 'nullable|date|before:today',
            'branch_id' => 'nullable|exists:branches,branch_id',
            'order_status' => ['nullable', Rule::in(OrderStatusEnum::getValues())],
        ];
    }
}
