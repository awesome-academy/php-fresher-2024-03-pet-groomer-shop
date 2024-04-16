<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'coupon_name' => $this->faker->name(),
            'coupon_price' => $this->faker->numberBetween(10000, 1000000),
            'coupon_code' => Str::random(10),
            'expiry_date' => $this->faker->date(),
            'current_number' => 0,
            'max_number' => $this->faker->numberBetween(100, 1000),
            'is_active' => $this->faker->numberBetween(0, 1),
            'created_by' => 1,
        ];
    }
}
