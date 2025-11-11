<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tienda')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
    {{-- Navbar simple para el cliente --}}
    <nav class="bg-white shadow p-4 flex justify-between items-center">
        <a href="{{ route('shop.index') }}" class="text-2xl font-bold text-orange-500">RM Store</a>
        <div class="flex items-center gap-6">
            <a href="{{ route('cart.index') }}" class="text-gray-700 hover:text-orange-600 font-semibold">
                🛒 Carrito
            </a>
            <a href="{{ route('user.dashboard') }}" class="text-gray-700 hover:text-orange-600 font-semibold">
                Panel Usuario
            </a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button class="text-red-500 hover:text-red-700 font-semibold">Salir</button>
            </form>
        </div>
    </nav>

    <main class="p-6">
        @yield('content')
    </main>
</body>
</html>
