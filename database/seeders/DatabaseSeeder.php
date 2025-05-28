<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/

        //Usamos el factory del usuario para que nos cree 1000 registros
        // Aqui es donde ejecutamos los Factory, primeramente llamando al modelo
        // (es importante nombrarlo con la convencion al factory de NombreModeloFactory)
        // para que lo pueda encontrar Laravel
        // Luego le especificamos la cantidad de registros que queremos que nos genere
        \App\Models\User::factory(1000)->create();
        // Para ejecutar esto tenemos el comando: php artisan db:seed
        // Para crear nuestro Factory con la otra tabla: php artisan make:Factory CategoryFactory
        \App\Models\Category::factory(10)->create();
        // Cuado ejecutemos el de category tenemos que comentar los que ya hemos ejecutado previamente
        // Otra forma es indicar que se ejecuten las migraciones y despues de eso ejecutar lo luego los Factories
        //          php artisan migrate:fresh --seed
    }
}
