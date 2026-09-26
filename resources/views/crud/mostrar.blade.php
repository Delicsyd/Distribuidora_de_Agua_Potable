@extends('plantilla.layout')

@section('titulo', 'Detalle de '.$modulo)

@section('contenido')
<div class="mx-auto max-w-5xl">
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-900 sm:p-8">
        <div class="mb-8">
            <p class="text-sm font-semibold uppercase tracking-widest text-cyan-600">{{ $modelo }} · ID {{ $registro['id'] }}</p>
            <h1 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">Detalle de {{ $modulo }}</h1>
        </div>

        <dl class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            @foreach ($campos as $nombre => $campo)
                <div>
                    <dt class="mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $campo['etiqueta'] }}</dt>
                    <dd class="rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ $campo['tipo'] === 'password' ? '••••••' : ($registro[$nombre] ?? '—') }}</dd>
                </div>
            @endforeach
        </dl>

        <div class="mt-8 flex flex-wrap gap-3 border-t border-slate-200 pt-6 dark:border-slate-700">
            <a href="{{ url($ruta.'/editar?id='.$registro['id']) }}" class="rounded-lg bg-cyan-500 px-5 py-2.5 text-sm font-semibold text-slate-950 hover:bg-cyan-400">Editar</a>
            <form action="{{ url($ruta.'/borrar') }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" value="{{ $registro['id'] }}">
                <button type="submit" class="rounded-lg bg-red-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-red-700">Borrar</button>
            </form>
            <a href="{{ url($ruta.'/listar') }}" class="rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-800">Volver al listado</a>
        </div>
    </div>
</div>
@endsection
