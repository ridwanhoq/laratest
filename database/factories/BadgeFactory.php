<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BadgeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'necessary_rizz_points'     => rand(1, 25000),
            'necessary_accuracy'       => rand(1, 100),
            'necessary_streak'          => rand(1, 500),   
        ];
    }
}
