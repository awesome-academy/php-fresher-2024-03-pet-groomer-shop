<?php

namespace App\Http\Requests;

use App\Enums\PetTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BreedRequest extends FormRequest
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
            'breed_name' => ['required', 'min:2', 'max:200'],
            'breed_description' => ['nullable'],
            'breed_type' => ['required', Rule::in(PetTypeEnum::getValues())],
        ];
    }
}
