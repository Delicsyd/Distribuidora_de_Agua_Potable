
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar producto</title>
</head>
<body>

    <h1>Registrar producto</h1>

    <a href="{{ route('admin.productos.index') }}">Volver a productos</a>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p style="color:red">{{ $error }}</p>
        @endforeach
    @endif

    @if (session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    <form action="{{ route('admin.productos.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <p>
            <label>Nombre:</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" required>
        </p>

        <p>
            <label>Descripción:</label>
            <textarea name="descripcion">{{ old('descripcion') }}</textarea>
        </p>

        <p>
            <label>Categoría:</label>
            <select name="categoria_id" required>
                <option value="">Seleccionar</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria['id'] }}">
                        {{ $categoria['nombre'] }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
            <label>Presentación:</label>
            <select name="presentacion_id" required>
                <option value="">Seleccionar</option>
                @foreach ($presentaciones as $presentacion)
                    <option value="{{ $presentacion['id'] }}">
                        {{ $presentacion['nombre'] }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
            <label>Marca:</label>
            <select name="marca_id" required>
                <option value="">Seleccionar</option>
                @foreach ($marcas as $marca)
                    <option value="{{ $marca['id'] }}">
                        {{ $marca['nombre'] }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
            <label>Precio:</label>
            <input type="number" name="precio" step="0.01" min="0" required>
        </p>

        <p>
            <label>Existencia:</label>
            <input type="number" name="existencia" min="0" value="0">
        </p>

        <p>
            <label>Descuento:</label>
            <input type="number" name="descuento" step="0.01" min="0" value="0">
        </p>

        <p>
            <label>Imagen principal:</label>
            <input type="file" name="imagen" accept="image/*">
        </p>

        <p>
            <label>Imagen secundaria:</label>
            <input type="file" name="imagen_secundaria" accept="image/*">
        </p>

        <p>
            <label>Imagen terciaria:</label>
            <input type="file" name="imagen_terciaria" accept="image/*">
        </p>

        <p>
            <label>Estado:</label>
            <select name="estado">
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select>
        </p>

        <button type="submit">Guardar producto</button>

    </form>

</body>
</html>
