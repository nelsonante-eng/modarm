@extends('layouts.store')

@section('title', 'Finalizar Compra')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4">
    {{-- 🔙 BOTÓN VOLVER AL CATÁLOGO --}}
    <div class="mb-6">
        <a href="{{ route('shop.index') }}" 
           class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-semibold transition">
            ← Volver al Catálogo
        </a>
    </div>

    <h1 class="text-3xl font-bold text-gray-800 mb-6">💳 Finalizar Compra</h1>

    <div class="bg-white shadow rounded-2xl p-6">
        <form action="{{ route('checkout.process') }}" method="POST">
        @csrf

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Nombre Completo</label>
                <input type="text" name="name" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-orange-400 focus:outline-none">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Dirección</label>
                <input type="text" name="address" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-orange-400 focus:outline-none">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Método de Pago</label>
                <select name="payment_method" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-orange-400 focus:outline-none">
                    <option value="tarjeta">💳 Tarjeta</option>
                    <option value="transferencia">🏦 Transferencia Bancaria</option>
                    <option value="efectivo">💵 Efectivo</option>
                </select>
            </div>

            <div class="flex justify-between items-center mt-8">
                <a href="{{ route('cart.index') }}" class="text-gray-600 hover:underline font-semibold">← Volver al carrito</a>
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold transition">
                    Confirmar Pedido
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
