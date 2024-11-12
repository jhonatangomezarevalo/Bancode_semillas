<?php

namespace App\Policies;

use App\Models\Semilla;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SemillaPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Semilla $semilla)
    {
        return $user->id === $semilla->user_id;
    }

    public function delete(User $user, Semilla $semilla)
    {
        return $user->id === $semilla->user_id;
    }
}