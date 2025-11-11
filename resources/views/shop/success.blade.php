@extends('layouts.store')

@section('title', 'Compra Exitosa')

@section('content')
<div class="max-w-3xl mx-auto py-16 px-6 text-center">
    <h1 class="text-4xl font-bold text-green-600 mb-6">¡Pago Exitoso! 🎉</h1>
    <p class="text-gray-700 text-lg mb-4">
        Gracias, <strong>{{ $name }}</strong>. Tu pedido ha sido procesado correctamente.
    </p>
    <p class="text-gray-600 text-lg mb-8">
        Método de pago: <strong>{{ $payment_method }}</strong><br>
        Total pagado: <strong>${{ number_format($total, 2) }}</strong>
    </p>

    <a href="{{ route('shop.index') }}" 
       class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold transition">
       ← Volver al Catálogo
    </a>
</div>
@endsection
