<?php

namespace App\Http\Controllers;

use App\Models\Entrega;
use Illuminate\Http\Request;

class EntregaController extends DemoCrudController
{
    protected string $modulo = 'entregas';
    protected string $ruta = '/entregas';
    protected string $vista = 'entregas';
    protected string $modelo = Entrega::class;
    protected array $campos = [
        'pedido_id' => ['etiqueta' => 'Pedido', 'tipo' => 'select', 'obligatorio' => true],
        'repartidor_id' => ['etiqueta' => 'Repartidor', 'tipo' => 'select', 'obligatorio' => true],
        'direccion_id' => ['etiqueta' => 'Dirección', 'tipo' => 'select', 'obligatorio' => true],
        'fecha' => ['etiqueta' => 'Fecha', 'tipo' => 'date', 'obligatorio' => true],
        'hora' => ['etiqueta' => 'Hora', 'tipo' => 'time'],
        'imagen' => ['etiqueta' => 'Imagen', 'tipo' => 'text'],
        'estado' => ['etiqueta' => 'Estado', 'tipo' => 'select'],
    ];

    public function listar() { return $this->ver('listado', ['registros' => $this->registrosDePrueba()]); }
    public function vistaFormulario() { return $this->ver('registro'); }
    public function registrar(Request $request) { return $this->respuestaDemo('REGISTRADA'); }
    public function vistaEdicion(Request $request) { return $this->ver('edicion', ['registro' => $this->registroDePrueba($request->id ?? 1)]); }
    public function actualizar(Request $request) { return $this->respuestaDemo('ACTUALIZADA'); }
    public function vistaMostrar(Request $request) { return $this->ver('mostrar', ['registro' => $this->registroDePrueba($request->id ?? 1)]); }
    public function borrar(Request $request) { return $this->respuestaDemo('BORRADA'); }
}
