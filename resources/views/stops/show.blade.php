@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Stop : {{ $stop->address ?? 'Coordonnées' }}</h1>

    <p><strong>Latitude :</strong> {{ $stop->latitude ?? '-' }}</p>
    <p><strong>Longitude :</strong> {{ $stop->longitude ?? '-' }}</p>
    <p><strong>Ordre :</strong> {{ $stop->order }}</p>
    <p><strong>Livré :</strong> {{ $stop->delivered ? 'Oui' : 'Non' }}</p>

    <div class="mt-4 space-x-2">
        <a href="{{ route('routes.stops.index', $route) }}" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Retour aux stops</a>
        <a href="{{ route('routes.stops.edit', [$route, $stop]) }}" class="bg-primary text-white px-4 py-2 rounded hover:bg-orange-500">Éditer</a>
    </div>
@endsection
