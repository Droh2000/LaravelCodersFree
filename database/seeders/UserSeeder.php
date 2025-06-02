<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
    }
}
