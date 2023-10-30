<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class ResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'use_id' => $this->faker->randomElement(DB::table('users')->pluck('use_id')),
            'wor_id' => $this->faker->randomElement(DB::table('words')->pluck('wor_id')),
        ];
    }
}
