<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Profile;
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
        //          \App\Models\User::factory(1000)->create();
        // Para ejecutar esto tenemos el comando: php artisan db:seed
        // Para crear nuestro Factory con la otra tabla: php artisan make:Factory CategoryFactory
        \App\Models\Category::factory(10)->create();
        // Cuado ejecutemos el de category tenemos que comentar los que ya hemos ejecutado previamente
        // Otra forma es indicar que se ejecuten las migraciones y despues de eso ejecutar lo luego los Factories
        //          php artisan migrate:fresh --seed

        // Por la forma de nuestra logica nos tiene que primero generar los usuarios y por tanto
        // por cada usuario que nos genere un perfil, para eso recorremos cada uno de los registros creados
        // y de ahi llamamos el Factory de la tabla que tiene la llave foranea
        \App\Models\User::factory(1000)->create()->each(function($user){
            // Aqui llamamos al modelo de la otra tabla, esto ya nos genera los datos de esta tabla
            // Por cada usuario se nos genera 1 perfil y por cada perfil nos generara una direccion
            Profile::factory(1)->create([
                // Dentro le proporcionamos el id del usuario
                'user_id' => $user->id,
            ])->each(function ($profile){
                // Por cada perfil vamos a decirle que nos genere su Address respectivo donde le asigne el Id del profile
                Address::factory(1)->create([
                    'profile_id' => $profile->id
                ]);
            });
        });

        // Generamos 100 registros aleatorios para la tabla Post
        // Hay que saber que importa el orden en el que estan los factories, como Post depende de Category
        // es necesario que primero se ejecute el de Category
        \App\Models\Post::factory(100)->create();

    }
}
