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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();

            $table->string('job');
            $table->string('phone');
            $table->string('website');

            // Creamos la llave foranea
            $table->foreignId('user_id')
                   ->constrained() // Para que nos genera las restricciones
                   ->onDelete('cascade'); // Para que si se elimina el usuario tambien se elimine su Profile

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
