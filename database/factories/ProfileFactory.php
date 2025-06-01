<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Aqui generamos datos de prueba, el campo de la llave foranea no lo vamos a generar asi
            'job' => fake()->jobTitle(),
            'phone' => fake()->phoneNumber(),
            'website' => fake()->domainName(),
        ];
    }
}
