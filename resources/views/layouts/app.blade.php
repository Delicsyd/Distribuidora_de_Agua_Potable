@extends('plantilla.layout')

@section('titulo', 'Módulos de la aplicación')

@section('contenido')
@php
    $modulos = [
        ['Administradores', '/admin/listar'],
        ['Categorías', '/categorias/listar'],
        ['Clientes', '/clientes/listar'],
        ['Direcciones', '/direcciones/listar'],
        ['Entregas', '/entregas/listar'],
        ['Marcas', '/marcas/listar'],
        ['Métodos de pago', '/metodos-pago/listar'],
        ['Pedidos', '/pedidos/listar'],
        ['Presentaciones', '/presentaciones/listar'],
        ['Productos', '/productos/listar'],
        ['Productos de pedidos', '/productos-pedido/listar'],
        ['Repartidores', '/repartidores/listar'],
        ['Roles', '/roles/listar'],
        ['Usuarios', '/usuarios/listar'],
    ];
@endphp

<div class="space-y-8">
    <div>
        <p class="text-sm font-semibold uppercase tracking-widest text-cyan-600">Demostración MVC</p>
        <h1 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">Módulos de la aplicación</h1>
        <p class="mt-2 text-slate-500 dark:text-slate-400">Selecciona un módulo para comprobar sus rutas, controlador y vistas. La información es temporal; no se conecta a la base de datos.</p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($modulos as [$nombre, $url])
            <a href="{{ url($url) }}" class="rounded-xl border border-slate-200 bg-white p-5 font-semibold shadow-sm transition hover:border-cyan-400 hover:text-cyan-700 dark:border-slate-700 dark:bg-slate-900 dark:hover:text-cyan-300">
                {{ $nombre }} <span aria-hidden="true">→</span>
            </a>
        @endforeach
    </div>
</div>
@endsection
