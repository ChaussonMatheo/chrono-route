<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Stop;
use App\Models\DeliveryLog;
use Illuminate\Http\Request;

class DeliveryLogController extends Controller
{
    /**
     * Liste des logs pour un stop.
     */
    public function index(Route $route, Stop $stop)
    {
        $logs = $stop->deliveryLogs()->latest()->get();
        return view('delivery_logs.index', compact('route', 'stop', 'logs'));
    }

    /**
     * Formulaire pour ajouter un log.
     */
    public function create(Route $route, Stop $stop)
    {
        return view('delivery_logs.create', compact('route', 'stop'));
    }

    /**
     * Enregistrer un log.
     */
    public function store(Request $request, Route $route, Stop $stop)
    {
        $validated = $request->validate([
            'delivered_at' => 'required|date',
            'status' => 'required|in:success,failed,absent',
            'notes' => 'nullable|string',
        ]);

        $validated['stop_id'] = $stop->id;

        DeliveryLog::create($validated);

        return redirect()->route('routes.stops.delivery_logs.index', [$route, $stop])
            ->with('success', 'Log ajouté avec succès !');
    }

    /**
     * Afficher un log.
     */
    public function show(Route $route, Stop $stop, DeliveryLog $deliveryLog)
    {
        return view('delivery_logs.show', compact('route', 'stop', 'deliveryLog'));
    }

    /**
     * Formulaire d’édition d’un log.
     */
    public function edit(Route $route, Stop $stop, DeliveryLog $deliveryLog)
    {
        return view('delivery_logs.edit', compact('route', 'stop', 'deliveryLog'));
    }

    /**
     * Mettre à jour un log.
     */
    public function update(Request $request, Route $route, Stop $stop, DeliveryLog $deliveryLog)
    {
        $validated = $request->validate([
            'delivered_at' => 'required|date',
            'status' => 'required|in:success,failed,absent',
            'notes' => 'nullable|string',
        ]);

        $deliveryLog->update($validated);

        return redirect()->route('routes.stops.delivery_logs.index', [$route, $stop])
            ->with('success', 'Log mis à jour avec succès !');
    }

    /**
     * Supprimer un log.
     */
    public function destroy(Route $route, Stop $stop, DeliveryLog $deliveryLog)
    {
        $deliveryLog->delete();

        return redirect()->route('routes.stops.delivery_logs.index', [$route, $stop])
            ->with('success', 'Log supprimé avec succès !');
    }
}
