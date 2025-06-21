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
        return [
            // Generamos datos de prueba para cada campo
            'title' => $this->faker->sentence(),
            'slug' => $this->faker->unique()->slug(),
            'excerpt' => $this->faker->paragraph(),
            'content' => $this->faker->paragraph(20, true), // Queremos 20 parrafos
            'is_published' => $this->faker->boolean(),
            'published_at' => $this->faker->dateTime(),
            'user_id' => \App\Models\User::all()->random()->id, // Recuperamos un usuario al azar y nos traiga su Id
            'category_id' => \App\Models\Category::all()->random()->id,
        ];
    }
}
