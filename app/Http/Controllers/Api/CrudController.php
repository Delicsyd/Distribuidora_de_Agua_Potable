<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Administrador;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Direccion;
use App\Models\Entrega;
use App\Models\Marca;
use App\Models\MetodoPago;
use App\Models\Pedido;
use App\Models\Presentacion;
use App\Models\Producto;
use App\Models\ProductoPedido;
use App\Models\Proveedor;
use App\Models\Repartidor;
use App\Models\Rol;
use App\Models\User;
use App\Services\CloudinaryImageService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use LogicException;

class CrudController extends Controller
{
    private const IMAGE_FIELDS = [
        'roles' => ['imagen'],
        'categorias' => ['imagen'],
        'presentaciones' => ['imagen'],
        'marcas' => ['imagen'],
        'productos' => ['imagen', 'imagen_secundaria', 'imagen_terciaria'],
        'direcciones' => ['imagen'],
        'metodos-pago' => ['imagen'],
        'productos-pedido' => ['imagen'],
        'repartidores' => ['imagen'],
        'entregas' => ['imagen'],
        'proveedores' => ['imagen'],
    ];

    private const RESOURCES = [
        'roles' => [
            'model' => Rol::class,
            'rules' => [
                'nombre' => 'required|string|max:255|unique:roles,nombre',
                'imagen' => 'nullable|string|max:255',
                'estado' => 'sometimes|boolean',
            ],
        ],
        'administradores' => [
            'model' => Administrador::class,
            'rules' => [
                'nombres' => 'required|string|max:255',
                'apellidos' => 'required|string|max:255',
                'correo' => 'required|email|max:255',
                'usuario' => 'required|string|max:255|unique:administradores,usuario',
                'contraseña' => 'required|string|min:8|max:255|confirmed',
                'url_imagen' => 'required|string|max:255',
                'rol_id' => 'required|integer|exists:roles,id',
                'telefono' => 'required|string|max:255|unique:administradores,telefono',
                'direccion' => 'nullable|string|max:255',
                'estado' => 'required|string|max:255',
            ],
        ],
        'categorias' => [
            'model' => Categoria::class,
            'rules' => [
                'nombre' => 'required|string|max:255|unique:categorias,nombre',
                'imagen' => 'nullable|string|max:255',
                'estado' => 'sometimes|boolean',
            ],
        ],
        'presentaciones' => [
            'model' => Presentacion::class,
            'rules' => [
                'nombre' => 'required|string|max:255|unique:presentaciones,nombre',
                'descripcion' => 'nullable|string',
                'imagen' => 'nullable|string|max:255',
                'estado' => 'sometimes|boolean',
            ],
        ],
        'marcas' => [
            'model' => Marca::class,
            'rules' => [
                'nombre' => 'required|string|max:255|unique:marcas,nombre',
                'imagen' => 'nullable|string|max:255',
                'estado' => 'sometimes|boolean',
            ],
        ],
        'productos' => [
            'model' => Producto::class,
            'rules' => [
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'categoria_id' => 'required|integer|exists:categorias,id',
                'presentacion_id' => 'required|integer|exists:presentaciones,id',
                'marca_id' => 'required|integer|exists:marcas,id',
                'precio' => 'required|numeric|min:0',
                'existencia' => 'sometimes|integer|min:0',
                'descuento' => 'sometimes|numeric|min:0',
                'imagen' => 'nullable|string|max:255',
                'imagen_secundaria' => 'nullable|string|max:255',
                'imagen_terciaria' => 'nullable|string|max:255',
                'estado' => 'sometimes|boolean',
            ],
        ],
        'clientes' => [
            'model' => Cliente::class,
            'rules' => [
                'nombres' => 'required|string|max:255',
                'apellidos' => 'required|string|max:255',
                'correo' => 'required|email|max:255|unique:clientes,correo',
                'contraseña' => 'required|string|min:8|max:255',
                'telefono' => 'required|string|regex:/^[0-9]{10}$/',
                'imagen' => 'nullable|string|max:255',
                'estado' => 'sometimes|boolean',
            ],
        ],
        'direcciones' => [
            'model' => Direccion::class,
            'rules' => [
                'cliente_id' => 'required|integer|exists:clientes,id',
                'calle' => 'required|string|max:255',
                'numero' => 'required|string|max:255',
                'colonia' => 'required|string|max:255',
                'ciudad' => 'required|string|max:255',
                'codigo_postal' => 'required|string|size:5',
                'referencia' => 'nullable|string|max:255',
                'imagen' => 'nullable|string|max:255',
                'estado' => 'sometimes|boolean',
            ],
        ],
        'metodos-pago' => [
            'model' => MetodoPago::class,
            'rules' => [
                'nombre' => 'required|string|max:255|unique:metodos_pago,nombre',
                'descripcion' => 'nullable|string',
                'imagen' => 'nullable|string|max:255',
                'estado' => 'sometimes|boolean',
            ],
        ],
        'pedidos' => [
            'model' => Pedido::class,
            'rules' => [
                'cliente_id' => 'required|integer|exists:clientes,id',
                'metodo_pago_id' => 'required|integer|exists:metodos_pago,id',
                'fecha' => 'required|date',
                'iva' => 'sometimes|numeric|min:0',
                'descuento' => 'sometimes|numeric|min:0',
                'total' => 'required|numeric|min:0',
                'imagen' => 'nullable|string|max:255',
                'estado' => 'sometimes|boolean',
            ],
        ],
        'productos-pedido' => [
            'model' => ProductoPedido::class,
            'rules' => [
                'pedido_id' => 'required|integer|exists:pedidos,id',
                'producto_id' => 'required|integer|exists:productos,id',
                'cantidad' => 'required|integer|min:1',
                'precio' => 'required|numeric|min:0',
                'descuento' => 'sometimes|numeric|min:0',
                'imagen' => 'nullable|string|max:255',
                'estado' => 'sometimes|boolean',
            ],
        ],
        'repartidores' => [
            'model' => Repartidor::class,
            'rules' => [
                'nombres' => 'required|string|max:255',
                'apellidos' => 'required|string|max:255',
                'telefono' => 'required|string|regex:/^[0-9]{10}$/',
                'licencia' => 'required|string|max:255|unique:repartidores,licencia',
                'imagen' => 'nullable|string|max:255',
                'estado' => 'sometimes|boolean',
            ],
        ],
        'proveedores' => [
            'model' => Proveedor::class,
            'rules' => [
                'nombre' => 'required|string|max:255',
                'contacto' => 'nullable|string|max:255',
                'correo' => 'nullable|email|max:255|unique:proveedores,correo',
                'telefono' => 'nullable|string|max:20',
                'direccion' => 'nullable|string|max:255',
               'imagen' => 'nullable|string|max:255',
                'estado' => 'sometimes|boolean',
            ],
        ],
        'entregas' => [
            'model' => Entrega::class,
            'rules' => [
                'pedido_id' => 'required|integer|exists:pedidos,id',
                'repartidor_id' => 'required|integer|exists:repartidores,id',
                'direccion_id' => 'required|integer|exists:direcciones,id',
                'fecha' => 'required|date',
                'hora' => 'nullable|date_format:H:i:s',
                'imagen' => 'nullable|string|max:255',
                'estado' => 'sometimes|boolean',
            ],
        ],
        'usuarios' => [
            'model' => User::class,
            'rules' => [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|string|min:8|max:255',
            ],
        ],
    ];

