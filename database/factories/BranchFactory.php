<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BranchFactory extends Factory
{
    public function definition()
    {
        return [
            'branch_name' => $this->faker->name(),
            'branch_address' => $this->faker->name(),
            'branch_phone' => $this->faker->name(),
        ];
    }
}
