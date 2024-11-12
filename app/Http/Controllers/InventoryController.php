<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;

class InventoryController extends Controller
{
    public function index()
    {
        // Obtén todas las semillas del usuario autenticado
        $inventories = Inventory::where('user_id', auth()->id())->get();
        return view('inventory.index', compact('inventories'));
    }

    public function create()
    {
        return view('inventory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'base_info' => 'nullable|string',
            'adaptable_info' => 'nullable|string',
            'traceability_info' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'disponible' => 'required|in:sí,no', // Validar si 'disponible' es sí o no
        ]);

        $inventory = new Inventory();
        $inventory->name = $request->name;
        $inventory->type = $request->type;
        $inventory->base_info = $request->base_info;
        $inventory->adaptable_info = $request->adaptable_info;
        $inventory->traceability_info = $request->traceability_info;
        $inventory->user_id = auth()->id(); // Asociar el usuario autenticado
        $inventory->is_visible = true; // Por defecto, las semillas son visibles
        $inventory->disponible = $request->disponible; // Guardar la disponibilidad

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('images', 'public');
            $inventory->image_path = $imagePath;
        }

        $inventory->save();

        return redirect()->route('inventory.index')->with('success', 'Semilla agregada exitosamente.');
    }

    public function edit($id)
    {
        $inventory = Inventory::findOrFail($id);
        return view('inventory.edit', compact('inventory'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'base_info' => 'nullable|string',
            'adaptable_info' => 'nullable|string',
            'traceability_info' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'disponible' => 'required|in:sí,no', // Validar si 'disponible' es sí o no
        ]);

        $inventory = Inventory::findOrFail($id);
        $inventory->name = $request->name;
        $inventory->type = $request->type;
        $inventory->base_info = $request->base_info;
        $inventory->adaptable_info = $request->adaptable_info;
        $inventory->traceability_info = $request->traceability_info;
        $inventory->disponible = $request->disponible; // Actualizar la disponibilidad

        if ($request->hasFile('image')) {
            // Elimina la imagen antigua si existe
            if ($inventory->image_path) {
                \Storage::disk('public')->delete($inventory->image_path);
            }
            $image = $request->file('image');
            $imagePath = $image->store('images', 'public');
            $inventory->image_path = $imagePath;
        }

        $inventory->save();

        return redirect()->route('inventory.index')->with('success', 'Semilla actualizada con éxito.');
    }

    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);

        // Elimina la imagen si existe
        if ($inventory->image_path) {
            \Storage::disk('public')->delete($inventory->image_path);
        }

        $inventory->delete();

        return redirect()->route('inventory.index')->with('success', 'Semilla eliminada con éxito.');
    }

    public function toggleVisibility($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->is_visible = !$inventory->is_visible; // Cambia el estado de visibilidad
        $inventory->save(); // Guarda los cambios

        return response()->json(['success' => true, 'newVisibility' => $inventory->is_visible]);
    }

    public function feed(Request $request)
{
    $searchQuery = $request->input('query'); // Cambié el nombre de la variable a $searchQuery
    $disponibilidad = $request->input('disponibilidad', ''); // Obtener el filtro de disponibilidad, si existe

    $inventories = Inventory::when($disponibilidad, function ($query) use ($disponibilidad) {
        return $query->where('disponible', $disponibilidad);
    })
    ->where('is_visible', true)
    ->when($searchQuery, function ($query) use ($searchQuery) { // Aquí usamos $searchQuery
        return $query->where('name', 'like', "%{$searchQuery}%")
                     ->orWhere('type', 'like', "%{$searchQuery}%")
                     ->orWhere('base_info', 'like', "%{$searchQuery}%")
                     ->orWhere('adaptable_info', 'like', "%{$searchQuery}%")
                     ->orWhere('traceability_info', 'like', "%{$searchQuery}%");
    })
    ->latest()
    ->paginate(10);

    return view('feed.index', compact('inventories', 'searchQuery', 'disponibilidad'));
}


    public function profile()
    {
        $user = auth()->user();
        $inventories = $user->inventories()->where('is_visible', true)->get(); // Obtener semillas visibles del usuario
        return view('profile.show', compact('user', 'inventories'));
    }
}
