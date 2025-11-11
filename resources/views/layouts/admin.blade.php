<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel de Administración')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 flex">
    {{-- SIDEBAR --}}
    <aside class="w-64 bg-white h-screen fixed left-0 top-0 shadow-md flex flex-col justify-between">
        <div>
            <div class="p-6 border-b border-gray-200 flex items-center justify-center">
                <h1 class="text-2xl font-bold text-orange-500">RM</h1>
            </div>

            <nav class="p-4 space-y-2">
                {{-- Dashboard --}}
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 p-3 rounded-xl hover:bg-orange-100 
                   {{ request()->is('admin/dashboard') ? 'bg-orange-50 text-orange-600' : 'text-gray-700' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 9.75L12 4l9 5.75M4.5 10.5V20a.75.75 0 00.75.75h4.5a.75.75 0 00.75-.75v-4.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V20a.75.75 0 00.75.75h4.5a.75.75 0 00.75-.75v-9.5" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                {{-- Productos --}}
                <a href="{{ route('admin.products.index') }}"
                   class="flex items-center gap-3 p-3 rounded-xl hover:bg-orange-100 
                   {{ request()->is('admin/products*') ? 'bg-orange-50 text-orange-600' : 'text-gray-700' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0l-8 5-8-5" />
                    </svg>
                    <span>Productos</span>
                </a>

                {{-- Gestionar usuarios (SIEMPRE visible) --}}
                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center gap-3 p-3 rounded-xl hover:bg-orange-100 
                   {{ request()->is('admin/users*') ? 'bg-orange-50 text-orange-600' : 'text-gray-700' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-1a4 4 0 00-4-4h-1M9 20v-1a4 4 0 014-4h2M9 7a4 4 0 110-8 4 4 0 010 8zM17 11a4 4 0 110-8 4 4 0 010 8z" />
                    </svg>
                    <span>Gestionar usuarios</span>
                </a>

                {{-- Reportes --}}
                <a href="{{ route('admin.reports') }}"
                   class="flex items-center gap-3 p-3 rounded-xl hover:bg-orange-100 
                   {{ request()->is('admin/reports') ? 'bg-orange-50 text-orange-600' : 'text-gray-700' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 3v18m-4-4h8m4 0h-4V7a4 4 0 10-8 0v10H3" />
                    </svg>
                    <span>Reportes</span>
                </a>
            </nav>
        </div>

        {{-- Logout --}}
        <div class="p-4 border-t border-gray-200">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="flex items-center gap-3 p-3 w-full rounded-xl hover:bg-red-100 text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" />
                    </svg>
                    <span>Cerrar sesión</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- CONTENIDO PRINCIPAL --}}
    <div class="ml-64 w-full">
        {{-- NAVBAR SUPERIOR --}}
        <header class="bg-white shadow-sm flex justify-between items-center px-6 py-3">
            <h2 class="text-lg font-semibold text-gray-800">@yield('header', 'Panel')</h2>
            <div class="flex items-center gap-4">
                {{-- campana --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 17h5l-1.405-1.405C18.79 14.79 18 13.42 18 12V8a6 6 0 10-12 0v4c0 1.42-.79 2.79-1.595 3.595L3 17h5m7 0a3 3 0 11-6 0h6z" />
                </svg>
                {{-- usuario --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5.121 17.804A9 9 0 1118.879 17.8M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="text-gray-700 font-medium">{{ Auth::user()->name }}</span>
            </div>
        </header>

        {{-- CONTENIDO PRINCIPAL --}}
        <main class="p-6">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
