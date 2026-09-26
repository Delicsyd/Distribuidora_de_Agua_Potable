<?php

namespace App\Http\Controllers;

use App\Models\ProductoPedido;
use Illuminate\Http\Request;

class ProductoPedidoController extends DemoCrudController
{
    protected string $modulo = 'productos de pedidos';
    protected string $ruta = '/productos-pedido';
    protected string $vista = 'productos_pedido';
    protected string $modelo = ProductoPedido::class;
    protected array $campos = [
        'pedido_id' => ['etiqueta' => 'Pedido', 'tipo' => 'select', 'obligatorio' => true],
        'producto_id' => ['etiqueta' => 'Producto', 'tipo' => 'select', 'obligatorio' => true],
        'cantidad' => ['etiqueta' => 'Cantidad', 'tipo' => 'number', 'obligatorio' => true],
        'precio' => ['etiqueta' => 'Precio', 'tipo' => 'number', 'obligatorio' => true],
        'descuento' => ['etiqueta' => 'Descuento', 'tipo' => 'number'],
        'imagen' => ['etiqueta' => 'Imagen', 'tipo' => 'text'],
        'estado' => ['etiqueta' => 'Estado', 'tipo' => 'select'],
    ];

    public function listar() { return $this->ver('listado', ['registros' => $this->registrosDePrueba()]); }
    public function vistaFormulario() { return $this->ver('registro'); }
    public function registrar(Request $request) { return $this->respuestaDemo('REGISTRADO'); }
    public function vistaEdicion(Request $request) { return $this->ver('edicion', ['registro' => $this->registroDePrueba($request->id ?? 1)]); }
    public function actualizar(Request $request) { return $this->respuestaDemo('ACTUALIZADO'); }
    public function vistaMostrar(Request $request) { return $this->ver('mostrar', ['registro' => $this->registroDePrueba($request->id ?? 1)]); }
    public function borrar(Request $request) { return $this->respuestaDemo('BORRADO'); }
}
