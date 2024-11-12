<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comentario extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'comentario', 'user_id', 'semilla_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function semilla()
    {
        return $this->belongsTo(Semilla::class);
    }
}
