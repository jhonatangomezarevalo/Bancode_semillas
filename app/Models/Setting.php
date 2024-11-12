<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    // Nombre de la tabla asociada al modelo
    protected $table = 'settings';

    // Campos que pueden ser asignados en masa (mass-assignment)
    protected $fillable = [
        'user_id',     // Relacionado con el usuario (opcional)
        'key',         // Clave de configuración (ejemplo: 'notification_emails')
        'value',       // Valor de la configuración
    ];

    // Definir la relación con el modelo User (si las configuraciones son específicas del usuario)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Si prefieres que las configuraciones sean globales y no específicas del usuario, omite esta relación.
}
