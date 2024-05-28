<?php

namespace App\Http\Requests;

use App\Rules\AfterHour;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class AssignTaskRequest extends FormRequest
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
        $returnedDate = request()->input('returned_date') ?? Carbon::now()->addYear();

        return [
            'from_time' => ['required','before:to_time','after:order_received_date', new AfterHour(1, 'to_time')],
            'to_time' => 'required|after:from_time|before_or_equal:' . $returnedDate,
        ];
    }
}
