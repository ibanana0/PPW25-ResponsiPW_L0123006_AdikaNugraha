<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todos>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3), 
            'time' => fake()->time(), 
            'date' => fake()->date(), 
            'bio' => fake()->paragraph(), 
            'is_complete' => fake()->boolean()
        ];
    }
}
