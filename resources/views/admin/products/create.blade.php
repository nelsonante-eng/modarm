@extends('layouts.admin')



@section('title', 'Crear Producto')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Crear Producto</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded-lg shadow-md">
        @csrf

        {{-- Nombre --}}
        <div>
            <label for="name" class="block font-semibold text-gray-700">Nombre del producto</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500">
        </div>

        {{-- Categoría --}}
        <div>
            <label for="category" class="block font-semibold text-gray-700">Categoría</label>
            <select name="category" id="category" required
                class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500">
                <option value="">Selecciona una categoría</option>
                <option value="Ropa">Ropa</option>
                <option value="Calzado">Calzado</option>
                <option value="Accesorios">Accesorios</option>
            </select>
        </div>

        {{-- Descripción --}}
        <div>
            <label for="description" class="block font-semibold text-gray-700">Descripción</label>
            <textarea name="description" id="description" rows="4" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500">{{ old('description') }}</textarea>
        </div>

        {{-- Precio --}}
        <div>
            <label for="price" class="block font-semibold text-gray-700">Precio</label>
            <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" required
                class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500">
        </div>

        {{-- Stock --}}
        <div>
            <label for="stock" class="block font-semibold text-gray-700">Stock</label>
            <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" required
                class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500">
        </div>

        {{-- Imagen --}}
        <div>
            <label for="image" class="block font-semibold text-gray-700">Imagen del producto</label>
            <input type="file" name="image" id="image" accept="image/*" required
                class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-2 rounded-lg">
                Guardar Producto
            </button>
        </div>
    </form>
</div>
@endsection
