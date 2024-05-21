<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class AfterHour implements Rule
{
    protected $hour = 1;
    protected $startTime = '';
    protected $endTime = '';

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($hour, $startTime)
    {
        $this->hour = $hour;
        $this->startTime = $startTime;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->endTime = $attribute;
        $startDateTime = Carbon::parse(request()->input($this->startTime));
        $endDateTime = Carbon::parse($value);

        return $endDateTime->diffInHours($startDateTime) >= $this->hour;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans(
            'validation.after_hour',
            [
                'attribute' => $this->endTime,
                'other' => $this->startTime,
                'hour' => $this->hour,
            ]
        );
    }
}
