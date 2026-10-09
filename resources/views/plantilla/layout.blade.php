<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Área administrativa') | Distribuidora de Agua Potable</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-white">
    <header class="border-b border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
        <nav class="mx-auto flex max-w-7xl flex-wrap items-center justify-between p-4">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-cyan-500 text-xl font-bold text-slate-950">A</span>
                <span class="text-xl font-semibold">Distribuidora de Agua Potable</span>
            </a>
            <button data-collapse-toggle="admin-navbar" type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 md:hidden" aria-controls="admin-navbar" aria-expanded="false">
                <span class="sr-only">Abrir menú</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <div id="admin-navbar" class="hidden w-full md:block md:w-auto">
                <ul class="mt-4 flex flex-col gap-2 font-medium md:mt-0 md:flex-row md:items-center md:gap-6">
                    <li><a href="{{ url('/') }}" class="hover:text-cyan-700">Inicio</a></li>
                    <li><a href="{{ url('/inicio') }}" class="hover:text-cyan-700">Administrador</a></li>
                    <li class="flex gap-2"><a href="{{ url('/admin/crear') }}" class="hover:text-cyan-700">Admin formulario</a><a href="{{ url('/admin/listar') }}" class="text-slate-500 hover:text-cyan-700">listado</a></li>
                    <li class="flex gap-2"><a href="{{ url('/clientes') }}" class="hover:text-cyan-700">Clientes formulario</a><a href="{{ url('/clientes') }}" class="text-slate-500 hover:text-cyan-700">listado</a></li>
                    <li class="flex gap-2"><a href="{{ url('/productos') }}" class="hover:text-cyan-700">Productos formulario</a><a href="{{ url('/productos') }}" class="text-slate-500 hover:text-cyan-700">listado</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main class="mx-auto max-w-7xl p-4 pt-8 sm:p-6 lg:p-8">
        @yield('contenido')
    </main>

    <footer class="mt-8 border-t border-slate-200 bg-white p-6 text-center text-sm text-slate-500 dark:border-slate-800 dark:bg-slate-900">
        Área administrativa · Distribuidora de Agua Potable
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
</body>
</html>
