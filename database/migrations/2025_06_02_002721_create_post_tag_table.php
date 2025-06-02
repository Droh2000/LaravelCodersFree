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
        Schema::create('post_tag', function (Blueprint $table) {
            $table->id();
            // Aqui almacenamos las llavez foraneas
            $table->foreignId('post_id')
                   ->constrained()
                   ->onDelete('cascade');
            $table->foreignId('tag_id')
                   ->constrained()
                   ->onDelete('cascade');
            // Vamos a suponer que queremos generar un campo mas
            $table->string('data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_tag');
    }
};
