@extends('plantilla.layout')

@section('titulo', 'Inicio')

@section('contenido')
<section class="overflow-hidden rounded-2xl bg-slate-900 shadow-xl">
    <div class="px-6 py-12 sm:px-10 lg:px-16 lg:py-16">
        <div class="text-white">
            <div class="mb-6 flex items-center gap-3">
                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-500 text-xl font-bold">DA</span>
                <div>
                    <p class="text-sm font-semibold uppercase tracking-widest text-cyan-300">Panel de control</p>
                    <p class="text-xs text-slate-400">Distribuidora de Agua Potable</p>
                </div>
            </div>
            <h1 class="text-4xl font-extrabold leading-tight sm:text-5xl">
                Gestiona tu distribuidora desde un solo lugar
            </h1>
            <p class="mt-5 max-w-xl text-lg leading-relaxed text-slate-300">
                Consulta productos, clientes y administradores con una interfaz clara,
                rápida y pensada para el trabajo diario.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ url('/admin/listar') }}" class="rounded-lg bg-cyan-500 px-5 py-3 text-sm font-semibold text-slate-950 shadow-sm hover:bg-cyan-400">
                    Entrar al administrador
                </a>
            </div>
        </div>
    </div>
</section>

<section class="mt-10 grid gap-6 md:grid-cols-3">
    <article class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 text-2xl text-blue-700 dark:bg-blue-900 dark:text-blue-300">✓</div>
        <h2 class="text-xl font-bold">Calidad garantizada</h2>
        <p class="mt-2 text-sm leading-relaxed text-gray-500 dark:text-gray-400">Productos seleccionados para ofrecer agua segura y confiable.</p>
    </article>
    <article class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-cyan-100 text-2xl text-cyan-700 dark:bg-cyan-900 dark:text-cyan-300">⌁</div>
        <h2 class="text-xl font-bold">Entrega confiable</h2>
        <p class="mt-2 text-sm leading-relaxed text-gray-500 dark:text-gray-400">Atendemos tus pedidos con rapidez y puntualidad.</p>
    </article>
    <article class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-green-100 text-2xl text-green-700 dark:bg-green-900 dark:text-green-300">★</div>
        <h2 class="text-xl font-bold">Atención cercana</h2>
        <p class="mt-2 text-sm leading-relaxed text-gray-500 dark:text-gray-400">Estamos disponibles para ayudarte en cada compra.</p>
    </article>
</section>

@endsection
