<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Semilla extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre', 'tipo', 'descripcion', 'suelo', 'tiempo', 'cantidad_gramos', 'foto', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }
}
