<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nombre_finca')->nullable(); // Para Agricultor
            $table->string('nombre_custodio')->nullable(); // Para Custodio
            $table->string('nombre_casa_semillas')->nullable(); // Para Casa de Semillas
            $table->string('institucion_educativa')->nullable(); // Para Estudiante y Docente Académico
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nombre_finca', 'nombre_custodio', 'nombre_casa_semillas', 'institucion_educativa']);
        });
    }
}
