<?php

namespace App\Http\Controllers;

use App\Models\Presentacion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PresentacionController extends DemoCrudController
{
    protected string $modulo = 'presentaciones';

    protected string $ruta = '/presentaciones';

    protected string $vista = 'presentaciones';

    protected string $modelo = Presentacion::class;

    protected array $campos = [
        'nombre' => ['etiqueta' => 'Nombre', 'tipo' => 'text', 'obligatorio' => true],
        'descripcion' => ['etiqueta' => 'Descripción', 'tipo' => 'textarea'],
        'imagen' => ['etiqueta' => 'Imagen de la presentación', 'tipo' => 'image'],
        'estado' => ['etiqueta' => 'Estado', 'tipo' => 'select'],
    ];

    public function listar()
    {
        return $this->ver('listado', [
            'registros' => Presentacion::query()->orderBy('id')->get(),
        ]);
    }

    public function vistaFormulario()
    {
        return $this->ver('registro');
    }

    public function registrar(Request $request)
    {
        $datos = $this->validar($request, [
            'nombre' => ['required', 'string', 'max:255', Rule::unique('presentaciones', 'nombre')],
            'descripcion' => ['nullable', 'string'],
            'estado' => ['nullable', 'in:0,1,activo,inactivo'],
        ], [
            'nombre.required' => 'El nombre de la presentación es obligatorio.',
            'nombre.max' => 'El nombre no debe superar los 255 caracteres.',
            'nombre.unique' => 'Ya existe una presentación con ese nombre.',
            'estado.in' => 'Selecciona un estado válido.',
        ]);

        $datos['estado'] = $this->normalizarEstado($datos['estado'] ?? null);
        Presentacion::create(array_merge($datos, $this->subirImagenes($request, ['imagen'])));

        return redirect()->route('presentaciones.listar')
            ->with('status', 'Presentación registrada correctamente.');
    }

    public function vistaEdicion(Request $request)
    {
        $registro = Presentacion::findOrFail($this->validar($request, [
            'id' => ['required', 'integer', 'exists:presentaciones,id'],
        ])['id']);

        return $this->ver('edicion', ['registro' => $registro]);
    }

    public function actualizar(Request $request)
    {
        $presentacion = Presentacion::findOrFail($this->validar($request, [
            'id' => ['required', 'integer', 'exists:presentaciones,id'],
        ])['id']);
        $datos = $this->validar($request, [
            'nombre' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('presentaciones', 'nombre')->ignore($presentacion->id)],
            'descripcion' => ['nullable', 'string'],
            'estado' => ['sometimes', 'required', 'in:0,1,activo,inactivo'],
        ], [
            'nombre.required' => 'El nombre de la presentación es obligatorio.',
            'nombre.max' => 'El nombre no debe superar los 255 caracteres.',
            'nombre.unique' => 'Ya existe una presentación con ese nombre.',
            'estado.in' => 'Selecciona un estado válido.',
        ]);

        if (array_key_exists('estado', $datos)) {
            $datos['estado'] = $this->normalizarEstado($datos['estado']);
        }
        $presentacion->update($this->actualizarImagenes($request, $datos, ['imagen']));

        return redirect()->route('presentaciones.listar')
            ->with('status', 'Presentación actualizada correctamente.');
    }

    public function vistaMostrar(Request $request)
    {
        $registro = Presentacion::findOrFail($this->validar($request, [
            'id' => ['required', 'integer', 'exists:presentaciones,id'],
        ])['id']);

        return $this->ver('mostrar', ['registro' => $registro]);
    }

    public function borrar(Request $request)
    {
        $presentacion = Presentacion::findOrFail($this->validar($request, [
            'id' => ['required', 'integer', 'exists:presentaciones,id'],
        ])['id']);

        if ($presentacion->productos()->exists()) {
            return redirect()->route('presentaciones.listar')
                ->with('error', 'No se puede eliminar la presentación porque tiene productos relacionados.');
        }

        $presentacion->delete();

        return redirect()->route('presentaciones.listar')
            ->with('status', 'Presentación eliminada correctamente.');
    }
}
