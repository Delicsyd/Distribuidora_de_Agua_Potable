<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Distribuidora de Agua Potable')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-white">
    <header class="border-b border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
        <nav class="mx-auto flex max-w-7xl flex-wrap items-center gap-5 p-4">
            <a href="{{ url('/inicio') }}" class="font-bold text-cyan-700 dark:text-cyan-300">Distribuidora de Agua Potable</a>
            <a href="{{ url('/inicio') }}" class="text-sm hover:text-cyan-700">Inicio</a>
            <a href="{{ url('/admin/listar') }}" class="text-sm hover:text-cyan-700">Administradores</a>
            <a href="{{ url('/clientes/listar') }}" class="text-sm hover:text-cyan-700">Clientes</a>
            <a href="{{ url('/productos/listar') }}" class="text-sm hover:text-cyan-700">Productos</a>
        </nav>
    </header>

    <main class="mx-auto max-w-7xl p-4 pt-8 sm:p-6 lg:p-8">
        @yield('contenido')
    </main>

</body>
</html>
