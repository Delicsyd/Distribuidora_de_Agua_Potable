<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Administración</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 30px;
        }

        .contenedor {
            background: white;
            padding: 25px;
            border-radius: 10px;
            overflow-x: auto;
        }

        .boton {
            display: inline-block;
            background: #2563eb;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 15px;
        }

        .boton:hover {
            background: #1d4ed8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #1e293b;
            color: white;
        }

        img {
            width: 65px;
            height: 65px;
            object-fit: cover;
        }

        .error {
            color: #dc2626;
        }

        .exito {
            color: #16a34a;
        }

        a {
            color: #2563eb;
        }

        .acciones a {
            display: inline-block;
            background: #2563eb;
            color: white;
            padding: 7px 12px;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="contenedor">

        <h1>Administración de productos</h1>

        <a href="{{ route('admin.inicio') }}">Volver al panel</a>

        <br>

        <a class="boton" href="{{ route('admin.productos.create') }}">
            Registrar nuevo producto
        </a>

        @if (session('error'))
            <p class="error">{{ session('error') }}</p>
        @endif

        @if (session('success'))
            <p class="exito">{{ session('success') }}</p>
        @endif

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Existencia</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($productos as $producto)
                    <tr>
                        <td>{{ $producto['id'] ?? '' }}</td>

                        <td>
                            @if (!empty($producto['imagen']))
                                <img src="{{ $producto['imagen'] }}" alt="Producto">
                            @else
                                Sin imagen
                            @endif
                        </td>

                        <td>{{ $producto['nombre'] ?? '' }}</td>

                        <td>
                            ${{ number_format((float) ($producto['precio'] ?? 0), 2) }}
                        </td>

                        <td>{{ $producto['existencia'] ?? 0 }}</td>

                        <td>
                            {{ !empty($producto['estado']) ? 'Activo' : 'Inactivo' }}
                        </td>

                        <td class="acciones">
    <a href="{{ route('admin.productos.edit', $producto['id']) }}">
        Editar
    </a>

    <form action="{{ route('admin.productos.destroy', $producto['id']) }}"
          method="POST"
          style="display: inline;"
          onsubmit="return confirm('¿Estás seguro de eliminar este producto?')">

        @csrf
        @method('DELETE')

        <button type="submit"
                style="background: #dc2626; color: white; padding: 7px 12px; border: none; border-radius: 5px; cursor: pointer;">
            Eliminar
        </button>
    </form>
</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No hay productos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</body>
</html>
