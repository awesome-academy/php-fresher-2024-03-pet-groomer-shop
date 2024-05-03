<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        $rules = [
            'user_first_name' => ['required', 'string', 'min:2', 'max:255'],
            'user_last_name' => ['required', 'string', 'min:2', 'max:255'],
            'user_gender' => ['required', 'in:0,1,2'],
            'user_phone_number' => ['string', 'min:10', 'max:10', 'nullable'],
            'user_address' => ['string', 'min:3', 'max:255', 'nullable'],
            'user_image' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048', 'nullable'],
            'user_birthdate' => ['date', 'before:' . now()->subYears(8)->toDateString(), 'nullable'],
            'branch_id' => ['required', 'exists:branches,branch_id'],
        ];

        // make if condition here because the update form don't has these fields
        if (
            $this->has('user_password')
            && $this->has('username')
            && $this->has('user_email')
            && $this->has('role_id')
        ) {
            $rules['user_password'] = ['required', 'string', 'min:8', 'confirmed'];
            $rules['username'] = ['required', 'string', 'min:3', 'max:255', 'unique:users'];
            $rules['user_email'] = ['required', 'string', 'email', 'max:255', 'unique:users'];
            $rules['role_id'] = ['required', 'exists:roles,role_id'];
        }

        return $rules;
    }
}
