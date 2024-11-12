<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'inventory_id', 'comment', 'parent_id'];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con la publicación de semilla (inventory)
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    // Relación con los comentarios respondidos
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // Relación con las respuestas (comentarios que son respuestas)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
