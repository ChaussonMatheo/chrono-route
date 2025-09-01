@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Routes</h1>
        <a href="{{ route('routes.create') }}" class="bg-primary text-white px-4 py-2 rounded hover:bg-orange-500">Nouvelle Route</a>
    </div>

    <table class="w-full border border-gray-200 rounded">
        <thead class="bg-primary text-white">
        <tr>
            <th class="px-4 py-2 text-left">Nom</th>
            <th class="px-4 py-2 text-left">Date prévue</th>
            <th class="px-4 py-2 text-left">Stops</th>
            <th class="px-4 py-2">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($routes as $route)
            <tr class="border-b">
                <td class="px-4 py-2">{{ $route->name }}</td>
                <td class="px-4 py-2">{{ $route->scheduled_date ?? '-' }}</td>
                <td class="px-4 py-2">{{ $route->stops_count }}</td>
                <td class="px-4 py-2 text-center space-x-2">
                    <a href="{{ route('routes.show', $route) }}" class="text-primary hover:underline">Voir</a>
                    <a href="{{ route('routes.stops.index', $route) }}" class="text-blue-600 hover:underline">Stops</a>
                    <a href="{{ route('routes.start', $route) }}" class="bg-green-600 text-white px-2 py-1 rounded hover:bg-green-500">Lancer</a>
                    <a href="{{ route('routes.edit', $route) }}" class="text-yellow-600 hover:underline">Éditer</a>
                    <form action="{{ route('routes.destroy', $route) }}" method="POST" class="inline-block" onsubmit="return confirm('Supprimer cette route ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                    </form>
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $routes->links() }}
    </div>
@endsection
