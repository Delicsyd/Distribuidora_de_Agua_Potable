<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel administrativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #eff6ff 0%, #e2e8f0 100%);
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .shell {
            max-width: 1200px;
            margin: 40px auto;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
            padding: 28px;
        }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 18px;
            margin-bottom: 28px;
        }
        .card {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            height: 100%;
        }
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.08);
        }
        .card-body {
            padding: 1.25rem;
        }
        .card-title {
            font-size: 1.05rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .card a {
            text-decoration: none;
            color: #0f172a;
        }
    </style>
</head>
<body>
    <div class="shell">
        <div class="topbar">
            <div>
                <h1 class="mb-1">Panel administrativo</h1>
                <p class="text-muted mb-0">Distribuidora de Agua Potable</p>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger">Cerrar sesión</button>
            </form>
        </div>

        <div class="row g-4">
            @php
                $modulos = [
                    ['label' => 'Roles', 'route' => 'admin.roles.index'],
                    ['label' => 'Administradores', 'route' => 'admin.administradores.index'],
                    ['label' => 'Categorías', 'route' => 'admin.categorias.index'],
                    ['label' => 'Presentaciones', 'route' => 'admin.presentaciones.index'],
                    ['label' => 'Marcas', 'route' => 'admin.marcas.index'],
                    ['label' => 'Direcciones', 'route' => 'admin.direcciones.index'],
                    ['label' => 'Métodos de pago', 'route' => 'admin.metodos-pago.index'],
                    ['label' => 'Productos de pedido', 'route' => 'admin.productos-pedido.index'],
                    ['label' => 'Repartidores', 'route' => 'admin.repartidores.index'],
                    ['label' => 'Entregas', 'route' => 'admin.entregas.index'],
                    ['label' => 'Usuarios', 'route' => 'admin.usuarios.index'],
                    ['label' => 'Proveedores', 'route' => 'admin.proveedores.index'],
                    ['label' => 'Productos', 'route' => 'admin.productos.index'],
                ];
            @endphp

            @foreach ($modulos as $modulo)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <a href="{{ route($modulo['route']) }}">
                                <div class="card-title">{{ $modulo['label'] }}</div>
                                <p class="text-muted mb-0">Gestionar registros</p>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
