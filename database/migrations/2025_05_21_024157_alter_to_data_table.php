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
        // Como es Table vamos a modificar la tabla
        Schema::table('data', function (Blueprint $table) {
            // Poner el campo al inicio de todas las columnas que tenga la tabla
            $table->string('slug')->nullable()->first();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data', function (Blueprint $table) {
            //
            $table->dropColumn('slug');
        });
    }
};
