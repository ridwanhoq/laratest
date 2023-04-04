<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UpqaOptionCountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'pq_id'         => rand(1, 3),
            'pqa_option_id' => rand(1, 3),
            'total_count'   => rand(1, 500),
            'percentage'    => rand(0, 100)
        ];
    }
}
