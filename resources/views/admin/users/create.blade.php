@extends('layouts.admin')

@section('title', 'Agregar Usuario')
@section('header', 'Nuevo Usuario')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow max-w-lg mx-auto">
    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
        @csrf

        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nombre</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-orange-400 outline-none">
            @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Correo electrónico</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-orange-400 outline-none">
            @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Contraseña</label>
            <input type="password" name="password" id="password" required
                class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-orange-400 outline-none">
            @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-orange-400 outline-none">
        </div>

        <div>
            <label for="role" class="block text-sm font-semibold text-gray-700 mb-1">Rol</label>
            <select name="role" id="role" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-orange-400 outline-none">
                <option value="user">Usuario</option>
                <option value="admin">Administrador</option>
            </select>
        </div>

        <div class="flex justify-end pt-4">
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 mr-2">
                Cancelar
            </a>
            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-lg font-semibold">
                Guardar Usuario
            </button>
        </div>
    </form>
</div>
@endsection
