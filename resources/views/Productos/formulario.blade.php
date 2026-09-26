@extends('plantilla.layout')

@section('titulo', 'Formulario de productos')
@section('contenido')
<section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-900">
    <div class="mb-6"><p class="text-sm font-semibold uppercase tracking-widest text-cyan-600">Productos</p><h1 class="mt-2 text-2xl font-bold">Formulario de productos</h1><p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Completa los datos requeridos para registrar un producto.</p></div>
    <form action="{{ route('productos.formulario') }}" method="GET" class="grid gap-5 md:grid-cols-2">
        <label class="text-sm font-medium">Nombre <span class="text-red-500">*</span><input name="nombre" type="text" class="mt-2 block w-full rounded-lg border border-slate-300 bg-slate-50 p-2.5 focus:border-cyan-500 focus:ring-cyan-500 dark:border-slate-600 dark:bg-slate-800" required></label>
        <label class="text-sm font-medium">Categoría <span class="text-red-500">*</span><input name="categoria_id" type="number" class="mt-2 block w-full rounded-lg border border-slate-300 bg-slate-50 p-2.5 focus:border-cyan-500 focus:ring-cyan-500 dark:border-slate-600 dark:bg-slate-800" required></label>
        <label class="text-sm font-medium md:col-span-2">Descripción<textarea name="descripcion" rows="3" class="mt-2 block w-full rounded-lg border border-slate-300 bg-slate-50 p-2.5 focus:border-cyan-500 focus:ring-cyan-500 dark:border-slate-600 dark:bg-slate-800"></textarea></label>
        <label class="text-sm font-medium">Presentación <span class="text-red-500">*</span><input name="presentacion_id" type="number" class="mt-2 block w-full rounded-lg border border-slate-300 bg-slate-50 p-2.5 focus:border-cyan-500 focus:ring-cyan-500 dark:border-slate-600 dark:bg-slate-800" required></label>
        <label class="text-sm font-medium">Marca <span class="text-red-500">*</span><input name="marca_id" type="number" class="mt-2 block w-full rounded-lg border border-slate-300 bg-slate-50 p-2.5 focus:border-cyan-500 focus:ring-cyan-500 dark:border-slate-600 dark:bg-slate-800" required></label>
        <label class="text-sm font-medium">Precio <span class="text-red-500">*</span><input name="precio" type="number" step="0.01" class="mt-2 block w-full rounded-lg border border-slate-300 bg-slate-50 p-2.5 focus:border-cyan-500 focus:ring-cyan-500 dark:border-slate-600 dark:bg-slate-800" required></label>
        <label class="text-sm font-medium">Existencia <span class="text-red-500">*</span><input name="existencia" type="number" min="0" class="mt-2 block w-full rounded-lg border border-slate-300 bg-slate-50 p-2.5 focus:border-cyan-500 focus:ring-cyan-500 dark:border-slate-600 dark:bg-slate-800" required></label>
        <label class="text-sm font-medium">Descuento<input name="descuento" type="number" step="0.01" min="0" class="mt-2 block w-full rounded-lg border border-slate-300 bg-slate-50 p-2.5 focus:border-cyan-500 focus:ring-cyan-500 dark:border-slate-600 dark:bg-slate-800"></label>
        <label class="text-sm font-medium">Imagen<input name="imagen" type="file" class="mt-2 block w-full rounded-lg border border-slate-300 bg-slate-50 p-2 dark:border-slate-600 dark:bg-slate-800"></label>
        <label class="text-sm font-medium">Imagen secundaria<input name="imagen_secundaria" type="file" class="mt-2 block w-full rounded-lg border border-slate-300 bg-slate-50 p-2 dark:border-slate-600 dark:bg-slate-800"></label>
        <label class="text-sm font-medium">Imagen terciaria<input name="imagen_terciaria" type="file" class="mt-2 block w-full rounded-lg border border-slate-300 bg-slate-50 p-2 dark:border-slate-600 dark:bg-slate-800"></label>
        <label class="flex items-center gap-3 text-sm font-medium md:col-span-2"><input name="estado" type="checkbox" value="1" checked class="h-4 w-4 rounded text-cyan-600 focus:ring-cyan-500"> Producto activo</label>
        <button type="submit" class="rounded-lg bg-cyan-500 px-5 py-2.5 text-sm font-semibold text-slate-950 hover:bg-cyan-400 md:w-fit">Guardar producto</button>
    </form>
</section>
@endsection
