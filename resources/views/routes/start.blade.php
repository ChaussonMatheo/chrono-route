@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Lancer la route : {{ $route->name }}</h1>

    <div class="flex gap-4">
        {{-- Carte --}}
        <div id="map" class="w-2/3 h-[600px] rounded shadow"></div>

        {{-- Liste des stops --}}
        <div class="w-1/3 h-[600px] overflow-auto border rounded p-4">
            <h2 class="text-lg font-bold mb-2">Stops</h2>
            <ul id="stop-list" class="space-y-2">
                @foreach($stops as $stop)
                    <li id="stop-{{ $stop->id }}" class="px-2 py-1 border rounded {{ $stop->delivered ? 'bg-green-200' : 'bg-gray-100' }}">
                        {{ $stop->order }} - {{ $stop->address }} - <span class="status">{{ $stop->delivered ? 'Livré' : 'Non livré' }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <p id="status" class="mt-4 font-medium"></p>
    <button id="finish-route" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-500 mt-4">Terminer la route</button>

    {{-- Leaflet & Routing Machine --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.min.js"></script>

    <script>
        const stops = @json($stops);
        const routeId = {{ $route->id }};

        const map = L.map('map').setView([46.6, 2.5], 6);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Création des markers stops
        const stopMarkers = stops.map(stop => {
            const marker = L.marker([stop.latitude, stop.longitude]).addTo(map);
            marker.bindPopup(`<strong>${stop.address}</strong><br>Ordre: ${stop.order}<br>Livré: ${stop.delivered ? 'Oui' : 'Non'}`);
            return {stop, marker};
        });

        // Fonction pour dessiner la route avec parties livrées et non livrées
        let routingControl = null;
        function drawRoute() {
            if(routingControl) map.removeControl(routingControl);

            const delivered = stopMarkers.filter(s => s.stop.delivered).map(s => L.latLng(s.stop.latitude, s.stop.longitude));
            const remaining = stopMarkers.filter(s => !s.stop.delivered).map(s => L.latLng(s.stop.latitude, s.stop.longitude));

            const waypoints = delivered.concat(remaining);
            if(waypoints.length < 2) return;

            routingControl = L.Routing.control({
                waypoints: waypoints,
                lineOptions: {
                    styles: [
                        {color: 'green', opacity: 0.8, weight: 5}, // Partie livrée
                        {color: 'orange', opacity: 0.8, weight: 5} // Partie restante
                    ]
                },
                createMarker: () => null,
                addWaypoints: false,
                draggableWaypoints: false,
                routeWhileDragging: false,
                show: false,
                router: L.Routing.osrmv1({ serviceUrl: 'https://router.project-osrm.org/route/v1' })
            }).addTo(map);
        }
        drawRoute();

        // Ajuster la vue pour tous les stops
        const group = L.featureGroup(stopMarkers.map(s => s.marker));
        map.fitBounds(group.getBounds().pad(0.2));
        const gpsZoom = 17; // zoom rapproché pour style GPS
        const gpsBearing = 0; // si tu veux faire tourner la carte, sinon laisser 0
        // GPS live et marquage automatique des stops
        let userMarker;
        if (navigator.geolocation) {
            navigator.geolocation.watchPosition(async position => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                if(!userMarker){
                    userMarker = L.marker([lat, lng], {
                        icon: L.icon({iconUrl: 'https://cdn-icons-png.flaticon.com/512/64/64113.png', iconSize: [32,32]})
                    }).addTo(map);
                    map.setView([lat,lng], gpsZoom);
                } else {
                    userMarker.setLatLng([lat, lng]);
                    // Centrer la carte sur le livreur à chaque mise à jour
                    map.setView([lat,lng], gpsZoom);
                }

                document.getElementById('status').textContent = `Votre position : ${lat.toFixed(5)}, ${lng.toFixed(5)}`;

                // Vérifier les stops proches
                for(const {stop, marker} of stopMarkers){
                    if(!stop.delivered){
                        const distance = map.distance([lat,lng], [stop.latitude, stop.longitude]);
                        if(distance < 50){
                            stop.delivered = true;
                            marker.bindPopup(`<strong>${stop.address}</strong><br>Ordre: ${stop.order}<br>Livré: Oui`);
                            marker.setIcon(L.icon({iconUrl: 'https://cdn-icons-png.flaticon.com/512/190/190411.png', iconSize: [32,32]}));

                            // Liste latérale
                            const li = document.getElementById(`stop-${stop.id}`);
                            li.classList.replace('bg-gray-100','bg-green-200');
                            li.querySelector('.status').textContent = 'Livré';

                            // Redessiner la route
                            drawRoute();

                            await fetch(`/routes/${routeId}/stops/${stop.id}/deliver`, {
                                method: 'POST',
                                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
                            });
                        }
                    }
                }

            }, err => console.error(err), {enableHighAccuracy:true, maximumAge:0});
        } else {
            alert('Votre navigateur ne supporte pas la géolocalisation');
        }

        // Bouton Terminer la route
        document.getElementById('finish-route').addEventListener('click', () => {
            if(confirm('Terminer la route ?')){
                window.location.href = "{{ route('routes.index') }}";
            }
        });
    </script>

@endsection
