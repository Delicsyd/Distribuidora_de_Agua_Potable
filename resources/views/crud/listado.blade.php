@extends('plantilla.layout')

@section('titulo', 'Listado de '.$modulo)

@section('contenido')
<div class="mx-auto max-w-7xl space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-sm font-semibold uppercase tracking-widest text-cyan-600">{{ $modelo }}</p>
            <h1 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">Listado de {{ $modulo }}</h1>
        </div>
        <a href="{{ url($ruta.'/crear') }}" class="rounded-lg bg-cyan-500 px-5 py-2.5 text-sm font-semibold text-slate-950 hover:bg-cyan-400">Nuevo registro</a>
    </div>

    <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-xs uppercase text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                <tr>
                    <th class="px-5 py-3">ID</th>
                    @foreach ($campos as $campo)
                        <th class="px-5 py-3">{{ $campo['etiqueta'] }}</th>
                    @endforeach
                    <th class="px-5 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($registros as $registro)
                    <tr class="border-t border-slate-200 dark:border-slate-700">
                        <td class="px-5 py-4">{{ $registro['id'] }}</td>
                        @foreach ($campos as $nombre => $campo)
                            <td class="px-5 py-4">{{ $campo['tipo'] === 'password' ? '••••••' : ($registro[$nombre] ?? '—') }}</td>
                        @endforeach
                        <td class="px-5 py-4">
                            <div class="flex flex-wrap gap-3">
                                <a class="text-cyan-700 hover:underline dark:text-cyan-300" href="{{ url($ruta.'/mostrar?id='.$registro['id']) }}">Mostrar</a>
                                <a class="text-cyan-700 hover:underline dark:text-cyan-300" href="{{ url($ruta.'/editar?id='.$registro['id']) }}">Editar</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="{{ count($campos) + 2 }}" class="px-5 py-8 text-center text-slate-500">No hay datos de ejemplo para mostrar.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
