<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Clima actual</h1>

    <p>Ubicación: {{ $ubicacion['city'] ?? 'Desconocida' }},
        {{ $ubicacion['country'] ?? '' }}</p>

    <p>Hora del pronóstico: {{ $hora }}</p>
    <p>Temperatura: {{ $temperatura }} °C</p>
    <p>Humedad: {{ $humedad }} %</p>
    <p>Probabilidad de lluvia: {{ $probabilidadLluvia }} %</p>
</body>
</html>