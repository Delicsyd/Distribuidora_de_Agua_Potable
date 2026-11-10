<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $label }} - Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f7fb;
        }
        .panel {
            max-width: 1200px;
            margin: 30px auto;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
            padding: 28px;
        }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .btn-primary {
            background: #2563eb;
            border: none;
        }
        .btn-primary:hover {
            background: #1d4ed8;
        }
        .btn-danger {
            background: #dc2626;
            border: none;
        }
        .btn-danger:hover {
            background: #b91c1c;
        }
        .table-responsive {
            overflow-x: auto;
        }
        .badge-success {
            background: #198754;
            color: #fff;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 0.75rem;
        }
        .badge-secondary {
            background: #6c757d;
            color: #fff;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 0.75rem;
        }
        .alert {
            margin: 16px 0;
        }
        td img {
            width: 52px;
            height: 52px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="panel">
        <div class="topbar">
            <div>
                <h1 class="mb-1">{{ $label }}</h1>
                <p class="text-muted mb-0">Gestión administrativa</p>
            </div>
            <div class="d-flex gap-2 align-items-center flex-wrap">
                <a href="{{ route('admin.inicio') }}" class="btn btn-outline-secondary">Volver al panel</a>
                <a href="{{ route("admin.{$resource}.create") }}" class="btn btn-primary">Registrar</a>
            </div>
        </div>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        @foreach ($fields as $field)
                            <th>{{ ucfirst(str_replace(['_', '-'], ' ', $field)) }}</th>
                        @endforeach
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($records as $record)
                        <tr>
                            <td>{{ data_get($record, 'id') ?? '-' }}</td>
                            @foreach ($fields as $field)
                                <td>
                                    @php $valor = data_get($record, $field); @endphp
                                    @if ($field === 'estado')
                                        @if ((bool) $valor)
                                            <span class="badge-success">Activo</span>
                                        @else
                                            <span class="badge-secondary">Inactivo</span>
                                        @endif
                                    @elseif (str_contains((string) $field, 'imagen'))
                                        @if (!empty($valor))
                                            <img src="{{ $valor }}" alt="Imagen">
                                        @else
                                            <span class="text-muted">Sin imagen</span>
                                        @endif
                                    @elseif ($field === 'precio' || $field === 'total' || $field === 'monto')
                                        ${{ number_format((float) $valor, 2) }}
                                    @elseif (is_bool($valor))
                                        {{ $valor ? 'Sí' : 'No' }}
                                    @else
                                        {{ $valor ?? '-' }}
                                    @endif
                                </td>
                            @endforeach
                            <td>
                                <div class="d-flex gap-2 flex-wrap">
                                    <a href="{{ route("admin.{$resource}.show", data_get($record, 'id')) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                                    <a href="{{ route("admin.{$resource}.edit", data_get($record, 'id')) }}" class="btn btn-sm btn-primary">Editar</a>
                                    <form action="{{ route("admin.{$resource}.destroy", data_get($record, 'id')) }}" method="POST" onsubmit="return confirm('¿Deseas eliminar este registro?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($fields) + 2 }}" class="text-center text-muted py-4">No hay registros disponibles.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
