<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $inventoryId)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        // Crear el comentario
        Comment::create([
            'user_id' => Auth::id(),
            'inventory_id' => $inventoryId,
            'comment' => $request->comment,
            'parent_id' => null, // No es una respuesta
        ]);

        return back(); // Redirigir de vuelta a la publicación de semilla
    }

    public function reply(Request $request, $inventoryId, $commentId)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        // Crear la respuesta al comentario
        Comment::create([
            'user_id' => Auth::id(),
            'inventory_id' => $inventoryId,
            'comment' => $request->comment,
            'parent_id' => $commentId, // Indicar que es una respuesta
        ]);

        return back(); // Redirigir de vuelta a la publicación de semilla
    }
}
