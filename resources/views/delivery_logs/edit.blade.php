@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Éditer le log pour le stop : {{ $stop->address ?? 'Coordonnées' }}</h1>

    <form action="{{ route('routes.stops.delivery_logs.update', [$route, $stop, $deliveryLog]) }}" method="POST" class="max-w-lg bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="delivered_at" class="block font-medium mb-1">Date et heure de livraison</label>
            <input type="datetime-local" name="delivered_at" id="delivered_at" value="{{ old('delivered_at', $deliveryLog->delivered_at ? \Carbon\Carbon::parse($deliveryLog->delivered_at)->format('Y-m-d\TH:i') : '') }}" class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label for="status" class="block font-medium mb-1">Statut</label>
            <select name="status" id="status" class="w-full border rounded px-3 py-2">
                <option value="success" {{ old('status', $deliveryLog->status) == 'success' ? 'selected' : '' }}>Success</option>
                <option value="failed" {{ old('status', $deliveryLog->status) == 'failed' ? 'selected' : '' }}>Failed</option>
                <option value="absent" {{ old('status', $deliveryLog->status) == 'absent' ? 'selected' : '' }}>Absent</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="notes" class="block font-medium mb-1">Notes</label>
            <textarea name="notes" id="notes" class="w-full border rounded px-3 py-2">{{ old('notes', $deliveryLog->notes) }}</textarea>
        </div>

        <button type="submit" class="bg-primary text-white px-4 py-2 rounded hover:bg-orange-500">Mettre à jour</button>
    </form>
@endsection