    public function index(Request $request): JsonResponse
    {
        $model = $this->newModel($request);

        return response()->json(['data' => $model->newQuery()->get()]);
    }

    public function store(Request $request): JsonResponse
    {
        $model = $this->newModel($request);
        $data = $this->validatedData($request, $model, false);

        if ($data instanceof JsonResponse) {
            return $data;
        }

     $record = $model->newQuery()->create($this->prepareData($data, $request));

        return response()->json(['data' => $record], 201);
    }

    public function show(Request $request, string $id): JsonResponse
    {
        $record = $this->newModel($request)->newQuery()->find($id);

        if ($record === null) {
            return response()->json(['message' => 'Registro no encontrado.'], 404);
        }

        return response()->json(['data' => $record]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $model = $this->newModel($request);
        $record = $model->newQuery()->find($id);

        if ($record === null) {
            return response()->json(['message' => 'Registro no encontrado.'], 404);
        }

        $data = $this->validatedData($request, $record, true);

        if ($data instanceof JsonResponse) {
            return $data;
        }

        if ($data === []) {
            return response()->json([
                'message' => 'Debe enviar al menos un campo para actualizar.',
            ], 422);
        }

        $record->fill($this->prepareData($data, $request));
        $record->save();

        return response()->json(['data' => $record->refresh()]);
    }

    public function destroy(Request $request, string $id): JsonResponse
    {
        $record = $this->newModel($request)->newQuery()->find($id);

        if ($record === null) {
            return response()->json(['message' => 'Registro no encontrado.'], 404);
        }

        $record->delete();

        return response()->json(['message' => 'Registro eliminado correctamente.']);
    }

    private function newModel(Request $request): Model
    {
        $routeName = $request->route()->getName();
        $resource = explode('.', (string) $routeName)[1] ?? '';
        $configuration = self::RESOURCES[$resource] ?? null;

        if ($configuration === null) {
            throw new LogicException('No existe una configuración API para este recurso.');
        }

        $modelClass = $configuration['model'];

        return new $modelClass;
    }

    private function validatedData(Request $request, Model $model, bool $updating): array|JsonResponse
    {
        $routeName = $request->route()->getName();
        $resource = explode('.', (string) $routeName)[1] ?? '';
        $rules = self::RESOURCES[$resource]['rules'];

        if ($resource === 'administradores' && $updating) {
            $rules['contraseña'] = 'nullable|string|min:8|max:255|confirmed';
        }

        foreach (self::IMAGE_FIELDS[$resource] ?? [] as $campo) {
            if (array_key_exists($campo, $rules)) {
                $rules[$campo] = $request->hasFile($campo)
                    ? 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120'
                    : 'nullable|string|max:255';
            }
        }

        foreach ($rules as $field => $fieldRules) {
            $compiledRules = [];

            foreach (explode('|', $fieldRules) as $rule) {
                if (str_starts_with($rule, 'unique:')) {
                    $uniqueTarget = substr($rule, strlen('unique:'));
                    [$table, $column] = array_pad(explode(',', $uniqueTarget, 2), 2, $field);
                    $compiledRules[] = $updating
                        ? Rule::unique($table, $column)->ignore($model->getKey(), $model->getKeyName())
                        : Rule::unique($table, $column);

                    continue;
                }

                $compiledRules[] = $rule;
            }

            if ($updating) {
                array_unshift($compiledRules, 'sometimes');
            }

            $rules[$field] = $compiledRules;
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Los datos enviados no son válidos.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        if ($resource === 'administradores') {
            unset($data['contraseña_confirmation']);

            if ($updating && (($data['contraseña'] ?? null) === null || $data['contraseña'] === '')) {
                unset($data['contraseña']);
            }
        }

        return $data;
    }

    private function prepareData(array $data, Request $request): array
    {
        $routeName = $request->route()->getName();
        $resource = explode('.', (string) $routeName)[1] ?? '';
        $carpeta = 'distribuidora/' . $resource;
        $servicio = app(CloudinaryImageService::class);

        foreach (self::IMAGE_FIELDS[$resource] ?? [] as $campo) {
            if ($request->hasFile($campo)) {
                $data[$campo] = $servicio->subir(
                    $request->file($campo),
                    $carpeta
                );
            }
        }

        foreach (['password', 'contraseña'] as $passwordField) {
            if (isset($data[$passwordField])) {
                $data[$passwordField] = Hash::make($data[$passwordField]);
            }
        }

        return $data;
    }
}
