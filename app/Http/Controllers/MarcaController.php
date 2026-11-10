<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MarcaController extends DemoCrudController
{
    protected string $modulo = 'marcas';

    protected string $ruta = '/marcas';

    protected string $vista = 'marcas';

    protected string $modelo = Marca::class;

    protected array $campos = [
        'nombre' => ['etiqueta' => 'Nombre', 'tipo' => 'text', 'obligatorio' => true],
        'imagen' => ['etiqueta' => 'Logotipo', 'tipo' => 'image'],
        'estado' => ['etiqueta' => 'Estado', 'tipo' => 'select'],
    ];

    public function listar()
    {
        return $this->ver('listado', [
            'registros' => Marca::query()->orderBy('id')->get(),
        ]);
    }

    public function vistaFormulario()
    {
        return $this->ver('registro');
    }

    public function registrar(Request $request)
    {
        $datos = $this->validar($request, [
            'nombre' => ['required', 'string', 'max:255', Rule::unique('marcas', 'nombre')],
            'estado' => ['nullable', 'in:0,1,activo,inactivo'],
        ], [
            'nombre.required' => 'El nombre de la marca es obligatorio.',
            'nombre.max' => 'El nombre no debe superar los 255 caracteres.',
            'nombre.unique' => 'Ya existe una marca con ese nombre.',
            'estado.in' => 'Selecciona un estado válido.',
        ]);

        $datos['estado'] = $this->normalizarEstado($datos['estado'] ?? null);
        Marca::create(array_merge($datos, $this->subirImagenes($request, ['imagen'])));

        return redirect()->route('marcas.listar')
            ->with('status', 'Marca registrada correctamente.');
    }

    public function vistaEdicion(Request $request)
    {
        $registro = Marca::findOrFail($this->validar($request, [
            'id' => ['required', 'integer', 'exists:marcas,id'],
        ])['id']);

        return $this->ver('edicion', ['registro' => $registro]);
    }

    public function actualizar(Request $request)
    {
        $marca = Marca::findOrFail($this->validar($request, [
            'id' => ['required', 'integer', 'exists:marcas,id'],
        ])['id']);
        $datos = $this->validar($request, [
            'nombre' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('marcas', 'nombre')->ignore($marca->id)],
            'estado' => ['sometimes', 'required', 'in:0,1,activo,inactivo'],
        ], [
            'nombre.required' => 'El nombre de la marca es obligatorio.',
            'nombre.max' => 'El nombre no debe superar los 255 caracteres.',
            'nombre.unique' => 'Ya existe una marca con ese nombre.',
            'estado.in' => 'Selecciona un estado válido.',
        ]);

        if (array_key_exists('estado', $datos)) {
            $datos['estado'] = $this->normalizarEstado($datos['estado']);
        }
        $marca->update($this->actualizarImagenes($request, $datos, ['imagen']));

        return redirect()->route('marcas.listar')
            ->with('status', 'Marca actualizada correctamente.');
    }

    public function vistaMostrar(Request $request)
    {
        $registro = Marca::findOrFail($this->validar($request, [
            'id' => ['required', 'integer', 'exists:marcas,id'],
        ])['id']);

        return $this->ver('mostrar', ['registro' => $registro]);
    }

    public function borrar(Request $request)
    {
        $marca = Marca::findOrFail($this->validar($request, [
            'id' => ['required', 'integer', 'exists:marcas,id'],
        ])['id']);

        if ($marca->productos()->exists()) {
            return redirect()->route('marcas.listar')
                ->with('error', 'No se puede eliminar la marca porque tiene productos relacionados.');
        }

        $marca->delete();

        return redirect()->route('marcas.listar')
            ->with('status', 'Marca eliminada correctamente.');
    }
}
