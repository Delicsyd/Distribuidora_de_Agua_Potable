<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiAdminService;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    protected ApiAdminService $api;

    protected array $resourceLabels = [
        'roles' => 'Roles',
        'administradores' => 'Administradores',
        'categorias' => 'Categorías',
        'presentaciones' => 'Presentaciones',
        'marcas' => 'Marcas',
        'direcciones' => 'Direcciones',
        'metodos-pago' => 'Métodos de pago',
        'productos-pedido' => 'Productos de pedido',
        'repartidores' => 'Repartidores',
        'entregas' => 'Entregas',
        'usuarios' => 'Usuarios',
        'proveedores' => 'Proveedores',
    ];

    protected array $fieldDefinitions = [
        'roles' => [
            'nombre' => ['label' => 'Nombre', 'type' => 'text', 'required' => true],
            'imagen' => ['label' => 'Imagen', 'type' => 'file', 'required' => false],
            'estado' => ['label' => 'Estado', 'type' => 'select', 'required' => true, 'options' => [1 => 'Activo', 0 => 'Inactivo']],
        ],
        'administradores' => [
            'nombres' => ['label' => 'Nombres', 'type' => 'text', 'required' => true],
            'apellidos' => ['label' => 'Apellidos', 'type' => 'text', 'required' => true],
            'correo' => ['label' => 'Correo', 'type' => 'email', 'required' => true],
            'usuario' => ['label' => 'Usuario', 'type' => 'text', 'required' => true],
           'contraseña' => ['label' => 'Contraseña', 'type' => 'password', 'required' => false],
            'url_imagen' => ['label' => 'URL de imagen', 'type' => 'text', 'required' => true],
            'rol_id' => ['label' => 'Rol', 'type' => 'select', 'required' => true, 'relationship' => 'roles'],
            'telefono' => ['label' => 'Teléfono', 'type' => 'text', 'required' => true],
            'direccion' => ['label' => 'Dirección', 'type' => 'text', 'required' => false],
            'estado' => ['label' => 'Estado', 'type' => 'select', 'required' => true, 'options' => ['Activo' => 'Activo', 'Inactivo' => 'Inactivo']],
        ],
        'categorias' => [
            'nombre' => ['label' => 'Nombre', 'type' => 'text', 'required' => true],
            'imagen' => ['label' => 'Imagen', 'type' => 'file', 'required' => false],
            'estado' => ['label' => 'Estado', 'type' => 'select', 'required' => true, 'options' => [1 => 'Activo', 0 => 'Inactivo']],
        ],
        'presentaciones' => [
            'nombre' => ['label' => 'Nombre', 'type' => 'text', 'required' => true],
            'descripcion' => ['label' => 'Descripción', 'type' => 'textarea', 'required' => false],
            'imagen' => ['label' => 'Imagen', 'type' => 'file', 'required' => false],
            'estado' => ['label' => 'Estado', 'type' => 'select', 'required' => true, 'options' => [1 => 'Activo', 0 => 'Inactivo']],
        ],
        'marcas' => [
            'nombre' => ['label' => 'Nombre', 'type' => 'text', 'required' => true],
            'imagen' => ['label' => 'Imagen', 'type' => 'file', 'required' => false],
            'estado' => ['label' => 'Estado', 'type' => 'select', 'required' => true, 'options' => [1 => 'Activo', 0 => 'Inactivo']],
        ],
        'direcciones' => [
            'cliente_id' => ['label' => 'Cliente', 'type' => 'select', 'required' => true, 'relationship' => 'clientes'],
            'calle' => ['label' => 'Calle', 'type' => 'text', 'required' => true],
            'numero' => ['label' => 'Número', 'type' => 'text', 'required' => true],
            'colonia' => ['label' => 'Colonia', 'type' => 'text', 'required' => true],
            'ciudad' => ['label' => 'Ciudad', 'type' => 'text', 'required' => true],
            'codigo_postal' => ['label' => 'Código postal', 'type' => 'text', 'required' => true],
            'referencia' => ['label' => 'Referencia', 'type' => 'text', 'required' => false],
            'imagen' => ['label' => 'Imagen', 'type' => 'file', 'required' => false],
            'estado' => ['label' => 'Estado', 'type' => 'select', 'required' => true, 'options' => [1 => 'Activo', 0 => 'Inactivo']],
        ],
        'metodos-pago' => [
            'nombre' => ['label' => 'Nombre', 'type' => 'text', 'required' => true],
            'descripcion' => ['label' => 'Descripción', 'type' => 'textarea', 'required' => false],
            'imagen' => ['label' => 'Imagen', 'type' => 'file', 'required' => false],
            'estado' => ['label' => 'Estado', 'type' => 'select', 'required' => true, 'options' => [1 => 'Activo', 0 => 'Inactivo']],
        ],
        'productos-pedido' => [
            'pedido_id' => ['label' => 'Pedido', 'type' => 'select', 'required' => true, 'relationship' => 'pedidos'],
            'producto_id' => ['label' => 'Producto', 'type' => 'select', 'required' => true, 'relationship' => 'productos'],
            'cantidad' => ['label' => 'Cantidad', 'type' => 'number', 'required' => true],
            'precio' => ['label' => 'Precio', 'type' => 'number', 'required' => true],
            'descuento' => ['label' => 'Descuento', 'type' => 'number', 'required' => false],
            'imagen' => ['label' => 'Imagen', 'type' => 'file', 'required' => false],
            'estado' => ['label' => 'Estado', 'type' => 'select', 'required' => true, 'options' => [1 => 'Activo', 0 => 'Inactivo']],
        ],
        'repartidores' => [
            'nombres' => ['label' => 'Nombres', 'type' => 'text', 'required' => true],
            'apellidos' => ['label' => 'Apellidos', 'type' => 'text', 'required' => true],
            'telefono' => ['label' => 'Teléfono', 'type' => 'text', 'required' => true],
            'licencia' => ['label' => 'Licencia', 'type' => 'text', 'required' => true],
            'imagen' => ['label' => 'Imagen', 'type' => 'file', 'required' => false],
            'estado' => ['label' => 'Estado', 'type' => 'select', 'required' => true, 'options' => [1 => 'Activo', 0 => 'Inactivo']],
        ],
        'entregas' => [
            'pedido_id' => ['label' => 'Pedido', 'type' => 'select', 'required' => true, 'relationship' => 'pedidos'],
            'repartidor_id' => ['label' => 'Repartidor', 'type' => 'select', 'required' => true, 'relationship' => 'repartidores'],
            'direccion_id' => ['label' => 'Dirección', 'type' => 'select', 'required' => true, 'relationship' => 'direcciones'],
            'fecha' => ['label' => 'Fecha', 'type' => 'date', 'required' => true],
            'hora' => ['label' => 'Hora', 'type' => 'time', 'required' => false],
            'imagen' => ['label' => 'Imagen', 'type' => 'file', 'required' => false],
            'estado' => ['label' => 'Estado', 'type' => 'select', 'required' => true, 'options' => [1 => 'Activo', 0 => 'Inactivo']],
        ],
        'usuarios' => [
            'name' => ['label' => 'Nombre', 'type' => 'text', 'required' => true],
            'email' => ['label' => 'Correo', 'type' => 'email', 'required' => true],
            'password' => ['label' => 'Contraseña', 'type' => 'password', 'required' => true],
        ],
        'proveedores' => [
            'nombre' => ['label' => 'Nombre', 'type' => 'text', 'required' => true],
            'contacto' => ['label' => 'Contacto', 'type' => 'text', 'required' => false],
            'correo' => ['label' => 'Correo', 'type' => 'email', 'required' => false],
            'telefono' => ['label' => 'Teléfono', 'type' => 'text', 'required' => false],
            'direccion' => ['label' => 'Dirección', 'type' => 'text', 'required' => false],
            'imagen' => ['label' => 'Imagen', 'type' => 'file', 'required' => false],
            'estado' => ['label' => 'Estado', 'type' => 'select', 'required' => true, 'options' => [1 => 'Activo', 0 => 'Inactivo']],
        ],
    ];

    public function __construct(ApiAdminService $api)
    {
        $this->api = $api;
    }

    public function index(string $resource)
    {
        if ($redirect = $this->ensureAuthenticated()) {
            return $redirect;
        }

        $respuesta = $this->api->get($resource);

        if ($this->isUnauthorized($respuesta)) {
            return $this->logoutAndRedirect();
        }

        if ($respuesta->failed()) {
            return back()->with('error', 'No fue posible consultar ' . $this->label($resource) . '.');
        }

        return view('admin.recursos.index', [
            'resource' => $resource,
            'label' => $this->label($resource),
            'records' => $respuesta->json('data', []),
            'fields' => $this->indexFields($resource),
        ]);
    }

    public function create(string $resource)
    {
        if ($redirect = $this->ensureAuthenticated()) {
            return $redirect;
        }

        return view('admin.recursos.form', [
            'resource' => $resource,
            'label' => $this->label($resource),
            'mode' => 'create',
            'fields' => $this->fieldDefinitions[$resource] ?? [],
            'related' => $this->relatedOptions($resource),
            'record' => [],
        ]);
    }

   public function store(string $resource, Request $request)
{
    if ($redirect = $this->ensureAuthenticated()) {
        return $redirect;
    }

   if ($resource === 'entregas' && $request->filled('hora')) {
    $hora = $request->input('hora');

    if (strlen($hora) === 5) {
        $hora .= ':00';
    }

    $request->merge(['hora' => $hora]);
}

    $datos = $request->except(['_token']);

    $respuesta = $this->sendRequest($resource, $request, $datos, 'post');

    if ($this->isUnauthorized($respuesta)) {
        return $this->logoutAndRedirect();
    }

    if ($respuesta->status() === 422) {
        return back()->withErrors($respuesta->json('errors') ?? [])
            ->withInput($this->oldInput($resource, $request));
    }

    if ($respuesta->failed()) {
        return back()->with('error', 'No fue posible registrar ' . strtolower($this->label($resource)) . '.')
            ->withInput($this->oldInput($resource, $request));
    }

    return redirect()->route("admin.{$resource}.index")
        ->with('success', ucfirst($this->label($resource)) . ' registrado correctamente.');
}
    

    public function show(string $resource, int $id)
    {
        if ($redirect = $this->ensureAuthenticated()) {
            return $redirect;
        }

        $respuesta = $this->api->get($resource, $id);

        if ($this->isUnauthorized($respuesta)) {
            return $this->logoutAndRedirect();
        }

        if ($respuesta->failed()) {
            return redirect()->route("admin.{$resource}.index")->with('error', 'No fue posible consultar el registro.');
        }

        return view('admin.recursos.show', [
            'resource' => $resource,
            'label' => $this->label($resource),
            'record' => $respuesta->json('data', []),
            'fields' => $this->fieldDefinitions[$resource] ?? [],
        ]);
    }

    public function edit(string $resource, int $id)
    {
        if ($redirect = $this->ensureAuthenticated()) {
            return $redirect;
        }

        $respuesta = $this->api->get($resource, $id);

        if ($this->isUnauthorized($respuesta)) {
            return $this->logoutAndRedirect();
        }

        if ($respuesta->failed()) {
            return redirect()->route("admin.{$resource}.index")->with('error', 'No fue posible consultar ' . strtolower($this->label($resource)) . '.');
        }

        return view('admin.recursos.form', [
            'resource' => $resource,
            'label' => $this->label($resource),
            'mode' => 'edit',
            'fields' => $this->fieldDefinitions[$resource] ?? [],
            'related' => $this->relatedOptions($resource),
            'record' => $respuesta->json('data', []),
        ]);
    }

    public function update(string $resource, Request $request, int $id)
    {
        if ($redirect = $this->ensureAuthenticated()) {
            return $redirect;
        }
        if ($resource === 'entregas' && $request->filled('hora')) {
    $hora = $request->input('hora');

    if (strlen($hora) === 5) {
        $hora .= ':00';
    }

    $request->merge(['hora' => $hora]);
}

        $datos = $request->except(['_token', '_method']);

        if ($resource === 'administradores' && empty($datos['contraseña'])) {
            unset($datos['contraseña']);
        }
        $respuesta = $this->sendRequest($resource, $request, $datos, 'put', $id);

        if ($this->isUnauthorized($respuesta)) {
            return $this->logoutAndRedirect();
        }

        if ($respuesta->status() === 422) {
            return back()->withErrors($respuesta->json('errors') ?? [])
                ->withInput($this->oldInput($resource, $request));
        }

        if ($respuesta->failed()) {
            return back()->with('error', 'No fue posible actualizar ' . strtolower($this->label($resource)) . '.')
                ->withInput($this->oldInput($resource, $request));
        }

        return redirect()->route("admin.{$resource}.index")->with('success', ucfirst($this->label($resource)) . ' actualizado correctamente.');
    }

    public function destroy(string $resource, int $id)
    {
        if ($redirect = $this->ensureAuthenticated()) {
            return $redirect;
        }

        $respuesta = $this->api->delete($resource, $id);

        if ($this->isUnauthorized($respuesta)) {
            return $this->logoutAndRedirect();
        }

        if ($respuesta->failed()) {
            return redirect()->route("admin.{$resource}.index")->with('error', 'No fue posible eliminar ' . strtolower($this->label($resource)) . '.');
        }

        return redirect()->route("admin.{$resource}.index")->with('success', ucfirst($this->label($resource)) . ' eliminado correctamente.');
    }

    private function ensureAuthenticated()
    {
        if (!session()->has('api_admin_token')) {
            return redirect()->route('admin.login');
        }

        return null;
    }

    private function oldInput(string $resource, Request $request): array
    {
        return $resource === 'administradores'
            ? $request->except(['contraseña', 'contraseña_confirmation'])
            : $request->input();
    }

    private function logoutAndRedirect()
    {
        session()->forget('api_admin_token');

        return redirect()->route('admin.login');
    }

    private function isUnauthorized($respuesta): bool
    {
        return $respuesta->status() === 401 || $respuesta->unauthorized();
    }

    private function label(string $resource): string
    {
        return $this->resourceLabels[$resource] ?? ucfirst(str_replace('-', ' ', $resource));
    }

    private function relatedOptions(string $resource): array
    {
        $map = [
            'administradores' => ['roles' => 'roles'],
            'direcciones' => ['clientes' => 'clientes'],
            'productos-pedido' => ['pedidos' => 'pedidos', 'productos' => 'productos'],
            'entregas' => ['pedidos' => 'pedidos', 'repartidores' => 'repartidores', 'direcciones' => 'direcciones'],
            'productos' => ['categorias' => 'categorias', 'presentaciones' => 'presentaciones', 'marcas' => 'marcas'],
        ];

        $result = [];

        foreach ($map[$resource] ?? [] as $key => $apiResource) {
            $respuesta = $this->api->get($apiResource);
            $result[$key] = $respuesta->successful() ? ($respuesta->json('data', [])) : [];
        }

        return $result;
    }

    private function indexFields(string $resource): array
    {
        return match ($resource) {
            'roles' => ['id', 'nombre', 'estado'],
            'administradores' => ['id', 'nombres', 'apellidos', 'correo', 'usuario', 'rol_id'],
            'categorias' => ['id', 'nombre', 'estado'],
            'presentaciones' => ['id', 'nombre', 'descripcion', 'estado'],
            'marcas' => ['id', 'nombre', 'estado'],
            'direcciones' => ['id', 'cliente_id', 'ciudad', 'colonia', 'estado'],
            'metodos-pago' => ['id', 'nombre', 'descripcion', 'estado'],
            'productos-pedido' => ['id', 'pedido_id', 'producto_id', 'cantidad', 'precio'],
            'repartidores' => ['id', 'nombres', 'apellidos', 'telefono', 'licencia'],
            'entregas' => ['id', 'pedido_id', 'repartidor_id', 'direccion_id', 'fecha'],
            'usuarios' => ['id', 'name', 'email'],
            'proveedores' => ['id', 'nombre', 'contacto', 'correo', 'telefono'],
            default => ['id'],
        };
    }

    private function sendRequest(string $resource, Request $request, array $datos, string $method, ?int $id = null)
    {
        $hasFiles = collect($datos)->contains(
            fn ($value) => $value instanceof UploadedFile
        );

        if ($hasFiles) {
            if ($method === 'post') {
                return $this->api->postConImagenes($resource, $datos);
            }

            if ($id !== null) {
                return $this->api->putConImagenes($resource, $id, $datos);
            }
        }

        if ($method === 'post') {
            return $this->api->post($resource, $datos);
        }

        if ($id !== null) {
            return $this->api->put($resource, $id, $datos);
        }

        return $this->api->post($resource, $datos);
    }
}
