<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    // app/Http/Middleware/RoleMiddleware.php



    public function handle($request, Closure $next, ...$roles)
        {
            // Verificar si el usuario tiene uno de los roles permitidos
            if (!in_array(Auth::user()->role->name, $roles)) {
                abort(403, 'Acceso no autorizado');
            }

            return $next($request);
        }
    }

