<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PetServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'pet_service_name' => $this->faker->name(),
            'pet_service_description' => $this->faker->name(),
        ];
    }
}
