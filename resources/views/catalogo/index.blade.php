
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo | Distribuidora de Agua</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f2f7fa;
            font-family: Arial, sans-serif;
        }

        .encabezado {
            background: #087cae;
            color: white;
            padding: 35px;
            text-align: center;
        }

        .producto {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s;
        }

        .producto:hover {
            transform: translateY(-5px);
        }

        .producto img {
            height: 220px;
            object-fit: contain;
            padding: 20px;
            background: white;
        }

        .precio {
            color: #087cae;
            font-size: 23px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <header class="encabezado">
        <h1>Distribuidora de Agua Potable</h1>
        <p>Conoce nuestros productos y presentaciones</p>
    </header>

    <div class="container py-5">

        <h2 class="text-center mb-4">Nuestro catálogo</h2>

        <div class="row g-4">

            @foreach($productos as $producto)

                @if($producto['estado'])

                    <div class="col-md-4">

                        <div class="card producto shadow-sm h-100">

                           <img src="{{ $producto['imagen_catalogo'] ?? 'https://placehold.co/400x300/eaf6fc/087cae?text=Agua+Potable' }}"
     class="card-img-top"
     alt="{{ $producto['nombre'] }}"
     style="height: 220px; object-fit: cover;">

                            <div class="card-body text-center">

                                <h5 class="card-title">
                                    {{ $producto['nombre'] }}
                                </h5>

                                <p class="card-text">
                                    {{ $producto['descripcion'] }}
                                </p>

                                <p class="precio">
                                    ${{ number_format((float)$producto['precio'], 2) }}
                                </p>

                                <a href="{{ route('catalogo.detalle', $producto['id']) }}"
                                   class="btn btn-primary">
                                    Ver detalles
                                </a>

                            </div>

                        </div>

                    </div>

                @endif

            @endforeach

        </div>

    </div>

</body>
</html>
