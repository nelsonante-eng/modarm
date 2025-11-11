@extends('layouts.admin')

@section('title', 'Editar Usuario')
@section('header', 'Editar Usuario')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow-md max-w-lg mx-auto">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Modificar datos del usuario</h2>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nombre --}}
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-medium mb-1">Nombre</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-400 focus:outline-none">
        </div>

        {{-- Correo --}}
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-medium mb-1">Correo</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-400 focus:outline-none">
        </div>

        {{-- Rol --}}
        <div class="mb-4">
            <label for="role" class="block text-gray-700 font-medium mb-1">Rol</label>
            <select name="role" id="role"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-400 focus:outline-none">
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Usuario</option>
            </select>
        </div>

        {{-- Botones --}}
        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('admin.users.index') }}"
               class="text-gray-600 hover:text-gray-800 font-medium">
               Cancelar
            </a>
            <button type="submit"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-lg shadow">
                Guardar cambios
            </button>
        </div>
    </form>
</div>
@endsection
