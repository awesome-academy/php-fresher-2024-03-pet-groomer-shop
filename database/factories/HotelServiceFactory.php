<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HotelServiceFactory extends Factory
{
    public function definition()
    {
        return [
            'hotel_price' => $this->faker->numberBetween(10000, 1000000),
            'order_id' => 1,
            'from_datetime' => $this->faker->dateTime('now'),
            'to_datetime' => $this->faker->dateTime('now'),
        ];
    }
}
