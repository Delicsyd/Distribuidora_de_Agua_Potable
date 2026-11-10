@extends('plantilla.layout')

@section('titulo', 'Edición de '.$modulo)

@section('contenido')
<div class="mx-auto max-w-5xl">
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-900 sm:p-8">
        <div class="mb-8">
            <p class="text-sm font-semibold uppercase tracking-widest text-cyan-600">{{ $modelo }} · ID {{ $registro['id'] }}</p>
            <h1 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">Editar {{ $modulo }}</h1>
        </div>

        @if (!empty($opcionesFaltantes))
            <div class="mb-6 rounded-lg border border-amber-300 bg-amber-50 p-4 text-sm text-amber-800" role="alert">
                Registra primero estas opciones relacionadas para continuar: {{ implode(', ', $opcionesFaltantes) }}.
            </div>
        @endif

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
        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800" role="alert">
                <p class="mb-2 font-semibold">Revisa los siguientes errores:</p>
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('uploadedImages'))
            <div class="mb-6 space-y-3 rounded-lg border border-emerald-200 bg-emerald-50 p-4">
                <p class="font-semibold text-emerald-900">Imágenes guardadas en Cloudinary:</p>
                @foreach (session('uploadedImages') as $campo => $url)
                    <div class="flex flex-wrap items-center gap-3 text-sm">
                        <span>{{ $campos[$campo]['etiqueta'] ?? $campo }}</span>
                        <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="text-cyan-700 underline">Abrir imagen</a>
                        <img src="{{ $url }}" alt="{{ $campos[$campo]['etiqueta'] ?? $campo }}" class="h-16 w-16 rounded object-cover">
                    </div>
                @endforeach
            </div>
        @endif

        <form action="{{ url($ruta.'/actualizar/'.$registro['id']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $registro['id'] }}">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                @foreach ($campos as $nombre => $campo)
                    <div class="{{ $campo['tipo'] === 'textarea' ? 'sm:col-span-2' : '' }}">
                        <label for="{{ $nombre }}" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">{{ $campo['etiqueta'] }}</label>
                        @if ($campo['tipo'] === 'textarea')
                            <textarea id="{{ $nombre }}" name="{{ $nombre }}" rows="3" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old($nombre, $registro[$nombre] ?? '') }}</textarea>
                        @elseif ($campo['tipo'] === 'select')
                            <select id="{{ $nombre }}" name="{{ $nombre }}" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                @foreach ($campo['opciones'] as $valor => $etiqueta)
                                    <option value="{{ $valor }}" @selected((string) old($nombre, $registro[$nombre] ?? '') === (string) $valor)>{{ $etiqueta }}</option>
                                @endforeach
                            </select>
                        @elseif ($campo['tipo'] === 'image')
                            <div data-image-field>
                                <input type="file" id="{{ $nombre }}" name="{{ $nombre }}" accept="image/*" data-image-input class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Selecciona una imagen desde tu dispositivo.</p>
                                @if (!empty($registro[$nombre]))
                                    <img src="{{ $registro[$nombre] }}" alt="{{ $campo['etiqueta'] }} actual" class="mt-3 h-20 w-20 rounded-lg object-cover">
                                @endif
                                <img data-image-preview alt="Vista previa de {{ strtolower($campo['etiqueta']) }}" class="mt-3 hidden max-h-48 rounded-lg object-contain">
                            </div>
                        @else
                            <input type="{{ $campo['tipo'] }}" id="{{ $nombre }}" name="{{ $nombre }}" value="{{ $campo['tipo'] === 'password' ? '' : old($nombre, $registro[$nombre] ?? '') }}" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        @endif
                        @error($nombre)
                            <p class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
            </div>
            <div class="mt-8 flex flex-wrap gap-3 border-t border-slate-200 pt-6 dark:border-slate-700">
                <button type="submit" @disabled(!empty($opcionesFaltantes)) class="rounded-lg bg-cyan-500 px-5 py-2.5 text-sm font-semibold text-slate-950 hover:bg-cyan-400 disabled:cursor-not-allowed disabled:opacity-50">Actualizar</button>
                <a href="{{ url($ruta.'/listar') }}" class="rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-800">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
