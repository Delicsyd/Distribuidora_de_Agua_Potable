<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use Illuminate\Http\Request;

class DireccionController extends DemoCrudController
{
    protected string $modulo = 'direcciones';
    protected string $ruta = '/direcciones';
    protected string $vista = 'direcciones';
    protected string $modelo = Direccion::class;
    protected array $campos = [
        'cliente_id' => ['etiqueta' => 'Cliente', 'tipo' => 'select', 'obligatorio' => true],
        'calle' => ['etiqueta' => 'Calle', 'tipo' => 'text', 'obligatorio' => true],
        'numero' => ['etiqueta' => 'Número', 'tipo' => 'text', 'obligatorio' => true],
        'colonia' => ['etiqueta' => 'Colonia', 'tipo' => 'text', 'obligatorio' => true],
        'ciudad' => ['etiqueta' => 'Ciudad', 'tipo' => 'text', 'obligatorio' => true],
        'codigo_postal' => ['etiqueta' => 'Código postal', 'tipo' => 'text', 'obligatorio' => true],
        'referencia' => ['etiqueta' => 'Referencia', 'tipo' => 'textarea'],
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
