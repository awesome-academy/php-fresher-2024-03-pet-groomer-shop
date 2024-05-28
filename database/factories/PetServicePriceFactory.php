<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PetServicePriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'pet_service_price' => $this->faker->numberBetween(1000, 10000),
            'pet_service_weight' => $this->faker->numberBetween(1, 10),
        ];
    }
}
