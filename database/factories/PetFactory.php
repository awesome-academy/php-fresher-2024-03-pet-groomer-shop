<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'pet_name' => $this->faker->name(),
            'pet_type' => $this->faker->numberBetween(1, 2),
            'pet_gender' => $this->faker->numberBetween(0, 1),
            'pet_birthdate' => $this->faker->date(),
            'pet_weight' => $this->faker->numberBetween(1, 15),
            'pet_description' => $this->faker->text(50),
            'user_id' => $this->faker->numberBetween(2, 10),
            'is_active' => 1,
        ];
    }
}
