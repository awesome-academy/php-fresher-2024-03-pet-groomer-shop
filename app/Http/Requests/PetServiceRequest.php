<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PetServiceRequest extends FormRequest
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
            'pet_service_name' => 'required|string|min:2|max:255',
            'pet_service_description' => 'nullable',
        ];
    }
}
