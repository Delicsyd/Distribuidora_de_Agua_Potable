@extends('plantilla.layout')

@section('titulo', 'Mostrar administrador')

@section('contenido')
@php
    $administrador = $administrador ?? null;
    $value = fn ($field, $default = '') => data_get($administrador, $field, $default);
@endphp

<div class="mx-auto max-w-5xl">
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-900 sm:p-8">
        <div class="mb-8">
            <p class="text-sm font-semibold uppercase tracking-widest text-cyan-600">Administradores</p>
            <h1 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">Datos del administrador</h1>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Consulta la información registrada.</p>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            @foreach ([
                ['nombres', 'Nombres'],
                ['apellidos', 'Apellidos'],
                ['usuario', 'Usuario'],
                ['correo', 'Correo electrónico'],
                ['telefono', 'Teléfono'],
                ['rol', 'Rol'],
                ['estado', 'Estado'],
                ['direccion', 'Dirección'],
            ] as [$name, $label])
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">{{ $label }}</label>
                    <div class="min-h-10 rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        {{ $name === 'estado' ? ($value($name) ? 'Activo' : 'Inactivo') : ($value($name) ?: 'No registrado') }}
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 flex flex-wrap gap-3 border-t border-slate-200 pt-6 dark:border-slate-700">
            <form action="{{ url('/admin/borrar') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="rounded-lg bg-red-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-red-700">Borrar administrador</button>
            </form>
            <a href="{{ url('/admin/editar') }}" class="rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-800">Editar</a>
            <a href="{{ url('/admin/listar') }}" class="rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-800">Volver al listado</a>
        </div>
    </div>
</div>
@endsection
