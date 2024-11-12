<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInventoriesTable extends Migration
{
    public function up()
    {
        Schema::table('inventories', function (Blueprint $table) {
            // Agregar nuevas columnas
            $table->text('base_info')->nullable()->after('type'); // Información Base
            $table->text('adaptable_info')->nullable()->after('base_info'); // Información Adaptable
            $table->text('traceability_info')->nullable()->after('adaptable_info'); // Información de Trazabilidad
            
            // Puedes eliminar la columna de `characteristics` si ya no es necesaria
            // $table->dropColumn('characteristics');
        });
    }

    public function down()
    {
        Schema::table('inventories', function (Blueprint $table) {
            // Eliminar columnas si necesitas revertir los cambios
            $table->dropColumn('base_info');
            $table->dropColumn('adaptable_info');
            $table->dropColumn('traceability_info');
        });
    }
}
