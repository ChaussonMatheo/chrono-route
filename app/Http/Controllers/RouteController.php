<?php


namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    /**
     * Afficher toutes les routes.
     */
    public function index()
    {
        $routes = Route::withCount('stops')->paginate(10);
        return view('routes.index', compact('routes'));
    }

    /**
     * Formulaire de création d'une route.
     */
    public function create()
    {
        return view('routes.create');
    }

    /**
     * Enregistrer une nouvelle route.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'scheduled_date' => 'nullable|date',
        ]);

        $validated['user_id'] = auth()->id(); // assigner au user connecté

        Route::create($validated);

        return redirect()->route('routes.index')->with('success', 'Route créée avec succès !');
    }

    /**
     * Afficher une route.
     */
    public function show(Route $route)
    {
        $route->load('stops');
        return view('routes.show', compact('route'));
    }

    /**
     * Formulaire de modification d'une route.
     */
    public function edit(Route $route)
    {
        return view('routes.edit', compact('route'));
    }

    /**
     * Mettre à jour une route.
     */
    public function update(Request $request, Route $route)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'scheduled_date' => 'nullable|date',
        ]);

        $route->update($validated);

        return redirect()->route('routes.index')->with('success', 'Route mise à jour avec succès !');
    }

    /**
     * Supprimer une route.
     */
    public function destroy(Route $route)
    {
        $route->delete();

        return redirect()->route('routes.index')->with('success', 'Route supprimée avec succès !');
    }
    public function start(Route $route)
    {

        $stops = $route->stops()->orderBy('order')->get();
        foreach ($stops as $stop) {
            $stop->delivered = false;
            $stop->save();
        }
        return view('routes.start', compact('route', 'stops'));
    }


}
