<?php

use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DireccionController;
use App\Http\Controllers\EntregaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PresentacionController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProductoPedidoController;
use App\Http\Controllers\RepartidorController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/inicio', function () {
    return view('welcome');
});

Route::get('/admin/listar', [AdministradorController::class, 'listar']);
Route::get('/admin/crear', [AdministradorController::class, 'vistaFormulario']);
Route::post('/admin/guardar', [AdministradorController::class, 'registrar']);
Route::get('/admin/editar', [AdministradorController::class, 'vistaEdicion']);
Route::put('/admin/actualizar', [AdministradorController::class, 'actualizar']);
Route::get('/admin/mostrar', [AdministradorController::class, 'vistaMostrar']);
Route::delete('/admin/borrar', [AdministradorController::class, 'borrar']);

Route::get('/categorias/listar', [CategoriaController::class, 'listar']);
Route::get('/categorias/crear', [CategoriaController::class, 'vistaFormulario']);
Route::post('/categorias/guardar', [CategoriaController::class, 'registrar']);
Route::get('/categorias/editar', [CategoriaController::class, 'vistaEdicion']);
Route::put('/categorias/actualizar', [CategoriaController::class, 'actualizar']);
Route::get('/categorias/mostrar', [CategoriaController::class, 'vistaMostrar']);
Route::delete('/categorias/borrar', [CategoriaController::class, 'borrar']);

Route::get('/clientes/listar', [ClienteController::class, 'listar']);
Route::get('/clientes/crear', [ClienteController::class, 'vistaFormulario']);
Route::post('/clientes/guardar', [ClienteController::class, 'registrar']);
Route::get('/clientes/editar', [ClienteController::class, 'vistaEdicion']);
Route::put('/clientes/actualizar', [ClienteController::class, 'actualizar']);
Route::get('/clientes/mostrar', [ClienteController::class, 'vistaMostrar']);
Route::delete('/clientes/borrar', [ClienteController::class, 'borrar']);

Route::get('/direcciones/listar', [DireccionController::class, 'listar']);
Route::get('/direcciones/crear', [DireccionController::class, 'vistaFormulario']);
Route::post('/direcciones/guardar', [DireccionController::class, 'registrar']);
Route::get('/direcciones/editar', [DireccionController::class, 'vistaEdicion']);
Route::put('/direcciones/actualizar', [DireccionController::class, 'actualizar']);
Route::get('/direcciones/mostrar', [DireccionController::class, 'vistaMostrar']);
Route::delete('/direcciones/borrar', [DireccionController::class, 'borrar']);

Route::get('/entregas/listar', [EntregaController::class, 'listar']);
Route::get('/entregas/crear', [EntregaController::class, 'vistaFormulario']);
Route::post('/entregas/guardar', [EntregaController::class, 'registrar']);
Route::get('/entregas/editar', [EntregaController::class, 'vistaEdicion']);
Route::put('/entregas/actualizar', [EntregaController::class, 'actualizar']);
Route::get('/entregas/mostrar', [EntregaController::class, 'vistaMostrar']);
Route::delete('/entregas/borrar', [EntregaController::class, 'borrar']);

Route::get('/marcas/listar', [MarcaController::class, 'listar']);
Route::get('/marcas/crear', [MarcaController::class, 'vistaFormulario']);
Route::post('/marcas/guardar', [MarcaController::class, 'registrar']);
Route::get('/marcas/editar', [MarcaController::class, 'vistaEdicion']);
Route::put('/marcas/actualizar', [MarcaController::class, 'actualizar']);
Route::get('/marcas/mostrar', [MarcaController::class, 'vistaMostrar']);
Route::delete('/marcas/borrar', [MarcaController::class, 'borrar']);

Route::get('/metodos-pago/listar', [MetodoPagoController::class, 'listar']);
Route::get('/metodos-pago/crear', [MetodoPagoController::class, 'vistaFormulario']);
Route::post('/metodos-pago/guardar', [MetodoPagoController::class, 'registrar']);
Route::get('/metodos-pago/editar', [MetodoPagoController::class, 'vistaEdicion']);
Route::put('/metodos-pago/actualizar', [MetodoPagoController::class, 'actualizar']);
Route::get('/metodos-pago/mostrar', [MetodoPagoController::class, 'vistaMostrar']);
Route::delete('/metodos-pago/borrar', [MetodoPagoController::class, 'borrar']);

