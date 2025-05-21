<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Gracias a la convencion de ejecutar el comando como: create_NombreTabla_table, nos crea este codigo
        Schema::create('posts', function (Blueprint $table) {
            // Al crear el Id por defecto es BigInt, Autoincrement, Llave Primaria
            /*$table->id();*/

            // Tenemos otra forma de crear las llaves primarias
            /*$table->bigInteger('id')
                ->autoIncrement() // Este por defecto nos configura como llave primaria por eso se comento el indice de abajo
                ->unsigned();*/

            // Otra forma de crear lo de arriba ya con las 3 propiedades de arriba por defecto
            // $table->bigIncrements('id');

            // Lo mismo de arriba pero el tipo de dato es INT no BigInt como arriba
            $table->increments('id');

            // Estos son los campos que tendria esta tabla Posts
            // Podemos limitar la cantidad de caracteres que queremos especificando el numero que queremos permitir
            $table->string('title', 15);
            $table->string('slug'); // El SLUG es la URL donde se muestra el titulo separado por guiones
            $table->longText('body');// Supongamos que despues de ejecutar las migraciones un campo de la tabla lo definimos mal y tenemos que modificarlo
            $table->timestamps();

            // Indices
            /*$table->primary('id');*/// El indice es que debe ser una llave primaria

            // Definir llaves primarias compuestas en la que depende de varios valores (Estos se pasan entre el arreglo)
            // $table->primary(['id', 'OtroValor1', 'OtroValor2']);

            // Especificar la propiedad para que los registros que almacene el campo sean unicos y no se repitan
            // ->unique();

            // Habeses requerimos recrear indices para cuando queremos facilitarnos la busquedad en alguna consulta de nuestra Base de datos
            $table->index('slug'); // Queremos crear el indice para cuando queramos buscar en este campo

            // Indices para buscar en textos muy grandes
            $table->fullText('body');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
