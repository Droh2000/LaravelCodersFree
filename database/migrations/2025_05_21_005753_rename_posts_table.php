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
        // llamamos el metodo para cambiarle el nombre, le pasamos el nombre de la tabla que queremos renombrar
        // el segundo parametro es el nuevo nombre
        Schema::rename('posts', 'articles');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('articles', 'posts');
    }
};
