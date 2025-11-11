@extends('layouts.admin')

@section('title', 'Gestión de Usuarios')
@section('header', 'Gestión de Usuarios')

@section('content')
<div class="bg-white rounded-2xl shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Usuarios Registrados</h1>
        <a href="{{ route('admin.users.create') }}" 
           class="flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg shadow transition">
            <x-lucide-plus class="w-5 h-5" />
            Nuevo Usuario
        </a>
    </div>

    {{-- Tabla --}}
    <div class="overflow-x-auto">
        <table class="min-w-full text-left border border-gray-200 rounded-lg">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-gray-600 font-semibold">ID</th>
                    <th class="px-6 py-3 text-gray-600 font-semibold">Nombre</th>
                    <th class="px-6 py-3 text-gray-600 font-semibold">Correo</th>
                    <th class="px-6 py-3 text-gray-600 font-semibold">Rol</th>
                    <th class="px-6 py-3 text-gray-600 font-semibold text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-gray-700">{{ $user->id }}</td>
                        <td class="px-6 py-4 text-gray-900 font-medium">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="border border-gray-300 px-2 py-1 rounded-md text-sm text-gray-700">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 flex gap-4 justify-center">
                            {{-- Editar --}}
                            <a href="{{ route('admin.users.edit', $user) }}" 
                               class="text-blue-600 hover:text-blue-800 font-semibold">
                                Editar
                            </a>

                            {{-- Eliminar --}}
                            <form id="delete-form-{{ $user->id }}" 
                                  action="{{ route('admin.users.destroy', $user) }}" 
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        onclick="confirmDelete({{ $user->id }})"
                                        class="text-red-600 hover:text-red-800 font-semibold">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No hay usuarios registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>

{{-- SweetAlert2 --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(userId) {
        Swal.fire({
            title: '¿Eliminar usuario?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#F97316',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + userId).submit();
            }
        });
    }
</script>
@endpush
@endsection