Route::get('/pedidos/listar', [PedidoController::class, 'listar']);
Route::get('/pedidos/crear', [PedidoController::class, 'vistaFormulario']);
Route::post('/pedidos/guardar', [PedidoController::class, 'registrar']);
Route::get('/pedidos/editar', [PedidoController::class, 'vistaEdicion']);
Route::put('/pedidos/actualizar', [PedidoController::class, 'actualizar']);
Route::get('/pedidos/mostrar', [PedidoController::class, 'vistaMostrar']);
Route::delete('/pedidos/borrar', [PedidoController::class, 'borrar']);

Route::get('/presentaciones/listar', [PresentacionController::class, 'listar']);
Route::get('/presentaciones/crear', [PresentacionController::class, 'vistaFormulario']);
Route::post('/presentaciones/guardar', [PresentacionController::class, 'registrar']);
Route::get('/presentaciones/editar', [PresentacionController::class, 'vistaEdicion']);
Route::put('/presentaciones/actualizar', [PresentacionController::class, 'actualizar']);
Route::get('/presentaciones/mostrar', [PresentacionController::class, 'vistaMostrar']);
Route::delete('/presentaciones/borrar', [PresentacionController::class, 'borrar']);

Route::get('/productos/listar', [ProductoController::class, 'listar']);
Route::get('/productos/crear', [ProductoController::class, 'vistaFormulario']);
Route::post('/productos/guardar', [ProductoController::class, 'registrar']);
Route::get('/productos/editar', [ProductoController::class, 'vistaEdicion']);
Route::put('/productos/actualizar', [ProductoController::class, 'actualizar']);
Route::get('/productos/mostrar', [ProductoController::class, 'vistaMostrar']);
Route::delete('/productos/borrar', [ProductoController::class, 'borrar']);

Route::get('/productos-pedido/listar', [ProductoPedidoController::class, 'listar']);
Route::get('/productos-pedido/crear', [ProductoPedidoController::class, 'vistaFormulario']);
Route::post('/productos-pedido/guardar', [ProductoPedidoController::class, 'registrar']);
Route::get('/productos-pedido/editar', [ProductoPedidoController::class, 'vistaEdicion']);
Route::put('/productos-pedido/actualizar', [ProductoPedidoController::class, 'actualizar']);
Route::get('/productos-pedido/mostrar', [ProductoPedidoController::class, 'vistaMostrar']);
Route::delete('/productos-pedido/borrar', [ProductoPedidoController::class, 'borrar']);

Route::get('/repartidores/listar', [RepartidorController::class, 'listar']);
Route::get('/repartidores/crear', [RepartidorController::class, 'vistaFormulario']);
Route::post('/repartidores/guardar', [RepartidorController::class, 'registrar']);
Route::get('/repartidores/editar', [RepartidorController::class, 'vistaEdicion']);
Route::put('/repartidores/actualizar', [RepartidorController::class, 'actualizar']);
Route::get('/repartidores/mostrar', [RepartidorController::class, 'vistaMostrar']);
Route::delete('/repartidores/borrar', [RepartidorController::class, 'borrar']);

Route::get('/roles/listar', [RolController::class, 'listar']);
Route::get('/roles/crear', [RolController::class, 'vistaFormulario']);
Route::post('/roles/guardar', [RolController::class, 'registrar']);
Route::get('/roles/editar', [RolController::class, 'vistaEdicion']);
Route::put('/roles/actualizar', [RolController::class, 'actualizar']);
Route::get('/roles/mostrar', [RolController::class, 'vistaMostrar']);
Route::delete('/roles/borrar', [RolController::class, 'borrar']);

Route::get('/usuarios/listar', [UserController::class, 'listar']);
Route::get('/usuarios/crear', [UserController::class, 'vistaFormulario']);
Route::post('/usuarios/guardar', [UserController::class, 'registrar']);
Route::get('/usuarios/editar', [UserController::class, 'vistaEdicion']);
Route::put('/usuarios/actualizar', [UserController::class, 'actualizar']);
Route::get('/usuarios/mostrar', [UserController::class, 'vistaMostrar']);
Route::delete('/usuarios/borrar', [UserController::class, 'borrar']);
