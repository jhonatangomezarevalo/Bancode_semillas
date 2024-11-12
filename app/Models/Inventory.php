<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'sowing_distance',
        'sowing_depth',
        'base_info',
        'adaptable_info',
        'traceability_info',
        'image_path',
        'user_id',
        'disponible',
    ];

    /**
     * Define la relación con el modelo User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
