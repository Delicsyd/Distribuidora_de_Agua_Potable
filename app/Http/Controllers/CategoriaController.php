<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoriaController extends DemoCrudController
{
    protected string $modulo = 'categorias';

    protected string $ruta = '/categorias';

    protected string $vista = 'categorias';

    protected string $modelo = Categoria::class;

    protected array $campos = [
        'nombre' => ['etiqueta' => 'Nombre', 'tipo' => 'text', 'obligatorio' => true],
        'imagen' => ['etiqueta' => 'Imagen representativa', 'tipo' => 'image'],
        'estado' => ['etiqueta' => 'Estado', 'tipo' => 'select'],
    ];

    public function listar()
    {
        return $this->ver('listado', [
            'registros' => Categoria::query()->orderBy('id')->get(),
        ]);
    }

    public function vistaFormulario()
    {
        return $this->ver('registro');
    }

    public function registrar(Request $request)
    {
        $datos = $this->validar($request, [
            'nombre' => ['required', 'string', 'max:255', Rule::unique('categorias', 'nombre')],
            'estado' => ['nullable', 'in:0,1,activo,inactivo'],
        ], [
            'nombre.required' => 'El nombre de la categoría es obligatorio.',
            'nombre.max' => 'El nombre no debe superar los 255 caracteres.',
            'nombre.unique' => 'Ya existe una categoría con ese nombre.',
            'estado.in' => 'Selecciona un estado válido.',
        ]);

        $datos['estado'] = $this->normalizarEstado($datos['estado'] ?? null);
        Categoria::create(array_merge($datos, $this->subirImagenes($request, ['imagen'])));

        return redirect()->route('categorias.listar')
            ->with('status', 'Categoría registrada correctamente.');
    }

    public function vistaEdicion(Request $request)
    {
        $registro = Categoria::findOrFail($this->validar($request, [
            'id' => ['required', 'integer', 'exists:categorias,id'],
        ])['id']);

        return $this->ver('edicion', ['registro' => $registro]);
    }

    public function actualizar(Request $request)
    {
        $categoria = Categoria::findOrFail($this->validar($request, [
            'id' => ['required', 'integer', 'exists:categorias,id'],
        ])['id']);
        $datos = $this->validar($request, [
            'nombre' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('categorias', 'nombre')->ignore($categoria->id)],
            'estado' => ['sometimes', 'required', 'in:0,1,activo,inactivo'],
        ], [
            'nombre.required' => 'El nombre de la categoría es obligatorio.',
            'nombre.max' => 'El nombre no debe superar los 255 caracteres.',
            'nombre.unique' => 'Ya existe una categoría con ese nombre.',
            'estado.in' => 'Selecciona un estado válido.',
        ]);

        if (array_key_exists('estado', $datos)) {
            $datos['estado'] = $this->normalizarEstado($datos['estado']);
        }
        $categoria->update($this->actualizarImagenes($request, $datos, ['imagen']));

        return redirect()->route('categorias.listar')
            ->with('status', 'Categoría actualizada correctamente.');
    }

    public function vistaMostrar(Request $request)
    {
        $registro = Categoria::findOrFail($this->validar($request, [
            'id' => ['required', 'integer', 'exists:categorias,id'],
        ])['id']);

        return $this->ver('mostrar', ['registro' => $registro]);
    }

    public function borrar(Request $request)
    {
        $categoria = Categoria::findOrFail($this->validar($request, [
            'id' => ['required', 'integer', 'exists:categorias,id'],
        ])['id']);

        if ($categoria->productos()->exists()) {
            return redirect()->route('categorias.listar')
                ->with('error', 'No se puede eliminar la categoría porque tiene productos relacionados.');
        }

        $categoria->delete();

        return redirect()->route('categorias.listar')
            ->with('status', 'Categoría eliminada correctamente.');
    }
}
