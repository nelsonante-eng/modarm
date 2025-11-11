<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel de Administración')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex">

    {{-- CONTENIDO PRINCIPAL --}}
    <div class="w-full">
        {{-- NAVBAR SUPERIOR --}}
        <header class="bg-white shadow-sm flex justify-between items-center px-6 py-3">
            <h2 class="text-lg font-semibold text-gray-800">@yield('header', 'Panel')</h2>
            <div class="flex items-center gap-4">
                <span class="text-gray-700 font-medium">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </header>

        {{-- CONTENIDO DE LA VISTA HIJA --}}
        <main class="p-6">
            @yield('content')
        </main>
    </div>
</body>
</html>
