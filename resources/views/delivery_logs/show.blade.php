@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Log du stop : {{ $stop->address ?? 'Coordonnées' }}</h1>

    <p><strong>Date et heure :</strong> {{ $deliveryLog->delivered_at }}</p>
    <p><strong>Statut :</strong> {{ ucfirst($deliveryLog->status) }}</p>
    <p><strong>Notes :</strong> {{ $deliveryLog->notes ?? '-' }}</p>

    <div class="mt-4 space-x-2">
        <a href="{{ route('routes.stops.delivery_logs.index', [$route, $stop]) }}" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Retour aux logs</a>
        <a href="{{ route('routes.stops.delivery_logs.edit', [$route, $stop, $deliveryLog]) }}" class="bg-primary text-white px-4 py-2 rounded hover:bg-orange-500">Éditer</a>
    </div>
@endsection
