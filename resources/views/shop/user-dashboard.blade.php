@extends('layouts.store')

@section('content')
<div class="bg-gray-50 min-h-screen p-8">

    {{-- Saludo principal --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                ¡Hola {{ Auth::user()->name }}! 👋
            </h1>
            <p class="text-gray-500">Bienvenido a <span class="text-orange-500 font-semibold">RM Tienda</span></p>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md font-semibold transition">
                Cerrar sesión
            </button>
        </form>
    </div>

    {{-- Accesos rápidos --}}
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-4 mb-10">
        <a href="{{ route('shop.index') }}" 
           class="flex items-center justify-center bg-orange-500 hover:bg-orange-600 text-white font-semibold py-6 rounded-xl shadow-md transition">
            🎁 Catálogo de Productos
        </a>

        {{-- ✅ Botón funcional Mis Pedidos --}}
        <a href="{{ route('user.orders') }}" 
           class="flex items-center justify-center bg-sky-500 hover:bg-sky-600 text-white font-semibold py-6 rounded-xl shadow-md transition">
            📦 Mis Pedidos
        </a>

        <a href="#" 
           class="flex items-center justify-center bg-green-400 hover:bg-green-500 text-white font-semibold py-6 rounded-xl shadow-md transition">
            🎉 Ofertas y Promociones
        </a>
    </div>

    {{-- Sección de la tienda --}}
    <div class="grid md:grid-cols-2 gap-8">
        {{-- Nueva colección --}}
        <div class="relative bg-cover bg-center rounded-2xl shadow-md overflow-hidden flex items-center justify-start p-8"
             style="background-image: url('{{ asset('images/nueva_coleccion.jpg') }}'); height: 230px;">

            {{-- Capa semitransparente para mejorar contraste del texto --}}
            <div class="absolute inset-0 bg-black bg-opacity-25"></div>

            {{-- Contenido de texto encima de la imagen --}}
            <div class="relative z-10 text-white max-w-sm">
                <h2 class="text-2xl font-bold mb-2 uppercase drop-shadow-md">¡Nueva Colección!</h2>
                <p class="mb-4 text-gray-100 drop-shadow">Descubre lo último en moda</p>
                <a href="{{ route('shop.index') }}"
                   class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-5 py-2 rounded-lg shadow transition">
                    Comprar Ahora
                </a>
            </div>
        </div>

        {{-- Productos destacados --}}
        <div class="bg-white rounded-2xl shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Productos Destacados</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                @foreach(\App\Models\Product::take(6)->get() as $product)
                    <div class="border rounded-lg p-3 hover:shadow-lg transition">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-32 object-cover rounded-md mb-2">
                        <h3 class="font-medium text-gray-700 text-sm">{{ $product->name }}</h3>
                        <p class="text-orange-600 font-semibold">${{ number_format($product->price, 2) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
