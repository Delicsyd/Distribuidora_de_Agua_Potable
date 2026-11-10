<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiAdminService;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    protected $api;

    public function __construct(ApiAdminService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        if (!session()->has('api_admin_token')) {
            return redirect()->route('admin.login');
        }

        $respuesta = $this->api->get('productos');

        if ($respuesta->unauthorized()) {
            session()->forget('api_admin_token');

            return redirect()->route('admin.login');
        }

        if ($respuesta->failed()) {
            return back()->with(
                'error',
                'No fue posible consultar los productos desde la API.'
            );
        }

        $productos = $respuesta->json('data', []);

        return view('admin.productos.index', compact('productos'));
    }

    public function create()
    {
        if (!session()->has('api_admin_token')) {
            return redirect()->route('admin.login');
        }

        $categorias = $this->api->get('categorias')->json('data', []);
        $presentaciones = $this->api->get('presentaciones')->json('data', []);
        $marcas = $this->api->get('marcas')->json('data', []);

        return view('admin.productos.create', compact(
            'categorias',
            'presentaciones',
            'marcas'
        ));
    }
public function edit($id)
{
    if (!session()->has('api_admin_token')) {
        return redirect()->route('admin.login');
    }

    $respuesta = $this->api->get('productos', $id);

    if ($respuesta->unauthorized()) {
        session()->forget('api_admin_token');
        return redirect()->route('admin.login');
    }

    if ($respuesta->failed()) {
        return redirect()
            ->route('admin.productos.index')
            ->with('error', 'No fue posible consultar el producto.');
    }

    $producto = $respuesta->json('data');

    $categorias = $this->api->get('categorias')->json('data', []);
    $presentaciones = $this->api->get('presentaciones')->json('data', []);
    $marcas = $this->api->get('marcas')->json('data', []);

    return view('admin.productos.edit', compact(
        'producto',
        'categorias',
        'presentaciones',
        'marcas'
    ));
}
    public function store(Request $request)
    {
        if (!session()->has('api_admin_token')) {
            return redirect()->route('admin.login');
        }

        $datos = $request->except('_token');

        $respuesta = $this->hasImageUploads($datos)
            ? $this->api->postConImagenes('productos', $datos)
            : $this->api->post('productos', $datos);

        if ($respuesta->unauthorized()) {
            session()->forget('api_admin_token');

            return redirect()->route('admin.login');
        }

        if ($respuesta->status() === 422) {
            return back()
                ->withErrors($respuesta->json('errors') ?? [])
                ->withInput();
        }

        if ($respuesta->failed()) {
            return back()
                ->with('error', 'No fue posible registrar el producto.')
                ->withInput();
        }

        return redirect()
            ->route('admin.productos.index')
            ->with('success', 'Producto registrado correctamente.');
    }
    public function update(Request $request, $id)
{
    if (!session()->has('api_admin_token')) {
        return redirect()->route('admin.login');
    }

    $datos = $request->except(['_token', '_method']);
    $respuesta = $this->hasImageUploads($datos)
        ? $this->api->putConImagenes('productos', $id, $datos)
        : $this->api->put('productos', $id, $datos);

    if ($respuesta->unauthorized()) {
        session()->forget('api_admin_token');
        return redirect()->route('admin.login');
    }

    if ($respuesta->status() === 422) {
        return back()
            ->withErrors($respuesta->json('errors') ?? [])
            ->withInput();
    }

    if ($respuesta->failed()) {
        return back()
            ->with('error', 'No fue posible actualizar el producto.')
            ->withInput();
    }

    return redirect()
        ->route('admin.productos.index')
        ->with('success', 'Producto actualizado correctamente.');
}
public function destroy($id)
{
    if (!session()->has('api_admin_token')) {
        return redirect()->route('admin.login');
    }

    $respuesta = $this->api->delete('productos', $id);

    if ($respuesta->unauthorized()) {
        session()->forget('api_admin_token');
        return redirect()->route('admin.login');
    }

    if ($respuesta->failed()) {
        return redirect()
            ->route('admin.productos.index')
            ->with('error', 'No fue posible eliminar el producto.');
    }

    return redirect()
        ->route('admin.productos.index')
        ->with('success', 'Producto eliminado correctamente.');
}

    private function hasImageUploads(array $datos): bool
    {
        return collect($datos)->contains(
            fn ($value) => $value instanceof UploadedFile
        );
    }
}
