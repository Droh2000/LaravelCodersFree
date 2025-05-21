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
        // Llamamos el metodo para eliminar pasandole el nombre de la tabla a eliminar
        // Schema::drop('posts');
        // Esto es lo mismo que el metodo de arriba pero primero verifica que exista para despues borrar
        Schema::dropIfExists('posts');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertimos los cambios
        Schema::create('posts', function( Blueprint $table ){
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('body');
            $table->timestamp('published_at');
            $table->timestamps();
        });
    }
};
