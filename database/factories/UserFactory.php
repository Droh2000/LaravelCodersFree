<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;// Esta libreria nos genera datos de prueba y los inserta en la BD
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

// Si queremos insertar datos de prueba a nuestra BD tenemos los Factory, asi es como podemos hacer pruebas
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Especifica cada uno de los campos de la tabla de la BD
        return [
            // Los valores que le esta asignando llama a la libreria y le especifiamos el tipo de datos que nos genere
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
