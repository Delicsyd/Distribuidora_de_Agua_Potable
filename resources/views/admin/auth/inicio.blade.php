<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración - Distribuidora</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            background: #f1f5f9;
        }

        header {
            background: #1e293b;
            color: white;
            padding: 20px 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        main {
            padding: 35px;
        }

        .modulos {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 20px;
        }

        .modulo {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .modulo h3 {
            color: #1e293b;
            margin-top: 0;
        }

        .modulo p {
            color: #64748b;
        }

        button {
            background: #dc2626;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <header>
        <h2>Distribuidora de Agua Potable</h2>

        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit">Cerrar sesión</button>
        </form>
    </header>

    <main>
        <h1>Panel administrativo</h1>
        <p>Bienvenido al sistema de administración.</p>

        <div class="modulos">
            <div class="modulo">
                <h3>Administradores</h3>
                <p>Gestión de administradores del sistema.</p>
            </div>

            <div class="modulo">
                <h3>Productos</h3>
                <p>Gestión del catálogo de productos.</p>
            </div>

            <div class="modulo">
                <h3>Categorías</h3>
                <p>Administración de categorías.</p>
            </div>

            <div class="modulo">
                <h3>Proveedores</h3>
                <p>Gestión de proveedores.</p>
            </div>

            <div class="modulo">
                <h3>Clientes</h3>
                <p>Consulta de clientes registrados.</p>
            </div>

            <div class="modulo">
                <h3>Pedidos</h3>
                <p>Consulta de pedidos realizados.</p>
            </div>
        </div>
    </main>

</body>
</html>
