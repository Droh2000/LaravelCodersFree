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
        // Por la convencion con el que creamos el archivo de migracion ya nos genera este archivo
        // Vemos que aqui no es Schema::create sino que es ::table para modificar una tabla
        Schema::table('posts', function (Blueprint $table) {
            // Queremos agregarle un nuevo campo a la tabla y por defecto se va a agregar al final
            $table->string('slug')
            ->nullable() // Para que en donde haya registros nos ponga el Null y los acepte sin problemas
            ->after('title') // Para que el nuevo campo no se agrege al final de todos los campos,si no que se agrege despues de cierta columna
            ->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Tambien le ponemos para reviertir el campo
            $table->dropColumn('slug');
        });
    }
};
