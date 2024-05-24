<?php

namespace App\Http\Requests\Search;

use Illuminate\Foundation\Http\FormRequest;

class CareOrderHistorySearchRequest extends FormRequest
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
            'pet_id' => 'nullable|exists:pets,pet_id',
            'created_at' => 'nullable|date',
        ];
    }
}
