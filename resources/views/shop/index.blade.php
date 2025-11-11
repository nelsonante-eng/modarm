@extends('layouts.store')

@section('title', 'Catálogo de Productos')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">
    {{-- Título y botones --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Catálogo de Productos</h1>

        <div class="flex items-center gap-4">
            <a href="{{ route('user.dashboard') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded-lg shadow transition">
                ← Volver al Dashboard
            </a>

            <a href="{{ route('cart.index') }}"
               class="text-orange-600 font-semibold hover:underline flex items-center gap-1">
                🛒 Ver Carrito
            </a>
        </div>
    </div>

    {{-- 🔍 Filtros funcionales --}}
    <form method="GET" action="{{ route('shop.index') }}" class="flex flex-wrap gap-4 mb-10">
        <select name="category" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-400">
            <option value="">Categorías</option>
            @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                    {{ $cat }}
                </option>
            @endforeach
        </select>

        <div class="flex items-center border border-gray-300 rounded-lg px-3 py-2 flex-grow max-w-md">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Buscar productos..." 
                   class="w-full outline-none text-gray-700">
            <button type="submit" class="text-gray-500 hover:text-orange-500">
                <i class="fas fa-search"></i>
            </button>
        </div>

        <button type="submit" 
                class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-semibold transition">
            Aplicar filtros
        </button>

        <a href="{{ route('shop.index') }}" 
           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-semibold transition">
            Limpiar
        </a>
    </form>

    {{-- 🛍️ Productos --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition transform hover:-translate-y-1">
                <img src="{{ asset('storage/' . $product->image) }}" 
                     alt="{{ $product->name }}" 
                     class="rounded-t-xl h-56 w-full object-cover">
                <div class="p-4 flex flex-col justify-between h-40">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h2>
                        <p class="text-orange-600 font-bold text-base">${{ number_format($product->price, 2) }}</p>
                    </div>
                    <form action="{{ route('cart.add', $product) }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg w-full font-semibold transition">
                            Agregar al carrito
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-600 text-center col-span-4">No se encontraron productos.</p>
        @endforelse
    </div>

    {{-- Paginación --}}
    <div class="mt-8 flex justify-center">
        {{ $products->appends(request()->query())->links() }}
    </div>
</div>
@endsection
