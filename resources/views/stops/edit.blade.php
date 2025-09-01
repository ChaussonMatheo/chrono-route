@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Éditer Stop pour : {{ $route->name }}</h1>

    <form action="{{ route('routes.stops.update', [$route, $stop]) }}" method="POST" class="max-w-lg bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="address" class="block font-medium mb-1">Adresse</label>
            <input type="text" name="address" id="address" value="{{ old('address', $stop->address) }}" class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label for="latitude" class="block font-medium mb-1">Latitude</label>
            <input type="text" name="latitude" id="latitude" value="{{ old('latitude', $stop->latitude) }}" class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label for="longitude" class="block font-medium mb-1">Longitude</label>
            <input type="text" name="longitude" id="longitude" value="{{ old('longitude', $stop->longitude) }}" class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label for="order" class="block font-medium mb-1">Ordre</label>
            <input type="number" name="order" id="order" value="{{ old('order', $stop->order) }}" class="w-full border rounded px-3 py-2" min="1">
        </div>

        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="delivered" class="form-checkbox text-primary" {{ old('delivered', $stop->delivered) ? 'checked' : '' }}>
                <span class="ml-2">Livré</span>
            </label>
        </div>

        <button type="submit" class="bg-primary text-white px-4 py-2 rounded hover:bg-orange-500">Mettre à jour</button>
    </form>
@endsection
