@extends('plantilla.layout')

@section('titulo', 'Listado de '.$modulo)

@section('contenido')
@if (session('status'))
    <div class="mb-6 rounded-lg bg-emerald-50 p-4 text-sm text-emerald-800" role="status">
        {{ session('status') }}
    </div>
@endif
@if (session('error'))
    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800" role="alert">
        {{ session('error') }}
    </div>
@endif

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
                    @foreach ($campos as $nombre => $campo)
                        @if ($campo['tipo'] !== 'password')
                            <th class="px-5 py-3">{{ $campo['etiqueta'] }}</th>
                        @endif
                    @endforeach
                    <th class="px-5 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($registros as $registro)
                    <tr class="border-t border-slate-200 dark:border-slate-700">
                        <td class="px-5 py-4">{{ $registro['id'] }}</td>
                        @foreach ($campos as $nombre => $campo)
                            @if ($campo['tipo'] !== 'password')
                                <td class="px-5 py-4">
                                    @if ($campo['tipo'] === 'image' && !empty($registro[$nombre]))
                                        <img src="{{ $registro[$nombre] }}" alt="{{ $campo['etiqueta'] }} de {{ $registro['nombre'] ?? $registro['nombres'] ?? 'registro' }}" class="h-12 w-12 rounded object-cover">
                                    @elseif ($campo['tipo'] === 'image')
                                        —
                                    @elseif ($nombre === 'estado' && in_array($modulo, ['clientes', 'categorias', 'marcas', 'presentaciones', 'productos', 'roles'], true))
                                        {{ $registro[$nombre] ? 'Activo' : 'Inactivo' }}
                                    @else
                                        {{ $registro[$nombre] ?? '—' }}
                                    @endif
                                </td>
                            @endif
                        @endforeach
                        <td class="px-5 py-4">
                            <div class="flex flex-wrap gap-3">
                                <a class="text-cyan-700 hover:underline dark:text-cyan-300" href="{{ url($ruta.'/mostrar/'.$registro['id']) }}">Mostrar</a>
                                <a class="text-cyan-700 hover:underline dark:text-cyan-300" href="{{ url($ruta.'/editar/'.$registro['id']) }}">Editar</a>
                                <form action="{{ url($ruta.'/borrar/'.$registro['id']) }}" method="POST" onsubmit="return confirm('¿Eliminar este registro?')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $registro['id'] }}">
                                    <button type="submit" class="text-red-700 hover:underline dark:text-red-300">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="{{ collect($campos)->where('tipo', '!=', 'password')->count() + 2 }}" class="px-5 py-8 text-center text-slate-500">No hay registros para mostrar.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
