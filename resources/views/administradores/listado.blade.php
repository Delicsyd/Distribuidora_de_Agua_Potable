@extends('plantilla.layout')

@section('titulo', 'Listado de administradores')
@section('contenido')
@php($administradores = $administradores ?? collect())
<section
    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
    <div
        class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between dark:border-slate-700">
        <div>
            <p class="text-sm font-semibold uppercase tracking-widest text-cyan-600">Administradores</p>
            <h1 class="mt-2 text-2xl font-bold">Listado de administradores</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $administradores->count() }} registro(s)</p>
        </div>
        <a href="{{ url('/admin/crear') }}"
            class="rounded-lg bg-cyan-500 px-4 py-2.5 text-center text-sm font-semibold text-slate-950 hover:bg-cyan-400">Nuevo
            administrador</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-xs uppercase text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Nombres</th>
                    <th class="px-6 py-3">Apellidos</th>
                    <th class="px-6 py-3">Correo</th>
                    <th class="px-6 py-3">Usuario</th>
                    <th class="px-6 py-3">Contraseña</th>
                    <th class="px-6 py-3">Imagen</th>
                     <th class="px-6 py-3">Telefono</th>
                    <th class="px-6 py-3">Rol</th>
                    <th class="px-6 py-3">Direccion</th>
                    <th class="px-6 py-3">Estado</th>
                    <th class="px-6 py-3"></th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ( $admins as $admin )
                
                @endforeach ($administradores as $administrador)
                    <tr class="border-b border-slate-200 dark:border-slate-700">
                        <td class="px-6 py-3">
                            {{ $admin->id }}</td>
                        <td class="px-6 py-4">
                            {{ $admin->nombres }}</td>
                        <td class="px-6 py-4">
                            {{ $admin->apellidos }}</td>
                        <td class="px-6 py-4">
                            {{ $admin->correo }}</td>
                        <td class="px-6 py-4">
                            {{ $admin->usuario }}</td>
                        <td class="px-6 py-4">
                            {{ $admin->contraseña }}</td>
                        <td class="px-6 py-4">
                            {{ $admin->url_imagen }}</td>
                            <td class="px-6 py-4">
                            {{ $admin->Telefono }}</td>
                            <td class="px-6 py-4">
                            {{ $admin->Rol }}</td>
                            <td class="px-6 py-4">
                            {{ $admin->Direccion }}</td>
                            <td class="px-6 py-4">
                            {{ $admin->Estado}}</td>
                            <td class="px-6 py-4">
                            {{ $admin->Editar }}</td>
                            <td  class="px-6 py-4">
                            {{ $admin->Eliminar }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-slate-500 dark:text-slate-400">No hay
                            administradores registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection