@extends('layouts.guest')

@section('title', 'RM - Registrarse')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100" 
     style="background: url('/images/bg-clothes.jpg') center/cover no-repeat;">
    <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-lg p-8 w-full max-w-md">
        <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">RM Admin</h2>
        <h3 class="text-xl font-semibold text-center text-gray-700 mb-4">Crea una Cuenta</h3>

        {{-- Mostrar errores de validación --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            {{-- Nombre --}}
            <div>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    placeholder="Nombre completo"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-400 outline-none">
            </div>

            {{-- Correo electrónico --}}
            <div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    placeholder="Correo electrónico"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-400 outline-none">
            </div>

            {{-- Contraseña --}}
            <div>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    placeholder="Contraseña"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-400 outline-none">
            </div>

            {{-- Confirmar contraseña --}}
            <div>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    placeholder="Confirmar contraseña"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-400 outline-none">
            </div>

            {{-- Botón de registro --}}
            <button type="submit"
                class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 rounded-lg shadow transition">
                Registrarse
            </button>

            {{-- Enlace a login --}}
            <p class="text-center text-sm text-gray-600 mt-4">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}" class="text-orange-500 hover:underline font-semibold">
                    Inicia Sesión
                </a>
            </p>
        </form>
    </div>
</div>
@endsection
