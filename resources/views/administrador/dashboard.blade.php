@extends('plantilla.layout')

@section('titulo', 'Panel de administrador')

@section('contenido')
<div class="space-y-8">
    <div>
        <p class="text-sm font-semibold uppercase tracking-widest text-cyan-600">Administración</p>
        <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">Panel de administrador</h1>
        <p class="mt-2 max-w-2xl text-slate-500 dark:text-slate-400">Selecciona una sección para comenzar a gestionar la distribuidora.</p>
    </div>

    <div class="grid gap-6 md:grid-cols-3">
        <a href="{{ url('/admin/crear') }}" class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-cyan-400 hover:shadow-md dark:border-slate-700 dark:bg-slate-800">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-100 text-xl font-bold text-cyan-700 dark:bg-cyan-900/50 dark:text-cyan-300">A</div>
            <h2 class="mt-5 text-xl font-bold text-slate-900 group-hover:text-cyan-700 dark:text-white dark:group-hover:text-cyan-300">Administradores</h2>
            <p class="mt-2 text-sm leading-relaxed text-slate-500 dark:text-slate-400">Registra nuevos usuarios y consulta los administradores existentes.</p>
            <span class="mt-5 inline-block text-sm font-semibold text-cyan-700 dark:text-cyan-300">Gestionar →</span>
        </a>
        <a href="{{ url('/clientes') }}" class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-blue-400 hover:shadow-md dark:border-slate-700 dark:bg-slate-800">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-xl font-bold text-blue-700 dark:bg-blue-900/50 dark:text-blue-300">C</div>
            <h2 class="mt-5 text-xl font-bold text-slate-900 group-hover:text-blue-700 dark:text-white dark:group-hover:text-blue-300">Clientes</h2>
            <p class="mt-2 text-sm leading-relaxed text-slate-500 dark:text-slate-400">Consulta y administra la información de tus clientes.</p>
            <span class="mt-5 inline-block text-sm font-semibold text-blue-700 dark:text-blue-300">Gestionar →</span>
        </a>
        <a href="{{ url('/productos') }}" class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-violet-400 hover:shadow-md dark:border-slate-700 dark:bg-slate-800">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-100 text-xl font-bold text-violet-700 dark:bg-violet-900/50 dark:text-violet-300">P</div>
            <h2 class="mt-5 text-xl font-bold text-slate-900 group-hover:text-violet-700 dark:text-white dark:group-hover:text-violet-300">Productos</h2>
            <p class="mt-2 text-sm leading-relaxed text-slate-500 dark:text-slate-400">Mantén actualizado el catálogo y sus presentaciones.</p>
            <span class="mt-5 inline-block text-sm font-semibold text-violet-700 dark:text-violet-300">Gestionar →</span>
        </a>
    </div>
</div>
@endsection
