<?php

namespace Database\Factories;

use App\Enums\PetTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class BreedFactory extends Factory
{
    public function definition()
    {
        return [
            'breed_name' => $this->faker->name(),
            'breed_description' => $this->faker->name(),
            'breed_type' => $this->faker->randomElement(PetTypeEnum::getValues()),
        ];
    }
}
