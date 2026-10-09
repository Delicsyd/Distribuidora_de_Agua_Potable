@extends('plantilla.layout')

@section('titulo', 'Registro de administrador')

@section('contenido')
@php
    $roles = $roles ?? collect();
@endphp

<div class="mx-auto max-w-5xl">
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-900 sm:p-8">
        <div class="mb-8">
            <p class="text-sm font-semibold uppercase tracking-widest text-cyan-600">Administradores</p>
            <h1 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">Registro de administrador</h1>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Completa los datos del nuevo administrador.</p>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-lg border border-green-300 bg-green-50 p-4 text-sm text-green-800 dark:border-green-800 dark:bg-gray-800 dark:text-green-400">
                {{ session('success') }}
            </div>
        @endif

        <form id="form-administrador" action="{{ url('/admin/guardar') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label for="nombres" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Nombres <span class="text-red-500">*</span></label>
                    <input type="text" id="nombres" name="nombres" value="{{ old('nombres') }}" placeholder="Ej. Carlos Eduardo" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    @error('nombres')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="apellidos" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Apellidos <span class="text-red-500">*</span></label>
                    <input type="text" id="apellidos" name="apellidos" value="{{ old('apellidos') }}" placeholder="Ej. Gómez Pérez" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    @error('apellidos')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="usuario" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Usuario <span class="text-red-500">*</span></label>
                    <input type="text" id="usuario" name="usuario" value="{{ old('usuario') }}" placeholder="cgomez" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    @error('usuario')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="correo" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Correo electrónico <span class="text-red-500">*</span></label>
                    <input type="email" id="correo" name="correo" value="{{ old('correo') }}" placeholder="admin@empresa.com" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    @error('correo')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="contraseña" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Contraseña <span class="text-red-500">*</span></label>
                    <input type="password" id="contraseña" name="contraseña" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    @error('contraseña')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="contraseña_confirmation" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Confirmar contraseña <span class="text-red-500">*</span></label>
                    <input type="password" id="contraseña_confirmation" name="contraseña_confirmation" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>

                <div>
                    <label for="telefono" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Teléfono <span class="text-red-500">*</span></label>
                    <input type="tel" id="telefono" name="telefono" value="{{ old('telefono') }}" placeholder="5555-5555" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    @error('telefono')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="rol" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Rol <span class="text-red-500">*</span></label>
                    <select id="rol" name="rol" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">-- Seleccione un rol --</option>
                        @foreach ($roles as $rol)
                            <option value="{{ $rol->id ?? $rol['id'] }}" @selected(old('rol') == ($rol->id ?? $rol['id']))>{{ $rol->nombre ?? $rol['nombre'] }}</option>
                        @endforeach
                    </select>
                    @error('rol')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="estado" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Estado <span class="text-red-500">*</span></label>
                    <select id="estado" name="estado" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="1" @selected(old('estado', '1') == '1')>Activo</option>
                        <option value="0" @selected(old('estado') === '0')>Inactivo</option>
                    </select>
                    @error('estado')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="direccion" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Dirección</label>
                    <input type="text" id="direccion" name="direccion" value="{{ old('direccion') }}" placeholder="Dirección del administrador" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    @error('direccion')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="url_imagen" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Imagen de perfil</label>
                    <input type="file" id="url_imagen" name="url_imagen" accept="image/png,image/jpeg,image/webp" class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400">
                    @error('url_imagen')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="mt-8 flex flex-wrap gap-3 border-t border-slate-200 pt-6 dark:border-slate-700">
                <button type="submit" class="rounded-lg bg-cyan-500 px-5 py-2.5 text-sm font-semibold text-slate-950 hover:bg-cyan-400">Guardar administrador</button>
                <button type="reset" class="rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-800">Limpiar formulario</button>
                <a href="{{ url('/admin/listar') }}" class="rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-800">Ver listado</a>
            </div>
        </form>
    </div>
</div>
@endsection
