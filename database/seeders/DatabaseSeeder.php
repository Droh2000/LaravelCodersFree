<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Supongamos que limpiamos los datos de nuestro proyecto ejecutando el comando migrate --fresh, esto nos borrara todos los datos y volvera a crearlos
        // pero resulta que las imagenes que habiamos subido se mantienen aunque ya no esten asociadas a ningun post, asi que vamos a hacer que limpie estas imagenes
        Storage::deleteDirectory('posts'); // Esto nos borrar esta carpeta (Si no existe no hace nada)
        Storage::makeDirectory('posts'); // Supongamos que requerimos que por el funcionamiento de nuestra web esta carpeta debe exsitir si o si

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('12345678'),
        ]);

        // Aqui ejecuamos los factories
        Category::factory(10)->create();

        // Queremos que nos genere 100 cantidad de registros
        Post::factory(100)->create();
    }
}
