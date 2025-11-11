@extends('layouts.store')

@section('title', 'Mis Pedidos')

@section('content')
<div class="bg-gray-50 min-h-screen p-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">🧾 Mis Pedidos</h1>

    @if ($orders->isEmpty())
        <div class="text-center text-gray-500">
            <p>No tienes pedidos registrados aún.</p>
            <a href="{{ route('shop.index') }}" class="text-orange-500 font-semibold hover:underline">
                Ir a la tienda
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach ($orders as $order)
                <div class="bg-white shadow-md rounded-xl p-6">
                    <div class="flex justify-between items-center border-b pb-2 mb-3">
                        <h2 class="text-lg font-semibold text-gray-700">
                            Pedido #{{ $order->id }}
                        </h2>
                        <span class="text-sm text-gray-500">
                            {{ $order->created_at->format('d/m/Y H:i') }}
                        </span>
                    </div>

                    <p class="text-gray-600 mb-2">
                        <strong>Estado:</strong>
                        <span class="{{ $order->status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>

                    <p class="text-gray-600 mb-4">
                        <strong>Total:</strong> ${{ number_format($order->total, 2) }}
                    </p>

                    <div class="border-t pt-3">
                        <h3 class="text-md font-semibold text-gray-700 mb-2">Productos:</h3>
                        <ul class="space-y-2">
                            @foreach ($order->items as $item)
                                <li class="flex justify-between text-gray-700">
                                    <span>{{ $item->product->name ?? 'Producto eliminado' }}</span>
                                    <span>x{{ $item->quantity }}</span>
                                    <span>${{ number_format($item->product->price ?? 0, 2) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
