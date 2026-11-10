<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de {{ $label }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f7fb;
        }
        .panel {
            max-width: 900px;
            margin: 30px auto;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
            padding: 28px;
        }
        .detail-item {
            border-bottom: 1px solid #eef2f7;
            padding: 12px 0;
        }
        .label {
            font-weight: 700;
            color: #334155;
        }
    </style>
</head>
<body>
    <div class="panel">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h1 class="mb-1">Detalle de {{ $label }}</h1>
                <p class="text-muted mb-0">Información del registro seleccionado.</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route("admin.{$resource}.index") }}" class="btn btn-outline-secondary">Volver</a>
                <a href="{{ route("admin.{$resource}.edit", data_get($record, 'id')) }}" class="btn btn-primary">Editar</a>
            </div>
        </div>

        @foreach ($fields as $field => $config)
            @php $valor = data_get($record, $field); @endphp
            <div class="detail-item">
                <div class="label">{{ $config['label'] }}</div>
                <div>
                    @if ($config['type'] ?? 'text' === 'file')
                        @if (!empty($valor))
                            <img src="{{ $valor }}" alt="Imagen" style="max-width: 180px; border-radius: 12px; margin-top: 8px;">
                        @else
                            <span class="text-muted">Sin imagen</span>
                        @endif
                    @elseif ($field === 'estado')
                        {{ (bool) $valor ? 'Activo' : 'Inactivo' }}
                    @else
                        {{ $valor ?? 'No aplica' }}
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>
