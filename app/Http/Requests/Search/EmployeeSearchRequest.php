<?php

namespace App\Http\Requests\Search;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeSearchRequest extends FormRequest
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
            'user_email' => 'nullable|string|max:255',
            'branch_id' => 'nullable|exists:branches,branch_id',
        ];
    }
}
