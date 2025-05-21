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
        Schema::table('post', function (Blueprint $table) {
            // Eliminar Indices
            // Le especificamos el nombre de la llave que estas siempre tienen la misma estructura del su nombre
            // NombreTabla_Campo_TipoLlave
            $table->dropUnique('posts_slug_unique');

            // Eliminamos este otro indice
            $table->dropIndex('posts_title_index');

            $table->dropFullText('posts_body_fulltext');

            // Si queremos eliminar el indice Primary del ID
            $table->dropPrimary('PRIMARY');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post', function (Blueprint $table) {
            // Lo contrario seria agregar la llave Unique al campo Slug
            $table->unique('slug');
            $table->index('title');
            $table->fullText('body');
        });
    }
};
