<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    // Si el nombre de la tabla no sigue la convención plural
    protected $table = 'permissions';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = ['name', 'guard_name'];

    // Otros métodos o relaciones que necesites agregar

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }
}
