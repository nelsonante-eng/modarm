@extends('layouts.admin')

@section('title', 'RM -Dashboard')
@section('header', 'Panel Principal')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    {{-- Bienvenida --}}
    <h1 class="text-2xl font-semibold mb-6">
        👋 ¡Hola, {{ Auth::user()->name }}! Bienvenido de nuevo.
    </h1>

    {{-- Tarjetas resumen --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-6 rounded-2xl shadow text-center">
            <h2 class="text-gray-500 text-sm">Total Productos</h2>
            <p class="text-3xl font-bold text-orange-500">{{ number_format($totalProducts) }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow text-center">
            <h2 class="text-gray-500 text-sm">Ventas Hoy</h2>
            <p class="text-3xl font-bold text-green-600">${{ number_format($salesToday, 2) }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow text-center">
            <h2 class="text-gray-500 text-sm">Ganancias del Mes</h2>
            <p class="text-3xl font-bold text-purple-600">${{ number_format($monthlyEarnings, 2) }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow text-center">
            <h2 class="text-gray-500 text-sm">Usuarios Registrados</h2>
            <p class="text-3xl font-bold text-blue-600">{{ number_format($totalUsers) }}</p>
        </div>
    </div>

    {{-- Accesos Rápidos --}}
    <h3 class="text-lg font-medium mb-4">Accesos Rápidos</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <a href="{{ route('admin.products.index') }}" class="flex flex-col items-center bg-white text-gray-800 text-center p-4 rounded-xl shadow hover:bg-orange-50 transition">
            <x-lucide-box class="w-6 h-6 mb-2 text-orange-500"/>
            <span>Productos</span>
        </a>

        <a href="{{ route('profile.edit') }}" class="flex flex-col items-center bg-white text-gray-800 text-center p-4 rounded-xl shadow hover:bg-orange-50 transition">
            <x-lucide-users class="w-6 h-6 mb-2 text-orange-500"/>
            <span>Usuarios</span>
        </a>

        <a href="{{ route('admin.reports') }}" class="flex flex-col items-center bg-white text-gray-800 text-center p-4 rounded-xl shadow hover:bg-orange-50 transition">
            <x-lucide-bar-chart class="w-6 h-6 mb-2 text-orange-500"/>
            <span>Reportes</span>
        </a>

        <a href="{{ route('admin.products.create') }}" class="flex flex-col items-center bg-white text-gray-800 text-center p-4 rounded-xl shadow hover:bg-orange-50 transition">
            <x-lucide-plus-circle class="w-6 h-6 mb-2 text-orange-500"/>
            <span>Crear Producto</span>
        </a>
    </div>

    {{-- Sección inferior --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Productos con bajo stock --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">⚠️ Productos con Bajo Stock</h2>
            @if($lowStockProducts->isEmpty())
                <p class="text-gray-500">Todos los productos tienen stock suficiente.</p>
            @else
                <ul class="divide-y divide-gray-100">
                    @foreach($lowStockProducts as $product)
                        <li class="py-2 flex justify-between text-gray-700">
                            <span>{{ $product->name }}</span>
                            <span class="font-semibold text-red-500">{{ $product->stock }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- Últimas órdenes --}}
        <div class="bg-white rounded-2xl shadow p-6 col-span-2">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">🧾 Últimas Órdenes</h2>
            @if($recentOrders->isEmpty())
                <p class="text-gray-500">No hay órdenes registradas aún.</p>
            @else
                <table class="min-w-full text-left">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-4 py-2 text-gray-600 font-semibold">#</th>
                            <th class="px-4 py-2 text-gray-600 font-semibold">Fecha</th>
                            <th class="px-4 py-2 text-gray-600 font-semibold">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($recentOrders as $order)
                            <tr>
                                <td class="px-4 py-2 text-gray-700">{{ $order->id }}</td>
                                <td class="px-4 py-2 text-gray-700">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-2 text-gray-700 font-semibold text-green-600">${{ number_format($order->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    {{-- Gráfico Top Productos más vendidos --}}
    <div class="bg-white rounded-2xl shadow p-6 mt-10">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">🔥 Top 5 Productos Más Vendidos</h2>
        <canvas id="topProductsChart" height="120"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('topProductsChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($topProducts->pluck('name')),
            datasets: [{
                label: 'Unidades Vendidas',
                data: @json($topProducts->pluck('total_sold')),
                backgroundColor: ['#F97316', '#34D399', '#60A5FA', '#FBBF24', '#A78BFA'],
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
});
</script>
@endpush
