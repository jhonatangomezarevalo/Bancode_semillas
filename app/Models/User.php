<?php  

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'ubicacion',
        'municipio',
        'nombre_finca',
        'nombre_custodio',
        'nombre_casa_semillas',
        'institucion_educativa',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function posts()
    {
        return $this->hasMany(Inventory::class, 'user_id');
    }

    public function Sentmessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function Receivedmessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
}
