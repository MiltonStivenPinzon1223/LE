<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class WordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'wor_english' => $this->faker->name(),
            'wor_spanish' => $this->faker->name(),
            'cat_id' => $this->faker->randomElement(DB::table('categories')->pluck('cat_id')),
        ];
    }
}
