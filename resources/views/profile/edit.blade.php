@extends('layouts.admin')

@section('title', 'Perfil de Usuario')
@section('header', 'Configuración de Cuenta')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow rounded-2xl p-8">

    {{-- Encabezado con imagen --}}
    <div class="flex flex-col items-center mb-8">
        <div class="relative">
            {{-- Mostrar imagen real si existe, si no avatar --}}
            <img id="profilePreview"
                 src="{{ $user->profile_image 
                        ? asset('storage/' . $user->profile_image) 
                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=ffedd5&color=9a3412' }}"
                 alt="Foto de perfil"
                 class="w-28 h-28 rounded-full border-4 border-orange-200 object-cover shadow">

            {{-- Botón para cambiar imagen --}}
            <label for="profile_image"
                   class="absolute bottom-0 right-0 bg-orange-500 text-white p-2 rounded-full cursor-pointer hover:bg-orange-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15.232 5.232l3.536 3.536M4 13.5V19h5.5l9.768-9.768a1.5 1.5 0 10-2.121-2.121L4 13.5z"/>
                </svg>
            </label>
        </div>
        <h2 class="text-2xl font-semibold text-gray-800 mt-4">{{ $user->name }}</h2>
        <p class="text-gray-500">{{ $user->email }}</p>
    </div>

    {{-- Mensaje de éxito --}}
    @if (session('status') === 'profile-updated')
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            ✅ Perfil actualizado correctamente.
        </div>
    @endif

    {{-- Formulario de actualización --}}
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PATCH')

        {{-- Imagen --}}
        <input type="file" name="profile_image" id="profile_image" accept="image/*" class="hidden" onchange="previewImage(event)">

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-orange-400 focus:border-orange-400">
            @error('name')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-orange-400 focus:border-orange-400">
            @error('email')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit"
                class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-lg shadow transition">
                Guardar cambios
            </button>
        </div>
    </form>
</div>

{{-- Sección eliminar cuenta --}}
<div class="max-w-3xl mx-auto bg-white shadow rounded-2xl p-8 mt-10 border-t-4 border-red-500">
    <h2 class="text-xl font-semibold mb-4 text-red-600">Eliminar cuenta</h2>
    <p class="text-gray-600 mb-4">
        Esta acción es irreversible. Todos tus datos se eliminarán permanentemente.
    </p>

    <form id="delete-account-form" method="POST" action="{{ route('profile.destroy') }}">
        @csrf
        @method('DELETE')

        <button type="button"
            onclick="confirmAccountDeletion()"
            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow transition">
            Eliminar mi cuenta
        </button>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('profilePreview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function confirmAccountDeletion() {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Tu cuenta será eliminada permanentemente. Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DC2626',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-account-form').submit();
            }
        });
    }
</script>
@endpush
