@extends('plantilla.layout')

@section('titulo', 'Clima por ubicación')

@section('contenido')
<section class="mx-auto max-w-3xl rounded-2xl border border-slate-200 bg-white p-8 shadow-sm dark:border-slate-700 dark:bg-slate-900">
    <p class="text-sm font-semibold uppercase tracking-widest text-cyan-600 dark:text-cyan-300">
        Pronóstico por IP
    </p>
    <h1 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">
        Clima actual
    </h1>
    <p class="mt-2 text-slate-600 dark:text-slate-300">
        {{ $ubicacion['city'] ?? 'Ciudad desconocida' }},
        {{ $ubicacion['regionName'] ?? '' }},
        {{ $ubicacion['country'] ?? '' }}
    </p>
    <p class="mt-1 break-all text-sm text-slate-500 dark:text-slate-400">
        IP consultada: {{ $ip }}
    </p>

    <dl class="mt-8 grid gap-4 sm:grid-cols-3">
        <div class="rounded-xl bg-slate-50 p-5 dark:bg-slate-800">
            <dt class="text-sm text-slate-500 dark:text-slate-400">Temperatura</dt>
            <dd class="mt-2 text-2xl font-bold">{{ $temperatura }} °C</dd>
        </div>
        <div class="rounded-xl bg-slate-50 p-5 dark:bg-slate-800">
            <dt class="text-sm text-slate-500 dark:text-slate-400">Humedad</dt>
            <dd class="mt-2 text-2xl font-bold">{{ $humedad }} %</dd>
        </div>
        <div class="rounded-xl bg-slate-50 p-5 dark:bg-slate-800">
            <dt class="text-sm text-slate-500 dark:text-slate-400">Probabilidad de lluvia</dt>
            <dd class="mt-2 text-2xl font-bold">{{ $probabilidadLluvia }} %</dd>
        </div>
    </dl>
    <p class="mt-6 text-sm text-slate-500 dark:text-slate-400">
        Hora local del pronóstico: {{ $hora }}
    </p>
</section>
@endsection
