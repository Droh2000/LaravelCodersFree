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
            // En nuestra tabla tenemos un campo con un tipo de dato que ocupa mucho espacio y lo queremos cambiar a uno que ocupe menos tamano
            // La creamos con el nuevo tipo de dato, mismo nombre
            $table->mediumText('body')
                // Tenemos que especificar todos los modificadores que queramos mantener porque si no los especificamos nos los quitara
                ->nullable()
                ->change(); // Asi le decimos que modifique la columna con las nuevas propiedades especificadas

            // Cambiar el nombre de una columna (Nombre Actual y Nombre Nuevo)
            $table->renameColumn('title', 'contentSort');

            // Eliminar Columnas
            $table->dropColumn('slug');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Ponemos la columna a sus modificadores originales
            $table->longText('body')
                ->change();
            // Revertimos los cambiones ponendo en lo opuesto
            $table->renameColumn('contentSort', 'title');

            $table->string('slug')->unique();
        });
    }
};
