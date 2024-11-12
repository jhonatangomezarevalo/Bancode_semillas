<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Asignar permisos al rol de administrador (ID 6)
        $role = Role::find(6);
        $permissions = Permission::whereIn('name', ['ver_reportes', 'editar_usuarios'])->get();

        $role->permissions()->sync($permissions->pluck('id')->toArray()); // Sincroniza los permisos al rol
    }
}
