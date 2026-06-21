<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\Tiporeceta;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RecetaController extends Controller
{
    /**
     * Listar recetas con filtros aplicados.
     */
    public function index(Request $request)
    {
        $query = Receta::with('tiporeceta');

        // Filtrar por nombre
        if ($request->filled('nombre')) {
            $query->where('nombre_recetas', 'like', '%' . $request->nombre . '%');
        }

        // Filtrar por tipo
        if ($request->filled('id_tiporeceta')) {
            $query->where('id_tiporeceta', $request->id_tiporeceta);
        }

        // Filtrar por dificultad
        if ($request->filled('dificultad')) {
            $query->where('dificultad', $request->dificultad);
        }

        // Filtrar por fecha
        if ($request->filled('fecha')) {
            $query->whereDate('created_at', $request->fecha);
        }

        return Inertia::render('Recipes/Index', [
            'recipes' => $query->latest()->get(),
            'tipos'   => Tiporeceta::all(),
            'filters' => $request->only(['nombre', 'id_tiporeceta', 'dificultad', 'fecha'])
        ]);
    }

    /**
     * Guardar una nueva receta.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_recetas' => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'id_tiporeceta'  => 'required|exists:tiporecetas,id',
            'dificultad'     => 'required|in:fácil,media,difícil',
        ]);

        Receta::create($validated);

        return redirect()->back()->with('success', '¡Receta guardada con éxito!');
    }

    /**
     * Actualizar una receta existente.
     */
    public function update(Request $request, Receta $receta)
    {
        $validated = $request->validate([
            'nombre_recetas' => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'id_tiporeceta'  => 'required|exists:tiporecetas,id',
            'dificultad'     => 'required|in:fácil,media,difícil',
        ]);

        $receta->update($validated);

        return redirect()->back()->with('success', 'Receta actualizada correctamente.');
    }

    /**
     * Eliminar una receta.
     */
    public function destroy(Receta $receta)
    {
        $receta->delete();
        return redirect()->back()->with('success', 'Receta eliminada.');
    }
}
