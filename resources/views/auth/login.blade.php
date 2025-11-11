@extends('layouts.guest')

@section('title', 'RM - Iniciar Sesión')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100" 
     style="background: url('/images/bg-clothes.jpg') center/cover no-repeat;">
    <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-lg p-8 w-full max-w-md">
        <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">RM Admin</h2>
        <h3 class="text-xl font-semibold text-center text-gray-700 mb-4">Inicia Sesión</h3>

        {{-- Mostrar errores --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            {{-- Email --}}
            <div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    placeholder="Email"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-400 outline-none">
            </div>

            {{-- Password --}}
            <div>
                <input id="password" type="password" name="password" required 
                    placeholder="Contraseña"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-400 outline-none">
            </div>

            {{-- Remember Me --}}
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="remember" class="rounded border-gray-300">
                    Recuérdame
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-orange-500 hover:underline">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>

            {{-- Button --}}
            <button type="submit"
                class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 rounded-lg shadow transition">
                Iniciar Sesión
            </button>

            <p class="text-center text-sm text-gray-600 mt-4">
                ¿No tienes cuenta?
                <a href="{{ route('register') }}" class="text-orange-500 hover:underline font-semibold">
                    Regístrate
                </a>
            </p>
        </form>
    </div>
</div>
@endsection
