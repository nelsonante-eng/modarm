@extends('layouts.admin')

@section('title', 'Productos')
@section('header', 'Listado de Productos')

@section('content')
<div x-data="{ open: false, product: {} }" class="bg-white rounded-2xl shadow p-6">

    {{-- Encabezado --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Productos</h1>
        <a href="{{ route('admin.products.create') }}" 
           class="flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg shadow transition">
            <x-lucide-plus class="w-5 h-5" />
            Crear Producto
        </a>
    </div>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-col md:flex-row gap-4 mb-6">
        <input 
            type="text" 
            name="search" 
            value="{{ request('search') }}" 
            placeholder="Buscar por nombre..." 
            class="p-2 border border-gray-300 rounded-lg w-full md:w-1/3 focus:ring-2 focus:ring-orange-400 outline-none">

        <select 
            name="sort" 
            class="p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-400 outline-none"
            onchange="this.form.submit()">
            <option value="">Ordenar por...</option>
            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Precio: menor a mayor</option>
            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Precio: mayor a menor</option>
            <option value="stock_asc" {{ request('sort') == 'stock_asc' ? 'selected' : '' }}>Stock: menor a mayor</option>
            <option value="stock_desc" {{ request('sort') == 'stock_desc' ? 'selected' : '' }}>Stock: mayor a menor</option>
        </select>

        <div class="flex gap-2">
            <button 
                type="submit"
                class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg shadow transition">
                Filtrar
            </button>

            {{-- Botón para limpiar filtros --}}
            <a href="{{ route('admin.products.index') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow transition">
                Limpiar
            </a>
        </div>
    </form>

    {{-- Tabla --}}
    <div class="overflow-x-auto">
        <table class="min-w-full text-left border border-gray-200 rounded-lg">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-gray-600 font-semibold">ID</th>
                    <th class="px-6 py-3 text-gray-600 font-semibold">Nombre</th>
                    <th class="px-6 py-3 text-gray-600 font-semibold">Precio</th>
                    <th class="px-6 py-3 text-gray-600 font-semibold">Stock</th>
                    <th class="px-6 py-3 text-gray-600 font-semibold text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-gray-700">{{ $product->id }}</td>
                    <td class="px-6 py-4 text-gray-900 font-medium">{{ $product->name }}</td>
                    <td class="px-6 py-4 text-gray-800">${{ number_format($product->price, 2) }}</td>
                    <td class="px-6 py-4 text-gray-800">{{ $product->stock }}</td>
                    <td class="px-6 py-4 flex justify-center gap-3">
                        {{-- Botón Detalles --}}
                        <button 
                            @click="open = true; product = {
                                name: '{{ $product->name }}',
                                price: '{{ number_format($product->price, 2) }}',
                                stock: '{{ $product->stock }}',
                                description: '{{ $product->description ?? 'Sin descripción' }}',
                                image: '{{ asset('storage/' . $product->image) }}'
                            }"
                            class="text-orange-600 hover:text-orange-800 font-semibold">
                            Detalles
                        </button>

                        {{-- Botón editar --}}
                        <a href="{{ route('admin.products.edit', $product) }}" 
                           class="text-blue-600 hover:text-blue-800 font-semibold">Editar</a>

                        {{-- Botón eliminar --}}
                        <form id="delete-form-{{ $product->id }}" action="{{ route('admin.products.destroy', $product) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" 
                                    onclick="confirmDelete({{ $product->id }})"
                                    class="text-red-600 hover:text-red-800 font-semibold">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No hay productos registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="mt-6">
        {{ $products->appends(request()->query())->links() }}
    </div>

    {{-- Modal Detalles --}}
    <div 
        x-show="open" 
        style="display: none;"
        class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div @click.away="open = false" class="bg-white rounded-2xl shadow-lg p-6 w-full max-w-md relative">
            <button @click="open = false" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800">✖</button>

            <h2 class="text-xl font-semibold text-gray-800 mb-4" x-text="product.name"></h2>

            <template x-if="product.image">
                <img :src="product.image" alt="Imagen del producto" class="w-full h-48 object-cover rounded-xl mb-4">
            </template>

            <p><strong>Precio:</strong> $<span x-text="product.price"></span></p>
            <p><strong>Stock:</strong> <span x-text="product.stock"></span></p>
            <p class="mt-3 text-gray-700"><strong>Descripción:</strong></p>
            <p x-text="product.description" class="text-gray-600"></p>
        </div>
    </div>
</div>

{{-- SweetAlert2 y Alpine.js --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
    function confirmDelete(productId) {
        Swal.fire({
            title: 'Confirmar Eliminación',
            text: '¿Seguro que deseas eliminar este producto?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#F97316',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + productId).submit();
            }
        });
    }
</script>
@endpush
@endsection
