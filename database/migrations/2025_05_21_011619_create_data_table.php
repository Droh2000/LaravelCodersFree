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
        Schema::create('data', function (Blueprint $table) {
            // Por defecto es entero, autoincrementable, llave primaria y el nombre es ID
            $table->id();

            // Valores Entero
            $table->integer('user_id');
            // Aumentar el Rango de numeros
            $table->bigInteger('user2_id');

            // Datos Booleanos (Esto convertido a un dato de MySQL es de tipo TinyInt)
            $table->boolean('is_active');

            // Almacenar Fecha y hora
            $table->dateTime('created');
            // Solo la Fecha
            $table->date('created2');

            // Valores Decimales (Nombrecolumna, Precicion, NumeroDeDigitos)
            $table->decimal('amount', 8, 2);
            // Para valores mas grandes
            $table->double('amount', 8, 2);
            $table->float('amount', 8, 2);

            // Campos Enum para que solo determinadas opciones puedan estar registradas
            // Entre el Array le pasamos los posibles valores que puede tener
            $table->enum('status', ['active', 'inactive']);

            // Cuando queramos crear campos que sean muy grandes y no sean positivos
            // Asi se crean una llave foreana
            $table->foreignId('category_id');

            // Para almacenar un array de Datos
            $table->json('data');

            // Datos de tipo String Le podemos poner solo el nombre del campo y tambien la cantidad de caracteres que queremos permitir
            $table->string('name'); // 255 caracteres
            $table->string('name2', 20);

            // Campos de texto mas grandes
            $table->text('description');// 65535 characters
            $table->mediumText('content');// 16777215 Characters
            $table->longText('text');// 4294967295 characters

            // Para relaciones polimorficas
            $table->morphs('taggable');
            // Lo que ocurre es que apartir de este nos crea dos campos que son NombreCampo_id y NombreCampo_type

            // Almacenar fechas
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data');
    }
};
