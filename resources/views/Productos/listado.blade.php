@extends('plantilla.layout')

@section('titulo', 'Listado de productos')
@section('contenido')
@if (session('status'))
    <div class="mb-6 rounded-lg bg-emerald-50 p-4 text-sm text-emerald-800" role="status">{{ session('status') }}</div>
@endif
@if (session('error'))
    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800" role="alert">{{ session('error') }}</div>
@endif
<section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
    <div class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between dark:border-slate-700">
        <div><p class="text-sm font-semibold uppercase tracking-widest text-cyan-600">Productos</p><h1 class="mt-2 text-2xl font-bold">Listado de productos</h1><p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Consulta el catálogo y el inventario disponible.</p></div>
        <a href="{{ route('productos.formulario') }}" class="rounded-lg bg-cyan-500 px-4 py-2.5 text-sm font-semibold text-slate-950 hover:bg-cyan-400">Nuevo producto</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full min-w-max text-left text-sm">
            <thead class="bg-slate-100 text-xs uppercase text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                <tr><th class="px-6 py-3">ID</th><th class="px-6 py-3">Nombre</th><th class="px-6 py-3">Descripción</th><th class="px-6 py-3">Categoría</th><th class="px-6 py-3">Presentación</th><th class="px-6 py-3">Marca</th><th class="px-6 py-3">Precio</th><th class="px-6 py-3">Existencia</th><th class="px-6 py-3">Descuento</th><th class="px-6 py-3">Imagen</th><th class="px-6 py-3">Imagen secundaria</th><th class="px-6 py-3">Imagen terciaria</th><th class="px-6 py-3">Estado</th><th class="px-6 py-3">Acciones</th></tr>
            </thead>

<tbody>
    @forelse ($registros as $producto)
        <tr class="border-t border-slate-200 dark:border-slate-700">
            <td class="px-6 py-4">{{ $producto->id }}</td>
            <td class="px-6 py-4">{{ $producto->nombre }}</td>
            <td class="px-6 py-4">{{ $producto->descripcion ?? '—' }}</td>

            <td class="px-6 py-4">
                {{ $producto->categoria?->nombre ?? 'Sin categoría' }}
            </td>

            <td class="px-6 py-4">
                {{ $producto->presentacion?->nombre ?? 'Sin presentación' }}
            </td>

            <td class="px-6 py-4">
                {{ $producto->marca?->nombre ?? 'Sin marca' }}
            </td>

            <td class="px-6 py-4">
                ${{ number_format($producto->precio, 2) }}
            </td>

            <td class="px-6 py-4">{{ $producto->existencia }}</td>
            <td class="px-6 py-4">{{ $producto->descuento }}%</td>

            @foreach ([
                $producto->imagen,
                $producto->imagen_secundaria,
                $producto->imagen_terciaria
            ] as $imagen)
                <td class="px-6 py-4">
                    @if ($imagen)
                        @php
                            $src = str_starts_with($imagen, 'http')
                                ? $imagen
                                : asset(ltrim($imagen, '/'));
                        @endphp

                        <img
                            src="{{ $src }}"
                            alt="Imagen del producto {{ $producto->id }}"
                            class="h-16 w-16 rounded-lg object-cover"
                        >
                    @else
                        —
                    @endif
                </td>
            @endforeach

            <td class="px-6 py-4">
                {{ $producto->estado == 1 ? 'Activo' : 'Inactivo' }}
            </td>
            <td class="px-6 py-4">
                <div class="flex flex-wrap gap-3">
                    <a class="text-cyan-700 hover:underline dark:text-cyan-300" href="{{ route('productos.mostrar', ['id' => $producto->id]) }}">Mostrar</a>
                    <a class="text-cyan-700 hover:underline dark:text-cyan-300" href="{{ route('productos.editar', ['id' => $producto->id]) }}">Editar</a>
                    <form action="{{ route('productos.borrar', ['id' => $producto->id]) }}" method="POST" onsubmit="return confirm('¿Eliminar este producto?')">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" value="{{ $producto->id }}">
                        <button type="submit" class="text-red-700 hover:underline dark:text-red-300">Eliminar</button>
                    </form>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="14" class="px-6 py-10 text-center">
                No hay productos registrados en la base de datos.
            </td>
        </tr>
    @endforelse
</tbody>

        </table>
    </div>
</section>
@endsection
