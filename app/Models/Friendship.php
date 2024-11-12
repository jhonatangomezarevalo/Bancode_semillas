<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'friend_id', 'status'];

    // Relación de muchos a muchos usando la tabla de pivote 'friendships'
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function friend()
    {
        return $this->belongsTo(User::class, 'friend_id');
    }

    // Verificar si una amistad ya existe
    public static function friendshipExists($userId, $friendId)
    {
        return self::where(function ($query) use ($userId, $friendId) {
            $query->where('user_id', $userId)
                  ->where('friend_id', $friendId);
        })->orWhere(function ($query) use ($userId, $friendId) {
            $query->where('user_id', $friendId)
                  ->where('friend_id', $userId);
        })->exists();
    }

    // Relación muchos a muchos a través de la tabla de pivote `friendships`
    public function mutualFriends(User $user)
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
                    ->wherePivot('status', 'accepted')
                    ->where(function ($query) use ($user) {
                        $query->where('friend_id', $user->id)
                              ->orWhere('user_id', $user->id);
                    });
    }
}
