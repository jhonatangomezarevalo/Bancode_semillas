<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // Tipo de semilla
            $table->string('sowing_distance')->nullable(); // Distancia de siembra
            $table->string('sowing_depth')->nullable(); // Profundidad de siembra
            $table->text('characteristics')->nullable(); // Características generales
            $table->text('description')->nullable(); // Descripción
            $table->text('gastronomic_uses')->nullable(); // Usos gastronómicos
            $table->text('medicinal_uses')->nullable(); // Usos medicinales
            $table->text('environmental_characteristics')->nullable(); // Características ambientales
            $table->text('pests')->nullable(); // Plagas
            $table->text('pest_resistance')->nullable(); // Resistencia a plagas
            $table->text('care')->nullable(); // Cuidados
            $table->string('image_path')->nullable(); // Ruta de la imagen
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relación con la tabla users
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventories');
    }
}

