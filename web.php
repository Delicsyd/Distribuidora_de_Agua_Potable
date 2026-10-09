<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DireccionController;
use App\Http\Controllers\EntregaController;
use App\Http\Controllers\ClimaController;
use App\Http\Controllers\GeolocalizacionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PresentacionController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProductoPedidoController;
use App\Http\Controllers\RepartidorController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\TipoCambioController;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/inicio','layouts/app');
//Route::view('/clientes','/clientes/listado');
//Route::view('/admin/formulario', 'administradores.registro');
//Route::post('/admin/listado','administradores/listado');
//Route::view('/info-producto','/productos/detalle');

Route::get('/admin/listar',[AdministradorController::class,'listar']);
Route::get('/admin/crear',[AdministradorController::class,'vistaFormulario']);
Route::post('/admin/guardar',[AdministradorController::class,'registrar']);
Route::get('/admin/editar',[AdministradorController::class,'vistaEdicion']);
Route::put('/admin/actualizar',[AdministradorController::class,'actualizar']);
Route::get('/admin/mostrar',[AdministradorController::class,'vistaMostrar']);
Route::delete('/admin/borrar',[AdministradorController::class,'borrar']);

foreach ([
    'categorias' => CategoriaController::class,
    'clientes' => ClienteController::class,
    'direcciones' => DireccionController::class,
    'entregas' => EntregaController::class,
    'marcas' => MarcaController::class,
    'metodos-pago' => MetodoPagoController::class,
    'pedidos' => PedidoController::class,
    'presentaciones' => PresentacionController::class,
    'productos' => ProductoController::class,
    'productos-pedido' => ProductoPedidoController::class,
    'repartidores' => RepartidorController::class,
    'roles' => RolController::class,
    'usuarios' => UserController::class,
] as $prefijo => $controlador) {
    Route::controller($controlador)->prefix($prefijo)->name($prefijo.'.')->group(function () {
        Route::get('/', 'listar')->name('index');
        Route::get('/listar', 'listar')->name('listar');
        Route::get('/crear', 'vistaFormulario')->name('formulario');
        Route::post('/guardar', 'registrar')->name('guardar');
        Route::get('/editar', 'vistaEdicion')->name('editar');
        Route::put('/actualizar', 'actualizar')->name('actualizar');
        Route::get('/mostrar', 'vistaMostrar')->name('mostrar');
        Route::delete('/borrar', 'borrar')->name('borrar');
    });
}



Route::get('/ubicacion',[GeolocalizacionController::class,'obtenerUbicacion'])->name('ubicacion.obtener');
Route::get('/clima', [ClimaController::class, 'mostrar'])->name('clima.mostrar');
Route::get('/tipo-cambio', [TipoCambioController::class, 'mostrar'])->name('tipo-cambio.mostrar');

Route::get('/login',[LoginController::class,'mostrarLogin'])->name('login');
Route::post('/login',[LoginController::class,'login'])->name('login.procesar');
Route::post('/logout',[LoginController::class,'logout'])->name('logout');
Route::get('/dashboard', function () {return view('administrador.dashboard');
})->middleware('auth:admin');

Route::get('/auth/google',[GoogleController::class,'redirect'])->name('google.login');
Route::get('/auth/google/callback',[GoogleController::class,'callback'])->name('google.callback');
Route::get('/prueba-laravel', function(){
    return 'Laravel esta funcionando correctamente';
});
Route::get('/prueba-cloudinary', function () {
    return '
    <h2>Prueba de almacenamiento con Cloudinary</h2>
    <form method="POST" action="/prueba-cloudinary" enctype="multipart/form-data">
        '.csrf_field().'
        <input type="file" name="imagen" accept="image/*" required>
        <button type="submit">Subir imagen</button>
    </form>';
});

Route::post('/prueba-cloudinary', function (
    \Illuminate\Http\Request $request
) {
    $request->validate([
        'imagen' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
    ]);

    $url = app(\App\Services\CloudinaryImageService::class)
        ->subir($request->file('imagen'));

    return response(
        '<h2>Imagen subida correctamente</h2>
        <img src="'.e($url).'" style="max-width:300px">
        <p>URL pública:</p>
        <a href="'.e($url).'" target="_blank" rel="noopener noreferrer">'.e($url).'</a>',
        200
    );
});