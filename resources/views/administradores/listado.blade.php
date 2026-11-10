@extends('plantilla.layout')

@section('titulo', 'Listado de administradores')

@section('contenido')
@if (session('status'))
    <div class="mb-6 rounded-lg bg-emerald-50 p-4 text-sm text-emerald-800" role="status">
        {{ session('status') }}
    </div>
@endif
@if (session('error'))
    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800" role="alert">
        {{ session('error') }}
    </div>
@endif

<section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
    <div class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between dark:border-slate-700">
        <div>
            <p class="text-sm font-semibold uppercase tracking-widest text-cyan-600">Administradores</p>
            <h1 class="mt-2 text-2xl font-bold">Listado de administradores</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $administradores->count() }} registro(s)</p>
        </div>
        <a href="{{ url('/admin/crear') }}" class="rounded-lg bg-cyan-500 px-4 py-2.5 text-center text-sm font-semibold text-slate-950 hover:bg-cyan-400">
            Nuevo administrador
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-xs uppercase text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Nombre</th>
                    <th class="px-6 py-3">Correo</th>
                    <th class="px-6 py-3">Usuario</th>
                    <th class="px-6 py-3">Teléfono</th>
                    <th class="px-6 py-3">Rol</th>
                    <th class="px-6 py-3">Estado</th>
                    <th class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($administradores as $administrador)
                    <tr class="border-b border-slate-200 dark:border-slate-700">
                        <td class="px-6 py-4">{{ $administrador->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if ($administrador->url_imagen)
                                    <img src="{{ $administrador->url_imagen }}" alt="Imagen de {{ $administrador->nombres }}" class="h-10 w-10 rounded-full object-cover">
                                @endif
                                <span>{{ $administrador->nombres }} {{ $administrador->apellidos }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">{{ $administrador->correo }}</td>
                        <td class="px-6 py-4">{{ $administrador->usuario }}</td>
                        <td class="px-6 py-4">{{ $administrador->telefono }}</td>
                        <td class="px-6 py-4">{{ $administrador->rol?->nombre ?? '—' }}</td>
                        <td class="px-6 py-4">{{ (string) $administrador->estado === '1' ? 'Activo' : 'Inactivo' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-3">
                                <a class="text-cyan-700 hover:underline dark:text-cyan-300" href="{{ url('/admin/mostrar/'.$administrador->id) }}">Mostrar</a>
                                <a class="text-cyan-700 hover:underline dark:text-cyan-300" href="{{ url('/admin/editar/'.$administrador->id) }}">Editar</a>
                                <form action="{{ url('/admin/borrar/'.$administrador->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este administrador?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-700 hover:underline dark:text-red-300">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-10 text-center text-slate-500 dark:text-slate-400">No hay administradores registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
