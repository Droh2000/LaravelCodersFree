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
        Schema::table('posts', function (Blueprint $table) {
            // Al ver en nuestra BD las llaves creadas tiene un Indice creado, esto pasa porque es uno de los requisitos para poder crear llaves foranieas
            // Si queremos eliminar estas llaves foraneas, para el uso de estos metodos tenemos dos opciones, una es que le ponamos el nombre del indice que
            // se les creo, la otra opcion es colocar en un Array y dentro le pasamos el nombre del campo que tiene la llave foranea
            // Esto no nos elimina la columna, solo nos borra la relacion ForeingKey
            $table->dropForeign(['user_id']);
            $table->dropForeign(['category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Aqui solo volvemos a agregar la relacion ForeingKey no crearla como vimos antes porque eso nos creaba la columna
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('category_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
};
