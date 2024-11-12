<?php

namespace App\Http\Controllers;

use App\Models\Seed;
use Illuminate\Http\Request;

class SeedController extends Controller
{
    /**
     * Display a listing of the seeds.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtener las semillas visibles
        $seeds = Seed::where('visibility', true)->get();
        
        // Pasar las semillas a la vista
        return view('seeds.index', compact('seeds'));
    }

    /**
     * Show the form for creating a new seed.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Mostrar el formulario de creación
        return view('seeds.create');
    }

    /**
     * Store a newly created seed in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'visibility' => 'nullable|boolean',
        ]);

        // Subir la imagen
        $imagePath = $request->file('image')->store('seed_images', 'public');

        // Crear la nueva semilla
        Seed::create([
            'name' => $request->name,
            'image_path' => $imagePath,
            'visibility' => $request->has('visibility'),
        ]);

        // Redirigir a la vista de inventario con un mensaje de éxito
        return redirect()->route('seeds.index')->with('success', 'Semilla agregada exitosamente.');
    }

    /**
     * Display the specified seed.
     *
     * @param  \App\Models\Seed  $seed
     * @return \Illuminate\Http\Response
     */
    public function show(Seed $seed)
    {
        // Mostrar detalles de la semilla (opcional)
        return view('seeds.show', compact('seed'));
    }

    /**
     * Show the form for editing the specified seed.
     *
     * @param  \App\Models\Seed  $seed
     * @return \Illuminate\Http\Response
     */
    public function edit(Seed $seed)
    {
        // Mostrar el formulario de edición
        return view('seeds.edit', compact('seed'));
    }

    /**
     * Update the specified seed in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seed  $seed
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seed $seed)
    {
        // Validar la solicitud
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'visibility' => 'nullable|boolean',
        ]);

        // Actualizar la imagen si se proporciona
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('seed_images', 'public');
            $seed->update(['image_path' => $imagePath]);
        }

        // Actualizar otros campos
        $seed->update([
            'name' => $request->name,
            'visibility' => $request->has('visibility'),
        ]);

        // Redirigir a la vista de inventario con un mensaje de éxito
        return redirect()->route('seeds.index')->with('success', 'Semilla actualizada exitosamente.');
    }

    /**
     * Remove the specified seed from storage.
     *
     * @param  \App\Models\Seed  $seed
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seed $seed)
    {
        // Eliminar la semilla
        $seed->delete();

        // Redirigir a la vista de inventario con un mensaje de éxito
        return redirect()->route('seeds.index')->with('success', 'Semilla eliminada exitosamente.');
    }
}
