<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UprFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'   => rand(1, 100),
            'p_id'      => rand(1, 3),
            'points'    => rand(1, 500),
        ];
    }
}
