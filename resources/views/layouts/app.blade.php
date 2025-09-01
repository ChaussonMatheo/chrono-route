<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChronoRoute</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.min.js"></script>

</head>

<body class="bg-white text-gray-800 min-h-screen flex flex-col">

{{-- Navigation --}}
<nav class="bg-primary text-white shadow-md">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <a href="{{ route('routes.index') }}" class="font-bold text-xl">ChronoRoute</a>
        <ul class="flex space-x-4">
            <li><a href="{{ route('routes.index') }}" class="hover:underline">Routes</a></li>s
            <li><a href="#" class="hover:underline">Delivery Logs</a></li>
            <li><a href="#" class="hover:underline">Profil</a></li>
        </ul>
    </div>
</nav>

{{-- Contenu --}}
<main class="flex-1 container mx-auto px-4 py-6">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')
</main>

{{-- Footer --}}
<footer class="bg-primary text-white text-center py-4 mt-auto">
    &copy; {{ date('Y') }} ChronoRoute - Tous droits réservés
</footer>

</body>
</html>
