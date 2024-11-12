<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Inventory;
use App\Models\User;

class ProfileController extends Controller
{
    public function show()
    {
        // Obtiene el usuario autenticado
        $user = Auth::user(); 

        // Obtiene las semillas (inventarios) del usuario
        $inventories = Inventory::where('user_id', $user->id)->get(); 

        // Pasa las variables a la vista
        return view('profile.show', compact('user', 'inventories'));
    }

    public function showUser($id)
    {
        $user = User::findOrFail($id); // Obtener el usuario por ID
        $inventories = Inventory::where('user_id', $id)->get(); // Obtener las semillas del usuario

        return view('profile.show_user', compact('user', 'inventories'));
    }
}
