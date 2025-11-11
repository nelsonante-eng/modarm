<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- ✅ Título dinámico según la vista --}}
    <title>@yield('title', 'RM Admin')</title>

    {{-- ✅ Favicon --}}
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100">

    {{-- Contenido principal --}}
    <main>
        @yield('content')
    </main>

</body>
</html>
