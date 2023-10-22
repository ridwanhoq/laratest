<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id' => rand(1, 5),
            'product_id' => rand(1, 5),
            'unit_price' => rand(200, 300),
            'quantity' => rand(10, 20),
        ];
    }
}
