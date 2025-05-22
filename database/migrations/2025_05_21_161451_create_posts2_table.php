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
        Schema::create('posts2', function (Blueprint $table) {
            $table->id();
            $table->increments('id');
            $table->string('title', 15);
            $table->string('slug');
            $table->longText('body');

            // Aqui vamos a crear la relacion para saber cual usuario escribio este post (Aqui nos relacionamos con la tabla usuarios)
            // Este es el campo donde vamos a registrar los valores para relacionar
            // $table->unsignedBigInteger('user_id');

            // Cuando trabajamos con llavez foraneas hay que crear aqui con el mismo tipo de dato que tiene en la otra tabla
            // Ademas le tenemos que agregar una restriccion de llave foranea para solo ingresar ID de usuarios que existan previamente en la tabla con la que nos relacionamos
            /*$table->foreign('user_id') // Hacemos referencia a este campo que habiamos creado previamente
                ->references('id') // Nombre del campo de la tabla donde nos queremos relacionar
                ->on('users'); // Nombre de la tabla donde nos queremos relacionar
            */

            // Hay otra forma de hacer lo de arriba
            // La Propiedad "foreingID" nos crea un campo de tipo BigInteger y sin signo, pero ademas si llamamos este metodo para crear un nuevo campo
            // nos permite llamar al metodo de "Constrained" con este le agregamos las restricciones de "references" y "on", esto lo puede lograr porque seguimos la convencion de llamar "user_id"
            // donde sabe que tiene que buscar la tabla "users" y el campo "id" (NombreTablaSingular_NombreCampo)
            $table->foreignId('user_id')
                ->constrained()
                // Que pasaria creamos un articulo y se le asigna su usuario con su ID, pero resulta que depues ese usuario con ese ID se elimina
                // entonces nos quedariamos con un Post que no tendria ningun usuario porque ya no existe el asignado, entonces cuando eliminemos un
                // usuario que tiene asignado un Post, tambien se elimine el post en cuestion, asi que le especificamos que se elimine en cascada
                //->onDelete('cascade');
                ->cascadeOnDelete() // Esto es lo mismo que el metodo de arriba

                // ->onDelete('set null');
                // Con este metodo cuando se elimine un usuario va a ocurrir que en el campo donde el Post tenia asignado el usuario se le asignara un NULL
                // Para usar este metodo tenemos que asignarle antes la propiedad: ->nullable()

                // Supongamos que el Post ya tenia asignado un usuario con su ID, pero luego ese usuario modifica su ID por lo tanto cambia su valor
                // Entonces en esta tabla estariamos haciendo referencia a un usuario que no existe, entonces hay que lograr que cuando se modifique la llave primaria
                // tambien se modifique en esta tabla
                ->onUpdate('cascade');

            // Relacionamos esta tabla con la tabla Categorias
            $table->foreignId('category_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            // Hay que saber que no podremos crear una relacion a tablas que no hemos creado todavia, asi que tenemos que tener creada estas tablas antes
            // si no tenemos la tabla creada pero si la migracion entonces tenemos que cambiar el orden en el que se ejecutan las migraciones
            // remplazando en el nombre, los numeros de las fechas

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts2');
    }
};
