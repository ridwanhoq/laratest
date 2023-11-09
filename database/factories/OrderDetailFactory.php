<?php

namespace Database\Factories;

use App\Models\Product;
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
            'product_id' => Product::factory()->create()->id,
            'unit_price' => rand(200, 300),
            'quantity' => rand(10, 20),
            'additional_charge' => 100,
            'discount' => 50
        ];
    }
}
