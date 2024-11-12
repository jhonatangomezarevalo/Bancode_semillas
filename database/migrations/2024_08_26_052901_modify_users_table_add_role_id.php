<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyUsersTableAddRoleId extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Eliminar el campo 'role' si existe
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }

            // Agregar el campo 'role_id' con la llave foránea
            $table->unsignedBigInteger('role_id')->nullable(); // Campo role_id, puede ser nullable si no es obligatorio
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revertir los cambios: eliminar la columna 'role_id' y agregar la columna 'role'
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
            $table->string('role')->nullable(); // Agregar de nuevo el campo 'role' si es necesario
        });
    }
}