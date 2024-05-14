<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PetServicePriceRequest extends FormRequest
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
        $maxNumber = config('constant.max_number');
        $weightPrices = array_values(config('constant.pet_price_weight'));

        return [
            'pet_service_price' => 'required|numeric|min:0|max:' . $maxNumber,
            'pet_service_weight' => ['required', 'numeric', Rule::in($weightPrices)],
        ];
    }
}
