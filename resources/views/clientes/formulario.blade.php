@extends('plantilla.layout')

@section('titulo', 'Formulario de clientes')
@section('contenido')
<section class="mx-auto max-w-4xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-900">
    <div class="mb-6"><p class="text-sm font-semibold uppercase tracking-widest text-cyan-600">Clientes</p><h1 class="mt-2 text-2xl font-bold">Formulario de clientes</h1><p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Completa los datos requeridos para registrar un cliente.</p></div>
    <form action="{{ route('clientes.formulario') }}" method="GET" class="grid gap-5 md:grid-cols-2">
        <label class="text-sm font-medium">Nombres <span class="text-red-500">*</span><input name="nombres" type="text" class="mt-2 block w-full rounded-lg border border-slate-300 bg-slate-50 p-2.5 focus:border-cyan-500 focus:ring-cyan-500 dark:border-slate-600 dark:bg-slate-800" required></label>
        <label class="text-sm font-medium">Apellidos <span class="text-red-500">*</span><input name="apellidos" type="text" class="mt-2 block w-full rounded-lg border border-slate-300 bg-slate-50 p-2.5 focus:border-cyan-500 focus:ring-cyan-500 dark:border-slate-600 dark:bg-slate-800" required></label>
        <label class="text-sm font-medium">Correo <span class="text-red-500">*</span><input name="correo" type="email" class="mt-2 block w-full rounded-lg border border-slate-300 bg-slate-50 p-2.5 focus:border-cyan-500 focus:ring-cyan-500 dark:border-slate-600 dark:bg-slate-800" required></label>
        <label class="text-sm font-medium">Contraseña <span class="text-red-500">*</span><input name="contraseña" type="password" class="mt-2 block w-full rounded-lg border border-slate-300 bg-slate-50 p-2.5 focus:border-cyan-500 focus:ring-cyan-500 dark:border-slate-600 dark:bg-slate-800" required></label>
        <label class="text-sm font-medium">Teléfono <span class="text-red-500">*</span><input name="telefono" type="tel" maxlength="10" class="mt-2 block w-full rounded-lg border border-slate-300 bg-slate-50 p-2.5 focus:border-cyan-500 focus:ring-cyan-500 dark:border-slate-600 dark:bg-slate-800" required></label>
        <label class="text-sm font-medium">Imagen<input name="imagen" type="file" class="mt-2 block w-full rounded-lg border border-slate-300 bg-slate-50 p-2 dark:border-slate-600 dark:bg-slate-800"></label>
        <label class="flex items-center gap-3 text-sm font-medium md:col-span-2"><input name="estado" type="checkbox" value="1" checked class="h-4 w-4 rounded text-cyan-600 focus:ring-cyan-500"> Cliente activo</label>
        <button type="submit" class="rounded-lg bg-cyan-500 px-5 py-2.5 text-sm font-semibold text-slate-950 hover:bg-cyan-400 md:w-fit">Guardar cliente</button>
    </form>
</section>
@endsection
