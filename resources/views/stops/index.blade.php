@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Stops pour la route : {{ $route->name }}</h1>
        <a href="{{ route('routes.stops.create', $route) }}" class="bg-primary text-white px-4 py-2 rounded hover:bg-orange-500">Ajouter Stop</a>
    </div>
    <div id="map" class="w-full h-96 mt-6 rounded shadow"></div>


    @if($stops->count())
        <table class="w-full border border-gray-200 rounded">
            <thead class="bg-primary text-white">
            <tr>
                <th class="px-4 py-2">Adresse</th>
                <th class="px-4 py-2">Latitude</th>
                <th class="px-4 py-2">Longitude</th>
                <th class="px-4 py-2">Ordre</th>
                <th class="px-4 py-2">Livré</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($stops as $stop)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $stop->address ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $stop->latitude ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $stop->longitude ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $stop->order }}</td>
                    <td class="px-4 py-2">{{ $stop->delivered ? 'Oui' : 'Non' }}</td>
                    <td class="px-4 py-2 text-center space-x-2">
                        <a href="{{ route('routes.stops.edit', [$route, $stop]) }}" class="text-yellow-600 hover:underline">Éditer</a>
                        <form action="{{ route('routes.stops.destroy', [$route, $stop]) }}" method="POST" class="inline-block" onsubmit="return confirm('Supprimer ce stop ?')">
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
        <p>Aucun stop défini pour cette route.</p>
    @endif

    <div class="mt-4">
        <a href="{{ route('routes.index') }}" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Retour aux routes</a>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialisation de la carte centrée sur la France
            const map = L.map('map').setView([46.6, 2.5], 6);

            // Ajouter le fond OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            // Array des stops depuis Blade
            const stops = @json($stops);

            // Ajouter chaque stop sur la carte
            stops.forEach(stop => {
                if(stop.latitude && stop.longitude){
                    const marker = L.marker([stop.latitude, stop.longitude]).addTo(map);
                    marker.bindPopup(`<strong>${stop.address ?? 'Stop'}</strong><br>Ordre: ${stop.order}<br>Livré: ${stop.delivered ? 'Oui' : 'Non'}`);
                }
            });

            // Ajuster le zoom pour inclure tous les markers
            const group = new L.featureGroup(stops.filter(s => s.latitude && s.longitude).map(s => L.marker([s.latitude, s.longitude])));
            if(group.getLayers().length > 0){
                map.fitBounds(group.getBounds().pad(0.2));
            }
        });
    </script>

@endsection
