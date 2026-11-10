
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $producto['nombre'] }} - Distribuidora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container py-5">

        <a href="{{ route('catalogo.index') }}" class="btn btn-secondary mb-4">
            Volver al catálogo
        </a>

        <div class="card shadow">
            <div class="row g-0">

                <div class="col-md-6">
                    <img
                        src="{{ $producto['imagen_catalogo'] ?? 'https://placehold.co/600x400?text=Agua+Potable' }}"
                        class="img-fluid rounded-start w-100"
                        alt="{{ $producto['nombre'] }}"
                        style="height: 400px; object-fit: cover;">
                </div>

                <div class="col-md-6">
                    <div class="card-body p-4">

                        <h2>{{ $producto['nombre'] }}</h2>

                        <p class="text-muted">
                            {{ $producto['descripcion'] }}
                        </p>

                        <h3 class="text-primary">
                            ${{ $producto['precio'] }}
                        </h3>

                        <p>
                            <strong>Existencia:</strong>
                            {{ $producto['existencia'] }} unidades
                        </p>

                        <p>
                            <strong>Descuento:</strong>
                            {{ $producto['descuento'] }}%
                        </p>

                        <p>
                            <strong>Estado:</strong>
                            {{ $producto['estado'] ? 'Disponible' : 'No disponible' }}
                        </p>

                    </div>
                </div>

            </div>
        </div>

    </div>

</body>
</html>
