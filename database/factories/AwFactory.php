<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AwFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'         => $this->faker->name(),
            'type'          => rand(1, 3),
            'range_start'   => rand(1, 100),
            'range_end'     => rand(1, 500),
        ];
    }
}
