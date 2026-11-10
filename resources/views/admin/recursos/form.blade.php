<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mode === 'create' ? 'Registrar' : 'Editar' }} {{ $label }}</title>
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
        .form-label {
            font-weight: 600;
        }
        .mb-3 {
            margin-bottom: 1rem;
        }
        .alert {
            margin-bottom: 1.2rem;
        }
    </style>
</head>
<body>
    <div class="panel">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h1 class="mb-1">{{ $mode === 'create' ? 'Registrar' : 'Editar' }} {{ $label }}</h1>
                <p class="text-muted mb-0">Complete la información requerida.</p>
            </div>
            <a href="{{ route("admin.{$resource}.index") }}" class="btn btn-outline-secondary">Volver</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ $mode === 'create' ? route("admin.{$resource}.store") : route("admin.{$resource}.update", data_get($record, 'id')) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($mode === 'edit')
                @method('PUT')
            @endif

            <div class="row g-3">
                @foreach ($fields as $field => $config)
                    @php
                        $value = old($field, data_get($record, $field));
                        $required = !empty($config['required']) ? 'required' : '';
                        $fieldType = $config['type'] ?? 'text';
                    @endphp

                    @if ($fieldType === 'select')
                        @php
                            $options = $config['options'] ?? [];
                            if (isset($config['relationship'])) {
                                $options = $related[$config['relationship']] ?? [];
                            }
                        @endphp
                        <div class="col-md-6">
                            <label class="form-label" for="{{ $field }}">{{ $config['label'] }}</label>
                            <select class="form-select" id="{{ $field }}" name="{{ $field }}" {{ $required }}>
                                <option value="">Seleccionar</option>
                                @foreach ($options as $optionKey => $optionValue)
                                    @php
                                        $optionLabel = is_array($optionValue) ? (data_get($optionValue, 'nombre') ?? data_get($optionValue, 'name') ?? data_get($optionValue, 'nombres') ?? $optionKey) : $optionValue;
                                        $optionId = is_array($optionValue) ? data_get($optionValue, 'id') : $optionKey;
                                    @endphp
                                    <option value="{{ $optionId }}" {{ (string) old($field, data_get($record, $field)) === (string) $optionId ? 'selected' : '' }}>
                                        {{ $optionLabel }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @elseif ($fieldType === 'textarea')
                        <div class="col-md-6">
                            <label class="form-label" for="{{ $field }}">{{ $config['label'] }}</label>
                            <textarea class="form-control" id="{{ $field }}" name="{{ $field }}" rows="4" {{ $required }}>{{ old($field, data_get($record, $field) ?? '') }}</textarea>
                        </div>
                    @elseif ($fieldType === 'file')
                        <div class="col-md-6">
                            <label class="form-label" for="{{ $field }}">{{ $config['label'] }}</label>
                            <input type="file" class="form-control" id="{{ $field }}" name="{{ $field }}" accept="image/*" {{ $required }}>
                        </div>
                   @elseif ($fieldType === 'password')
                       @php
                           $isAdminPassword = $resource === 'administradores' && $field === 'contraseña';
                           $passwordLabel = $isAdminPassword && $mode === 'edit' ? 'Nueva contraseña' : $config['label'];
                           $passwordRequired = $isAdminPassword && $mode === 'create' ? 'required' : $required;
                       @endphp
                       <div class="col-md-6">
                           <label class="form-label" for="{{ $field }}">{{ $passwordLabel }}</label>
                           <input
                               type="password"
                               class="form-control"
                               id="{{ $field }}"
                               name="{{ $field }}"
                               autocomplete="new-password"
                               {{ $passwordRequired }}
                           >
                           @if ($isAdminPassword && $mode === 'edit')
                               <div class="form-text">Deje este campo vacío para conservar la contraseña actual.</div>
                           @endif
                       </div>

                       @if ($isAdminPassword && in_array($mode, ['create', 'edit'], true))
                           <div class="col-md-6">
                               <label class="form-label" for="contraseña_confirmation">
                                   Confirmar {{ $mode === 'edit' ? 'nueva ' : '' }}contraseña
                               </label>
                               <input
                                   type="password"
                                   class="form-control"
                                   id="contraseña_confirmation"
                                   name="contraseña_confirmation"
                                   autocomplete="new-password"
                                   {{ $mode === 'create' ? 'required' : '' }}
                               >
                           </div>
                       @endif
                    @else
                        <div class="col-md-6">
                            <label class="form-label" for="{{ $field }}">{{ $config['label'] }}</label>
                            <input type="{{ $fieldType }}" class="form-control" id="{{ $field }}" name="{{ $field }}" value="{{ old($field, data_get($record, $field) ?? '') }}" {{ $required }}>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="mt-4 d-flex gap-2 flex-wrap">
                <button type="submit" class="btn btn-primary">{{ $mode === 'create' ? 'Guardar' : 'Actualizar' }}</button>
                <a href="{{ route("admin.{$resource}.index") }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
