<?php

namespace App\Http\Controllers;

use App\Models\Stop;
use App\Models\Route;
use Illuminate\Http\Request;

class StopController extends Controller
{
    /**
     * Liste des stops pour une route donnée.
     */
    public function index(Route $route)
    {
        $stops = $route->stops()->orderBy('order')->get();
        return view('stops.index', compact('route', 'stops'));
    }

    /**
     * Formulaire pour créer un stop.
     */
    public function create(Route $route)
    {
        return view('stops.create', compact('route'));
    }

    /**
     * Enregistrer un stop pour une route.
     */
    public function store(Request $request, Route $route)
    {
        $validated = $request->validate([
            'address' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'order' => 'required|integer|min:1',
            'delivered' => 'boolean',
        ]);

        $validated['route_id'] = $route->id;

        Stop::create($validated);

        return redirect()->route('routes.stops.index', $route)
            ->with('success', 'Point ajouté avec succès !');
    }

    /**
     * Afficher un stop.
     */
    public function show(Route $route, Stop $stop)
    {
        return view('stops.show', compact('route', 'stop'));
    }

    /**
     * Formulaire d’édition d’un stop.
     */
    public function edit(Route $route, Stop $stop)
    {
        return view('stops.edit', compact('route', 'stop'));
    }

    /**
     * Mettre à jour un stop.
     */
    public function update(Request $request, Route $route, Stop $stop)
    {
        $validated = $request->validate([
            'address' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'order' => 'required|integer|min:1',
            'delivered' => 'boolean',
        ]);

        $stop->update($validated);

        return redirect()->route('stops.index', $route)
            ->with('success', 'Point mis à jour avec succès !');
    }

    /**
     * Supprimer un stop.
     */
    public function destroy(Route $route, Stop $stop)
    {
        $stop->delete();

        return redirect()->route('routes.stops.index', $route)
            ->with('success', 'Point supprimé avec succès !');
    }
    public function markDelivered(Route $route, Stop $stop)
    {
        $stop->update(['delivered' => true]);
        return response()->json(['success' => true]);
    }
}
