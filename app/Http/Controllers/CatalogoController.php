<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class CatalogoController extends Controller
{
    public function index()
    {
        $respuesta = Http::get('http://127.0.0.1:8001/api/productos');

        $productos = $respuesta->json('data');

        $busquedas = [
            'Agua Clara 1L' => 'bottled drinking water product',
            'Agua Clara Garrafón' => '20 liter water jug',
            'Fuente Azul 1L' => 'blue bottled drinking water',
        ];

        foreach ($productos as &$producto) {

            $termino = $busquedas[$producto['nombre']] ?? 'drinking water bottle';

            $respuestaImagen = Http::withHeaders([
                'Authorization' => 'Client-ID ' . config('services.unsplash.access_key'),
            ])->get('https://api.unsplash.com/search/photos', [
                'query' => $termino,
                'per_page' => 1,
            ]);

            $producto['imagen_catalogo'] = data_get(
                $respuestaImagen->json(),
                'results.0.urls.regular'
            );
        }

        unset($producto);

        return view('catalogo.index', compact('productos'));
    }

   
public function detalle($id)
{
    $respuesta = Http::get('http://127.0.0.1:8001/api/productos/' . $id);

    $producto = $respuesta->json('data');

    if (!$producto) {
        abort(404);
    }

    $terminos = [
        'Agua Clara 1L' => 'bottled drinking water product',
        'Agua Clara Garrafón' => '20 liter water jug',
        'Fuente Azul 1L' => 'blue bottled drinking water',
    ];

    $termino = $terminos[$producto['nombre']] ?? 'drinking water bottle';

    $respuestaImagen = Http::withHeaders([
        'Authorization' => 'Client-ID ' . config('services.unsplash.access_key'),
    ])->get('https://api.unsplash.com/search/photos', [
        'query' => $termino,
        'per_page' => 1,
    ]);

    $producto['imagen_catalogo'] = data_get(
        $respuestaImagen->json(),
        'results.0.urls.regular'
    );

    return view('catalogo.detalle', compact('producto'));
}

}
