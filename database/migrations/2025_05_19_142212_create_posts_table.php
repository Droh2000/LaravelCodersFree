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
            $table->id();
            // Estos son los campos que tendria esta tabla Posts
            // Podemos limitar la cantidad de caracteres que queremos especificando el numero que queremos permitir
            $table->string('title', 15);
            $table->string('slug'); // El SLUG es la URL donde se muestra el titulo separado por guiones
            $table->longText('body');// Supongamos que despues de ejecutar las migraciones un campo de la tabla lo definimos mal y tenemos que modificarlo
            $table->timestamps();
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
