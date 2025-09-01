@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Créer une nouvelle Route</h1>

    <form action="{{ route('routes.store') }}" method="POST" class="max-w-lg bg-white p-6 rounded shadow">
        @csrf

        <div class="mb-4">
            <label for="name" class="block font-medium mb-1">Nom</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2">
            @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block font-medium mb-1">Description</label>
            <textarea name="description" id="description" class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="scheduled_date" class="block font-medium mb-1">Date prévue</label>
            <input type="datetime-local" name="scheduled_date" id="scheduled_date" value="{{ old('scheduled_date') }}" class="w-full border rounded px-3 py-2">
        </div>

        <button type="submit" class="bg-primary text-white px-4 py-2 rounded hover:bg-orange-500">Créer</button>
    </form>
@endsection
