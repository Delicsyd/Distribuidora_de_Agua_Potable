@extends('plantilla.layout')

@section('titulo', 'Inicio')

@section('contenido')
<section class="overflow-hidden rounded-2xl bg-slate-900 shadow-xl">
    <div class="grid items-center gap-10 px-6 py-12 sm:px-10 lg:grid-cols-[1.2fr_0.8fr] lg:px-16 lg:py-16">
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
                <a href="{{ url('/inicio') }}" class="rounded-lg bg-cyan-500 px-5 py-3 text-sm font-semibold text-slate-950 shadow-sm hover:bg-cyan-400">
                    Entrar al administrador
                </a>
                <a href="{{ url('/productos') }}" class="rounded-lg border border-slate-600 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                    Ver productos
                </a>
            </div>
        </div>
        <div class="rounded-2xl border border-slate-700 bg-slate-800 p-6" aria-label="Resumen del panel">
            <p class="text-sm font-medium text-slate-400">Acceso rápido</p>
            <div class="mt-5 space-y-3">
                <a href="{{ url('/admin/crear') }}" class="flex items-center justify-between rounded-xl bg-slate-700/70 p-4 text-sm font-semibold text-white hover:bg-slate-700">
                    <span>Registrar administrador</span><span class="text-cyan-300">→</span>
                </a>
                <a href="{{ url('/clientes') }}" class="flex items-center justify-between rounded-xl bg-slate-700/70 p-4 text-sm font-semibold text-white hover:bg-slate-700">
                    <span>Consultar clientes</span><span class="text-cyan-300">→</span>
                </a>
                <a href="{{ url('/productos') }}" class="flex items-center justify-between rounded-xl bg-slate-700/70 p-4 text-sm font-semibold text-white hover:bg-slate-700">
                    <span>Catálogo de productos</span><span class="text-cyan-300">→</span>
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

<section class="mt-10 rounded-xl border border-gray-200 bg-white p-8 text-center shadow-sm dark:border-gray-700 dark:bg-gray-800">
    <h2 class="text-2xl font-bold">Conoce nuestro catálogo</h2>
    <p class="mx-auto mt-2 max-w-2xl text-gray-500 dark:text-gray-400">Explora las opciones disponibles y encuentra la presentación ideal para ti.</p>
    <a href="{{ url('/productos') }}" class="mt-5 inline-block rounded-lg bg-blue-700 px-5 py-3 text-sm font-medium text-white hover:bg-blue-800">Consultar productos</a>
</section>
@endsection
