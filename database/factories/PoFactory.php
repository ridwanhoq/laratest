<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'points_per_question'   => rand(10, 100),
            'date'                  => date('Y-m-d'),
            'is_active'             => array_rand([true, false])
        ];
    }
}
