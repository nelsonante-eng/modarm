@extends('layouts.admin')

@section('title', 'Reportes')
@section('header', 'Reportes y Estadísticas')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    {{-- Encabezado --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">
            📊 Reportes de Ventas y Actividad
        </h1>
        <div class="flex gap-3">
            <a href="{{ route('admin.reports.pdf') }}" 
               class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow transition">
               📄 Descargar PDF
            </a>
            <a href="{{ route('admin.reports.excel') }}" 
               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow transition">
               📊 Exportar Excel
            </a>
        </div>
    </div>

    {{-- Tarjetas resumen --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow text-center">
            <h2 class="text-sm text-gray-500 mb-1">Usuarios Registrados</h2>
            <p class="text-3xl font-bold text-orange-500">{{ number_format($totalUsers) }}</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow text-center">
            <h2 class="text-sm text-gray-500 mb-1">Productos Totales</h2>
            <p class="text-3xl font-bold text-blue-600">{{ number_format($totalProducts) }}</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow text-center">
            <h2 class="text-sm text-gray-500 mb-1">Ventas Totales</h2>
            <p class="text-3xl font-bold text-green-600">${{ number_format($totalSales, 2) }}</p>
        </div>
    </div>

    {{-- Gráficos principales --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Ventas mensuales --}}
        <div class="bg-white p-6 rounded-2xl shadow col-span-2">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">📅 Ventas Mensuales</h2>
            <canvas id="salesChart" height="120"></canvas>
        </div>

        {{-- Stock por producto --}}
        <div class="bg-white p-6 rounded-2xl shadow">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">📦 Distribución de Stock</h2>
            <canvas id="stockChart" height="150"></canvas>
        </div>
    </div>

    {{-- Top productos --}}
    <div class="bg-white p-6 rounded-2xl shadow mt-10">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">🔥 Top 5 Productos Más Vendidos</h2>
        <canvas id="topProductsChart" height="150"></canvas>
    </div>

    {{-- Tabla Detalle de Productos --}}
    <div class="mt-10 bg-white rounded-2xl shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">📋 Detalles de los Productos Más Vendidos</h2>
        <table class="min-w-full text-left border border-gray-200 rounded-xl">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-gray-600 font-semibold">Producto</th>
                    <th class="px-6 py-3 text-gray-600 font-semibold">Precio</th>
                    <th class="px-6 py-3 text-gray-600 font-semibold">Stock</th>
                    <th class="px-6 py-3 text-gray-600 font-semibold">Vendidos</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($topProducts as $product)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-3 text-gray-700">{{ $product->name }}</td>
                        <td class="px-6 py-3 text-gray-700">${{ number_format($product->price, 2) }}</td>
                        <td class="px-6 py-3 text-gray-700">{{ $product->stock }}</td>
                        <td class="px-6 py-3 text-gray-700 font-semibold">{{ $product->total_sold }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // === Gráfico: Ventas Mensuales ===
    const ctxSales = document.getElementById('salesChart');
    new Chart(ctxSales, {
        type: 'line',
        data: {
            labels: @json($chartData['months']),
            datasets: [{
                label: 'Ventas ($)',
                data: @json($chartData['salesData']),
                borderColor: '#f97316',
                backgroundColor: 'rgba(249, 115, 22, 0.25)',
                fill: true,
                tension: 0.3,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // === Gráfico: Distribución de Stock ===
    const ctxStock = document.getElementById('stockChart');
    new Chart(ctxStock, {
        type: 'doughnut',
        data: {
            labels: @json($chartData['stockLabels']),
            datasets: [{
                data: @json($chartData['stockData']),
                backgroundColor: ['#60A5FA', '#FBBF24', '#34D399', '#A78BFA', '#F87171', '#F97316', '#10B981'],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // === Gráfico: Top 5 Productos Más Vendidos ===
    const ctxTop = document.getElementById('topProductsChart');
    new Chart(ctxTop, {
        type: 'bar',
        data: {
            labels: @json($topProducts->pluck('name')),
            datasets: [{
                label: 'Vendidos',
                data: @json($topProducts->pluck('total_sold')),
                backgroundColor: '#10B981',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });
});
</script>
@endpush
