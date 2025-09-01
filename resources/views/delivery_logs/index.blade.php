@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Delivery Logs pour le stop : {{ $stop->address ?? 'Coordonnées' }}</h1>
        <a href="{{ route('routes.stops.delivery_logs.create', [$route, $stop]) }}" class="bg-primary text-white px-4 py-2 rounded hover:bg-orange-500">Ajouter Log</a>
    </div>

    @if($logs->count())
        <table class="w-full border border-gray-200 rounded">
            <thead class="bg-primary text-white">
            <tr>
                <th class="px-4 py-2">Date de livraison</th>
                <th class="px-4 py-2">Statut</th>
                <th class="px-4 py-2">Notes</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($logs as $log)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $log->delivered_at }}</td>
                    <td class="px-4 py-2">{{ ucfirst($log->status) }}</td>
                    <td class="px-4 py-2">{{ $log->notes ?? '-' }}</td>
                    <td class="px-4 py-2 text-center space-x-2">
                        <a href="{{ route('routes.stops.delivery_logs.edit', [$route, $stop, $log]) }}" class="text-yellow-600 hover:underline">Éditer</a>
                        <form action="{{ route('routes.stops.delivery_logs.destroy', [$route, $stop, $log]) }}" method="POST" class="inline-block" onsubmit="return confirm('Supprimer ce log ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>Aucun log défini pour ce stop.</p>
    @endif

    <div class="mt-4">
        <a href="{{ route('routes.stops.index', $route) }}" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Retour aux stops</a>
    </div>
@endsection
