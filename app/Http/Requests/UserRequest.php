<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'user_first_name' => ['required', 'string', 'min:2', 'max:255'],
            'user_last_name' => ['required', 'string', 'min:2', 'max:255'],
            'user_gender' => ['required', 'in:0,1,2'],
            'user_phone_number' => ['string', 'min:10', 'max:10', 'nullable'],
            'user_address' => ['string', 'min:3', 'max:255', 'nullable'],
            'user_birthdate' => ['date', 'before:' . now()->subYears(8)->toDateString(), 'nullable'],
            'branch_id' => [Rule::requiredIf($this->has('branch_id')), 'exists:branches,branch_id'],
            'user_password' => [Rule::requiredIf($this->has('user_password')), 'string', 'min:8', 'confirmed'],
            'username' => [Rule::requiredIf($this->has('username')), 'string', 'min:3', 'max:255', 'unique:users'],
            'user_email' => [Rule::requiredIf($this->has('user_email')), 'string', 'email', 'max:255', 'unique:users'],
            'role_id' => [Rule::requiredIf($this->has('role_id')), 'exists:roles,role_id'],
        ];
    }
}
