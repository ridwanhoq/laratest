<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PoSubFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'       => rand(1, 100),
            'po_id'         => rand(1, 100),
            'p_cat_id'      => rand(1, 100),
        ];
    }
}
