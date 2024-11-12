<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Semilla;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Semilla $semilla)
    {
        $validatedData = $request->validate([
            'comentario' => 'required|max:1000',
        ]);

        $comentario = new Comentario($validatedData);
        $comentario->user_id = auth()->id();
        $comentario->semilla_id = $semilla->id;
        $comentario->save();

        return redirect()->route('semillas.show', $semilla->id)->with('success', 'Comentario añadido exitosamente.');
    }

    public function destroy(Comentario $comentario)
    {
        $this->authorize('delete', $comentario);
        
        $semilla_id = $comentario->semilla_id;
        $comentario->delete();
        
        return redirect()->route('semillas.show', $semilla_id)->with('success', 'Comentario eliminado exitosamente.');
    }
}