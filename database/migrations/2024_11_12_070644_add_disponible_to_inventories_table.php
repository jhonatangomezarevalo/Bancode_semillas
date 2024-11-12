<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDisponibleToInventoriesTable extends Migration
{
    public function up()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->enum('disponible', ['Sí', 'No'])->default('Sí'); // Agregamos el campo con valores 'Sí' o 'No'
        });
    }

    public function down()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn('disponible'); // Eliminamos el campo si se revierte la migración
        });
    }
}
