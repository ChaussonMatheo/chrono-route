x
@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">{{ $route->name }}</h1>

    <p class="mb-2"><strong>Description :</strong> {{ $route->description ?? '-' }}</p>
    <p class="mb-4"><strong>Date prévue :</strong> {{ $route->scheduled_date ?? '-' }}</p>

    <h2 class="text-xl font-semibold mb-2">Points de distribution</h2>
    @if($route->stops->count())
        <ul class="list-disc list-inside">
            @foreach($route->stops as $stop)
                <li>{{ $stop->address ?? 'Coordonnées : ' . $stop->latitude . ', ' . $stop->longitude }}</li>
            @endforeach
        </ul>
    @else
        <p>Aucun stop défini pour cette route.</p>
    @endif

    <div class="mt-4">
        <a href="{{ route('routes.index') }}" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Retour</a>
    </div>
@endsection
