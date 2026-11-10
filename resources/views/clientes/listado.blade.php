
@extends('plantilla.layout')

@section('titulo', 'Listado de clientes')

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
<section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
    <div class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between dark:border-slate-700">
        <div>
            <p class="text-sm font-semibold uppercase tracking-widest text-cyan-600">Clientes</p>
            <h1 class="mt-2 text-2xl font-bold">Listado de clientes</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Consulta los clientes registrados en la distribuidora.</p>
        </div>
        <a href="{{ route('clientes.formulario') }}" class="rounded-lg bg-cyan-500 px-4 py-2.5 text-sm font-semibold text-slate-950 hover:bg-cyan-400">Nuevo cliente</a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-xs uppercase text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Nombres</th>
                    <th class="px-6 py-3">Correo</th>
                    <th class="px-6 py-3">Teléfono</th>
                    <th class="px-6 py-3">Imagen</th>
                    <th class="px-6 py-3">Estado</th>
                    <th class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($registros as $cliente)
                    <tr class="border-t border-slate-200 dark:border-slate-700">
                        <td class="px-6 py-4">{{ $cliente->id }}</td>
                        <td class="px-6 py-4">{{ $cliente->nombres }} {{ $cliente->apellidos }}</td>
                        <td class="px-6 py-4">{{ $cliente->correo }}</td>
                        <td class="px-6 py-4">{{ $cliente->telefono }}</td>
                        <td class="px-6 py-4">
                            @if ($cliente->imagen)
                                <img src="{{ $cliente->imagen }}" alt="Foto de {{ $cliente->nombres }}" class="h-12 w-12 rounded-full object-cover">
                            @else
                                Sin imagen
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            {{ $cliente->estado ? 'Activo' : 'Inactivo' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-3">
                                <a class="text-cyan-700 hover:underline dark:text-cyan-300" href="{{ route('clientes.mostrar', ['id' => $cliente->id]) }}">Mostrar</a>
                                <a class="text-cyan-700 hover:underline dark:text-cyan-300" href="{{ route('clientes.editar', ['id' => $cliente->id]) }}">Editar</a>
                                <form action="{{ route('clientes.borrar', ['id' => $cliente->id]) }}" method="POST" onsubmit="return confirm('¿Eliminar este cliente?')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $cliente->id }}">
                                    <button type="submit" class="text-red-700 hover:underline dark:text-red-300">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="border-t border-slate-200 dark:border-slate-700">
                        <td colspan="7" class="px-6 py-10 text-center text-slate-500 dark:text-slate-400">
                            No hay clientes registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
