@extends('plantilla.layout')

@section('titulo', 'Listado de productos')
@section('contenido')
<section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
    <div class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between dark:border-slate-700">
        <div><p class="text-sm font-semibold uppercase tracking-widest text-cyan-600">Productos</p><h1 class="mt-2 text-2xl font-bold">Listado de productos</h1><p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Consulta el catálogo y el inventario disponible.</p></div>
        <a href="{{ route('productos.formulario') }}" class="rounded-lg bg-cyan-500 px-4 py-2.5 text-sm font-semibold text-slate-950 hover:bg-cyan-400">Nuevo producto</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full min-w-max text-left text-sm">
            <thead class="bg-slate-100 text-xs uppercase text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                <tr><th class="px-6 py-3">ID</th><th class="px-6 py-3">Nombre</th><th class="px-6 py-3">Descripción</th><th class="px-6 py-3">Categoría</th><th class="px-6 py-3">Presentación</th><th class="px-6 py-3">Marca</th><th class="px-6 py-3">Precio</th><th class="px-6 py-3">Existencia</th><th class="px-6 py-3">Descuento</th><th class="px-6 py-3">Imagen</th><th class="px-6 py-3">Imagen secundaria</th><th class="px-6 py-3">Imagen terciaria</th><th class="px-6 py-3">Estado</th></tr>
            </thead>
            <tbody><tr class="border-t border-slate-200 dark:border-slate-700"><td colspan="13" class="px-6 py-10 text-center text-slate-500 dark:text-slate-400">No hay productos registrados.</td></tr></tbody>
        </table>
    </div>
</section>
@endsection
