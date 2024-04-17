<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_first_name' => $this->faker->name(),
            'user_last_name' => $this->faker->name(),
            'user_name' => Str::slug(strtolower($this->faker->name()), '-'),
            'user_email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'user_password' => Hash::make('12345678'), // password
            'user_gender' => $this->faker->numberBetween(1, 3),
            'user_birthdate' => $this->faker->date(),
            'user_phone_number' => $this->faker->numberBetween(1000000000, 9999999999),
            'user_address' => $this->faker->address(),
            'role_id' => $this->faker->numberBetween(1, 4),
            'remember_token' => Str::random(10),
            'is_active' => 0,
            'is_admin' => $this->faker->numberBetween(0, 1),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
