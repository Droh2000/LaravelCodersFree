<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generamos datos de prueba para la tabla Post
        return [
            'title' => fake()->sentence(),
            'slug' => fake()->slug(), // Ya este metodo nos genera palabras que no tengan caracteres extraños y estan separados por guion
            'body' => fake()->text(),
            'category_id' => fake()->numberBetween(1, 10) // Esto nos generara un numero aletoria entre 1 y 10
        ];
    }
}
