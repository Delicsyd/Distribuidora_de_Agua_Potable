<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends DemoCrudController
{
    protected string $modulo = 'pedidos';
    protected string $ruta = '/pedidos';
    protected string $vista = 'pedidos';
    protected string $modelo = Pedido::class;
    protected array $campos = [
        'cliente_id' => ['etiqueta' => 'Cliente', 'tipo' => 'select', 'obligatorio' => true],
        'metodo_pago_id' => ['etiqueta' => 'Método de pago', 'tipo' => 'select', 'obligatorio' => true],
        'fecha' => ['etiqueta' => 'Fecha', 'tipo' => 'date', 'obligatorio' => true],
        'iva' => ['etiqueta' => 'IVA', 'tipo' => 'number'],
        'descuento' => ['etiqueta' => 'Descuento', 'tipo' => 'number'],
        'total' => ['etiqueta' => 'Total', 'tipo' => 'number', 'obligatorio' => true],
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
