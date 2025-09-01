@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Ajouter un stop pour : {{ $route->name }}</h1>

    <form action="{{ route('routes.stops.store', $route) }}" method="POST" class="max-w-lg bg-white p-6 rounded shadow">
        @csrf

        <div class="mb-4">
            <label for="address" class="block font-medium mb-1">Adresse</label>
            <input type="text" name="address" id="address" value="{{ old('address', $stop->address ?? '') }}" class="w-full border rounded px-3 py-2" autocomplete="off">
            <ul id="suggestions" class="border border-gray-300 rounded mt-1 bg-white max-h-40 overflow-auto hidden"></ul>
        </div>

        <div class="mb-4">
            <label for="latitude" class="block font-medium mb-1">Latitude</label>
            <input type="text" name="latitude" id="latitude" value="{{ old('latitude', $stop->latitude ?? '') }}" class="w-full border rounded px-3 py-2" readonly>
        </div>

        <div class="mb-4">
            <label for="longitude" class="block font-medium mb-1">Longitude</label>
            <input type="text" name="longitude" id="longitude" value="{{ old('longitude', $stop->longitude ?? '') }}" class="w-full border rounded px-3 py-2" readonly>
        </div>

        <div class="mb-4">
            <label for="order" class="block font-medium mb-1">Ordre</label>
            <input type="number" name="order" id="order" value="{{ old('order', 1) }}" class="w-full border rounded px-3 py-2" min="1">
        </div>

        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="delivered" class="form-checkbox text-primary" {{ old('delivered') ? 'checked' : '' }}>
                <span class="ml-2">Livré</span>
            </label>
        </div>

        <button type="submit" class="bg-primary text-white px-4 py-2 rounded hover:bg-orange-500">Ajouter Stop</button>
    </form>
    <script>
        const addressInput = document.getElementById('address');
        const suggestions = document.getElementById('suggestions');

        let timeout = null;

        addressInput.addEventListener('input', function() {
            clearTimeout(timeout);
            const query = this.value;
            if(query.length < 3){
                suggestions.innerHTML = '';
                suggestions.classList.add('hidden');
                return;
            }

            timeout = setTimeout(() => {
                fetch(`https://nominatim.openstreetmap.org/search?format=json&addressdetails=1&countrycodes=fr&q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        suggestions.innerHTML = '';
                        if(data.length === 0){
                            suggestions.classList.add('hidden');
                            return;
                        }

                        data.forEach(place => {
                            const li = document.createElement('li');
                            li.textContent = place.display_name;
                            li.classList.add('px-2', 'py-1', 'cursor-pointer', 'hover:bg-gray-200');
                            li.addEventListener('click', () => {
                                addressInput.value = place.display_name;
                                document.getElementById('latitude').value = place.lat;
                                document.getElementById('longitude').value = place.lon;
                                suggestions.innerHTML = '';
                                suggestions.classList.add('hidden');
                            });
                            suggestions.appendChild(li);
                        });
                        suggestions.classList.remove('hidden');
                    });
            }, 300); // délai pour limiter les requêtes
        });

        // Fermer suggestions si clic en dehors
        document.addEventListener('click', function(e){
            if(!addressInput.contains(e.target) && !suggestions.contains(e.target)){
                suggestions.innerHTML = '';
                suggestions.classList.add('hidden');
            }
        });
    </script>

@endsection


