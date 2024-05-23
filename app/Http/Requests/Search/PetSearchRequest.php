<?php

namespace App\Http\Requests\Search;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PetSearchRequest extends FormRequest
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
        $petTypes = array_flip(config('constant.pet_type'));

        return [
            'pet_name' => 'nullable|string|max:255',
            'pet_type' => ['nullable', Rule::in($petTypes)],
        ];
    }
}
