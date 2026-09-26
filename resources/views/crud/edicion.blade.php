@extends('plantilla.layout')

@section('titulo', 'Edición de '.$modulo)

@section('contenido')
<div class="mx-auto max-w-5xl">
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-900 sm:p-8">
        <div class="mb-8">
            <p class="text-sm font-semibold uppercase tracking-widest text-cyan-600">{{ $modelo }} · ID {{ $registro['id'] }}</p>
            <h1 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">Editar {{ $modulo }}</h1>
        </div>

        <form action="{{ url($ruta.'/actualizar') }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $registro['id'] }}">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                @foreach ($campos as $nombre => $campo)
                    <div class="{{ $campo['tipo'] === 'textarea' ? 'sm:col-span-2' : '' }}">
                        <label for="{{ $nombre }}" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">{{ $campo['etiqueta'] }}</label>
                        @if ($campo['tipo'] === 'textarea')
                            <textarea id="{{ $nombre }}" name="{{ $nombre }}" rows="3" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ $registro[$nombre] ?? '' }}</textarea>
                        @elseif ($campo['tipo'] === 'select')
                            <select id="{{ $nombre }}" name="{{ $nombre }}" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                @if (isset($campo['opciones']))
                                    @foreach ($campo['opciones'] as $opcion)
                                        <option value="{{ $opcion }}" @selected(($registro[$nombre] ?? '') === $opcion)>{{ $opcion }}</option>
                                    @endforeach
                                @else
                                    <option>{{ $registro[$nombre] ?? 'Opción de prueba' }}</option>
                                    <option>Otra opción de ejemplo</option>
                                @endif
                            </select>
                        @else
                            <input type="{{ $campo['tipo'] }}" id="{{ $nombre }}" name="{{ $nombre }}" value="{{ $campo['tipo'] === 'password' ? '' : ($registro[$nombre] ?? '') }}" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="mt-8 flex flex-wrap gap-3 border-t border-slate-200 pt-6 dark:border-slate-700">
                <button type="submit" class="rounded-lg bg-cyan-500 px-5 py-2.5 text-sm font-semibold text-slate-950 hover:bg-cyan-400">Actualizar</button>
                <a href="{{ url($ruta.'/listar') }}" class="rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-800">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
