<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <ul>  
        <li>IP:{{ $ubicacion['query'] }}</li>
        <li>Pais:{{ $ubicacion['country'] }}</li>
        <li>Region:{{ $ubicacion['regionName'] }}</li>
        <li>Ciudad:{{ $ubicacion['city'] }}</li>
        <li>Codigo Postal:{{ $ubicacion['zip'] }}</li>
        <li>Coordenadas:{{ $ubicacion['lat'] }}, {{ $ubicacion['lon'] }}</li>

      </ul>
</body>
</html>