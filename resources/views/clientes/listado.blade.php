@extends('plantilla.layout')

@section('titulo', 'Listado de clientes')
@section('contenido')
<section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
    <div class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between dark:border-slate-700">
        <div><p class="text-sm font-semibold uppercase tracking-widest text-cyan-600">Clientes</p><h1 class="mt-2 text-2xl font-bold">Listado de clientes</h1><p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Consulta los clientes registrados en la distribuidora.</p></div>
        <a href="{{ route('clientes.formulario') }}" class="rounded-lg bg-cyan-500 px-4 py-2.5 text-sm font-semibold text-slate-950 hover:bg-cyan-400">Nuevo cliente</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-xs uppercase text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                <tr><th class="px-6 py-3">ID</th><th class="px-6 py-3">Nombres</th><th class="px-6 py-3">Apellidos</th><th class="px-6 py-3">Correo</th><th class="px-6 py-3">Contraseña</th><th class="px-6 py-3">Teléfono</th><th class="px-6 py-3">Imagen</th><th class="px-6 py-3">Estado</th></tr>
            </thead>
            <tbody><tr class="border-t border-slate-200 dark:border-slate-700"><td colspan="8" class="px-6 py-10 text-center text-slate-500 dark:text-slate-400">No hay clientes registrados.</td></tr></tbody>
        </table>
    </div>
</section>
@endsection


   
