@extends('plantilla.layout')

@section('titulo', 'Editar administrador')

@section('contenido')
@php
    $roles = $roles ?? collect();
    $administrador = $administrador ?? null;
    $value = fn ($field, $default = '') => old($field, data_get($administrador, $field, $default));
@endphp

<div class="mx-auto max-w-5xl">
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-900 sm:p-8">
        <div class="mb-8">
            <p class="text-sm font-semibold uppercase tracking-widest text-cyan-600">Administradores</p>
            <h1 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">Editar administrador</h1>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Actualiza la información del administrador.</p>
        </div>

        <form action="{{ url('/admin/actualizar') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                @foreach ([
                    ['nombres', 'Nombres', 'text', 'Ej. Carlos Eduardo'],
                    ['apellidos', 'Apellidos', 'text', 'Ej. Gómez Pérez'],
                    ['usuario', 'Usuario', 'text', 'cgomez'],
                    ['correo', 'Correo electrónico', 'email', 'admin@empresa.com'],
                    ['telefono', 'Teléfono', 'tel', '5555-5555'],
                ] as [$name, $label, $type, $placeholder])
                    <div>
                        <label for="{{ $name }}" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">{{ $label }} <span class="text-red-500">*</span></label>
                        <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" value="{{ $value($name) }}" placeholder="{{ $placeholder }}" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        @error($name)<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                @endforeach

                <div>
                    <label for="rol" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Rol <span class="text-red-500">*</span></label>
                    <select id="rol" name="rol" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">-- Seleccione un rol --</option>
                        @foreach ($roles as $rol)
                            <option value="{{ $rol->id ?? $rol['id'] }}" @selected($value('rol') == ($rol->id ?? $rol['id']))>{{ $rol->nombre ?? $rol['nombre'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="estado" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Estado <span class="text-red-500">*</span></label>
                    <select id="estado" name="estado" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="1" @selected($value('estado', '1') == '1')>Activo</option>
                        <option value="0" @selected($value('estado') === '0')>Inactivo</option>
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label for="direccion" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Dirección</label>
                    <input type="text" id="direccion" name="direccion" value="{{ $value('direccion') }}" placeholder="Dirección del administrador" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>

                <div>
                    <label for="contraseña" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Nueva contraseña</label>
                    <input type="password" id="contraseña" name="contraseña" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>

                <div>
                    <label for="url_imagen" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Imagen de perfil</label>
                    <input type="file" id="url_imagen" name="url_imagen" accept="image/png,image/jpeg,image/webp" class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400">
                </div>
            </div>

            <div class="mt-8 flex flex-wrap gap-3 border-t border-slate-200 pt-6 dark:border-slate-700">
                <button type="submit" class="rounded-lg bg-cyan-500 px-5 py-2.5 text-sm font-semibold text-slate-950 hover:bg-cyan-400">Actualizar administrador</button>
                <a href="{{ url('/admin/listar') }}" class="rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-800">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
