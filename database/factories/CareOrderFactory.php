<?php

namespace Database\Factories;

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class CareOrderFactory extends Factory
{
    public function definition()
    {
        return [
            'order_total_price' => $this->faker->numberBetween(1000, 2000) * 1000,
            'order_status' => OrderStatusEnum::CREATED,
            'order_note' => $this->faker->sentence(3),
            'order_received_date' => now(),
            'payment_method' => 'cod',
            'branch_id' => 1,
            'user_id' => 1,
        ];
    }
}
