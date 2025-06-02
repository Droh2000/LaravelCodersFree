<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Post;
use App\Models\Profile;
use App\Models\Section;
use App\Models\Tag;
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

        // Aqui Indicamos que se ejecute el SEEDER que creamos
        /*$this->call(UserSeeder::class);

        $this->call(PostSeeder::class);*/

        // Para no estar llamando Seeders uno tras otro, dentro de este metodo llamamos a todos los seeder que queramos
        // Es importante seguir el orden por si uno seeder depende de otro
        $this->call([
            UserSeeder::class,
            PostSeeder::class
        ]);

        Course::factory(10)->create()->each(function ($course){
            // Por cada curso nos genere secciones
            Section::factory(4)->create([
                'course_id' => $course->id,
            ])->each(function($section){
                // Por cada seccion nos genere 5 lecciones
                Lesson::factory(5)->create([
                    'section_id' => $section->id,
                ]);
            });
        });

        Tag::factory(10)->create();
    }
}
