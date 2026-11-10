<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends DemoCrudController
{
    protected string $modulo = 'productos';

    protected string $ruta = '/productos';

    protected string $vista = 'Productos';

    protected string $modelo = Producto::class;

    protected array $campos = [
        'nombre' => ['etiqueta' => 'Nombre', 'tipo' => 'text', 'obligatorio' => true],
        'descripcion' => ['etiqueta' => 'Descripción', 'tipo' => 'textarea'],
        'categoria_id' => ['etiqueta' => 'Categoría', 'tipo' => 'select', 'obligatorio' => true],
        'presentacion_id' => ['etiqueta' => 'Presentación', 'tipo' => 'select', 'obligatorio' => true],
        'marca_id' => ['etiqueta' => 'Marca', 'tipo' => 'select', 'obligatorio' => true],
        'precio' => ['etiqueta' => 'Precio', 'tipo' => 'number', 'obligatorio' => true],
        'existencia' => ['etiqueta' => 'Existencia', 'tipo' => 'number'],
        'descuento' => ['etiqueta' => 'Descuento', 'tipo' => 'number'],
        'imagen' => ['etiqueta' => 'Fotografía principal', 'tipo' => 'image'],
        'imagen_secundaria' => ['etiqueta' => 'Fotografía secundaria', 'tipo' => 'image'],
        'imagen_terciaria' => ['etiqueta' => 'Fotografía adicional', 'tipo' => 'image'],
        'estado' => ['etiqueta' => 'Estado', 'tipo' => 'select'],
    ];

    public function listar()
    {
        return $this->ver('listado', [
            'registros' => Producto::query()
                ->with(['categoria', 'presentacion', 'marca'])
                ->orderBy('id')
                ->get(),
        ]);
    }

    public function vistaFormulario()
    {
        return $this->ver('registro');
    }

    public function registrar(Request $request)
    {
        $datos = $this->validar($request, $this->reglasValidacion(), $this->mensajesValidacion());
        $datos['estado'] = $this->normalizarEstado($datos['estado'] ?? null);
        $datos['existencia'] ??= 0;
        $datos['descuento'] ??= 0;
        $datos = array_merge(
            $datos,
            $this->subirImagenes($request, ['imagen', 'imagen_secundaria', 'imagen_terciaria'])
        );

        Producto::create($datos);

        return redirect()->route('productos.listar')
            ->with('status', 'Producto registrado correctamente.');
    }

    public function vistaEdicion(Request $request)
    {
        $registro = Producto::with(['categoria', 'presentacion', 'marca'])->findOrFail(
            $this->validar($request, [
                'id' => ['required', 'integer', 'exists:productos,id'],
            ])['id']
        );

        return $this->ver('edicion', ['registro' => $registro]);
    }

    public function actualizar(Request $request)
    {
        $producto = Producto::findOrFail($this->validar($request, [
            'id' => ['required', 'integer', 'exists:productos,id'],
        ])['id']);
        $datos = $this->validar($request, $this->reglasValidacion(true), $this->mensajesValidacion());

        foreach (['descripcion', 'existencia', 'descuento'] as $campo) {
            if (($datos[$campo] ?? null) === null) {
                unset($datos[$campo]);
            }
        }

        if (array_key_exists('estado', $datos)) {
            $datos['estado'] = $this->normalizarEstado($datos['estado']);
        }

        $producto->update($this->actualizarImagenes(
            $request,
            $datos,
            ['imagen', 'imagen_secundaria', 'imagen_terciaria']
        ));

        return redirect()->route('productos.listar')
            ->with('status', 'Producto actualizado correctamente.');
    }

    public function vistaMostrar(Request $request)
    {
        $registro = Producto::with(['categoria', 'presentacion', 'marca'])->findOrFail(
            $this->validar($request, [
                'id' => ['required', 'integer', 'exists:productos,id'],
            ])['id']
        );

        return $this->ver('mostrar', ['registro' => $registro]);
    }

    public function borrar(Request $request)
    {
        $producto = Producto::findOrFail($this->validar($request, [
            'id' => ['required', 'integer', 'exists:productos,id'],
        ])['id']);

        if ($producto->productosPedido()->exists()) {
            return redirect()->route('productos.listar')
                ->with('error', 'No se puede eliminar el producto porque aparece en pedidos.');
        }

        $producto->delete();

        return redirect()->route('productos.listar')
            ->with('status', 'Producto eliminado correctamente.');
    }

    private function reglasValidacion(bool $actualizacion = false): array
    {
        return [
            'nombre' => [$actualizacion ? 'sometimes' : 'required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'categoria_id' => [$actualizacion ? 'sometimes' : 'required', 'integer', 'exists:categorias,id'],
            'presentacion_id' => [$actualizacion ? 'sometimes' : 'required', 'integer', 'exists:presentaciones,id'],
            'marca_id' => [$actualizacion ? 'sometimes' : 'required', 'integer', 'exists:marcas,id'],
            'precio' => [$actualizacion ? 'sometimes' : 'required', 'numeric', 'min:0', 'max:99999999.99'],
            'existencia' => ['nullable', 'integer', 'min:0'],
            'descuento' => ['nullable', 'numeric', 'min:0', 'max:99999999.99'],
            'estado' => [$actualizacion ? 'sometimes' : 'nullable', 'in:0,1,activo,inactivo'],
        ];
    }

    private function mensajesValidacion(): array
    {
        return [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'categoria_id.required' => 'Selecciona una categoría.',
            'categoria_id.exists' => 'La categoría seleccionada ya no existe.',
            'presentacion_id.required' => 'Selecciona una presentación.',
            'presentacion_id.exists' => 'La presentación seleccionada ya no existe.',
            'marca_id.required' => 'Selecciona una marca.',
            'marca_id.exists' => 'La marca seleccionada ya no existe.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número válido.',
            'precio.min' => 'El precio no puede ser negativo.',
            'existencia.integer' => 'La existencia debe ser un número entero.',
            'existencia.min' => 'La existencia no puede ser negativa.',
            'descuento.numeric' => 'El descuento debe ser un número válido.',
            'descuento.min' => 'El descuento no puede ser negativo.',
            'estado.in' => 'Selecciona un estado válido.',
        ];
    }
}
