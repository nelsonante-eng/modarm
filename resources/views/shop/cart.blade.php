@extends('layouts.store')

@section('title', 'Carrito de Compras')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-4">
    {{-- 🔙 BOTÓN VOLVER AL CATÁLOGO --}}
    <div class="mb-6">
        <a href="{{ route('shop.index') }}" 
           class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-semibold transition">
            ← Volver al Catálogo
        </a>
    </div>

    <h1 class="text-3xl font-bold text-gray-800 mb-6">🛒 Carrito de Compras</h1>

    @if($cart && count($cart) > 0)
    <div class="bg-white shadow rounded-2xl p-6">
        <table class="min-w-full text-left border border-gray-200 rounded-lg">
            <thead class="bg-gray-100 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-gray-600 font-semibold">Producto</th>
                    <th class="px-6 py-3 text-gray-600 font-semibold">Precio</th>
                    <th class="px-6 py-3 text-gray-600 font-semibold">Cantidad</th>
                    <th class="px-6 py-3 text-gray-600 font-semibold">Subtotal</th>
                    <th class="px-6 py-3 text-gray-600 font-semibold text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($cart as $item)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 flex items-center gap-3">
                        <img src="{{ asset('storage/' . $item['image']) }}" class="w-16 h-16 object-cover rounded-lg">
                        <span class="font-semibold text-gray-800">{{ $item['name'] }}</span>
                    </td>
                    <td class="px-6 py-4 text-gray-700">${{ number_format($item['price'], 2) }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $item['quantity'] }}</td>
                    <td class="px-6 py-4 text-gray-800 font-semibold">
                        ${{ number_format($item['price'] * $item['quantity'], 2) }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="text-red-600 hover:text-red-800 font-semibold flex items-center gap-1 justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-between items-center mt-8">
            <h2 class="text-2xl font-semibold text-gray-800">Total: ${{ number_format($total, 2) }}</h2>
            <a href="{{ route('checkout.index') }}"
               class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold transition">
               Proceder al Pago
            </a>
        </div>
    </div>
    @else
    <div class="text-center py-16 bg-white rounded-2xl shadow">
        <h2 class="text-2xl text-gray-700 mb-4">Tu carrito está vacío 🛍️</h2>
        <a href="{{ route('shop.index') }}" class="text-orange-600 hover:underline font-semibold">Volver a la tienda</a>
    </div>
    @endif
</div>
@endsection
