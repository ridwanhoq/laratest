<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UrFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'       => $this->faker->unique()->randomElement(User::pluck('id')), 
            'rizz_points'   => rand(100, 16000),
            'accuracy'      => rand(1, 100),
            'streak'        => rand(1, 1000),
        ];
    }
}
