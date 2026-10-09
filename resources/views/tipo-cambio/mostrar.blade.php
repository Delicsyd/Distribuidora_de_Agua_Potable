@extends('plantilla.layout')

@section('titulo', 'Tipo de cambio USD/MXN')

@section('contenido')
<section class="mx-auto max-w-2xl rounded-2xl border border-slate-200 bg-white p-8 text-center shadow-sm dark:border-slate-700 dark:bg-slate-900">
    <p class="text-sm font-semibold uppercase tracking-widest text-cyan-600 dark:text-cyan-300">
        Tipo de cambio
    </p>
    <h1 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">
        Dólar estadounidense a peso mexicano
    </h1>
    <p class="mt-2 text-slate-600 dark:text-slate-300">
        Consulta desde {{ $ubicacion['city'] ?? 'ubicación desconocida' }},
        {{ $ubicacion['country'] ?? '' }}
    </p>
    <p class="mt-1 break-all text-sm text-slate-500 dark:text-slate-400">
        IP consultada: {{ $ip }}
    </p>

    <p class="mt-8 text-5xl font-extrabold text-slate-900 dark:text-white">
        ${{ number_format($tasa, 4) }}
        <span class="text-2xl font-semibold">MXN</span>
    </p>
    <p class="mt-3 text-lg text-slate-600 dark:text-slate-300">
        1 USD = {{ number_format($tasa, 4) }} MXN
    </p>
    <p class="mt-6 text-sm text-slate-500 dark:text-slate-400">
        Última actualización de la fuente: {{ $actualizado }}
    </p>
</section>
@endsection
