<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar producto</title>
</head>
<body>

    <h1>Editar producto</h1>

    <a href="{{ route('admin.productos.index') }}">Volver a productos</a>

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.productos.update', $producto['id']) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <label>Nombre:</label>
        <input type="text" name="nombre"
               value="{{ $producto['nombre'] }}" required>

        <br><br>

        <label>Descripción:</label>
        <textarea name="descripcion">{{ $producto['descripcion'] }}</textarea>

        <br><br>

        <label>Categoría:</label>
        <select name="categoria_id" required>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria['id'] }}"
                    {{ $producto['categoria_id'] == $categoria['id'] ? 'selected' : '' }}>
                    {{ $categoria['nombre'] }}
                </option>
            @endforeach
        </select>

        <br><br>

        <label>Presentación:</label>
        <select name="presentacion_id" required>
            @foreach ($presentaciones as $presentacion)
                <option value="{{ $presentacion['id'] }}"
                    {{ $producto['presentacion_id'] == $presentacion['id'] ? 'selected' : '' }}>
                    {{ $presentacion['nombre'] }}
                </option>
            @endforeach
        </select>

        <br><br>

        <label>Marca:</label>
        <select name="marca_id" required>
            @foreach ($marcas as $marca)
                <option value="{{ $marca['id'] }}"
                    {{ $producto['marca_id'] == $marca['id'] ? 'selected' : '' }}>
                    {{ $marca['nombre'] }}
                </option>
            @endforeach
        </select>

        <br><br>

        <label>Precio:</label>
        <input type="number" step="0.01" name="precio"
               value="{{ $producto['precio'] }}" required>

        <br><br>

        <label>Existencia:</label>
        <input type="number" name="existencia"
               value="{{ $producto['existencia'] }}">

        <br><br>

        <label>Descuento:</label>
        <input type="number" step="0.01" name="descuento"
               value="{{ $producto['descuento'] }}">

        <br><br>

        <label>Imagen principal:</label>
        <input type="file" name="imagen" accept="image/*">

        <br><br>

        <label>Imagen secundaria:</label>
        <input type="file" name="imagen_secundaria" accept="image/*">

        <br><br>

        <label>Imagen terciaria:</label>
        <input type="file" name="imagen_terciaria" accept="image/*">

        <br><br>

        <label>Estado:</label>
        <select name="estado">
            <option value="1" {{ $producto['estado'] ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ !$producto['estado'] ? 'selected' : '' }}>Inactivo</option>
        </select>

        <br><br>

        <button type="submit">Actualizar producto</button>

    </form>

</body>
</html>