<?php

namespace App\Http\Requests;

use App\Enums\PetTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PetRequest extends FormRequest
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
        $petTypes = PetTypeEnum::getValues();

        $rules = [
            'pet_name' => ['required', 'string', 'min:2', 'max:255'],
            'breed_id' => ['nullable', 'exists:breeds,breed_id'],
            'pet_birthdate' => ['date', 'before:today', 'nullable'],
            'pet_gender' => ['required', 'in:0,1'],
            'pet_description' => ['string', 'min:3', 'nullable'],
            'pet_image' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048', 'nullable'],
            'pet_weight' => ['required', 'numeric', 'lte:1000', 'gte:0'],
            'pet_type' => ['required', Rule::in($petTypes)],
        ];

        if ($this->has('user_id')) {
            $rules['user_id'] = ['required', 'exists:users,user_id'];
        }

        return $rules;
    }
}
