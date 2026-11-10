<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CrudController;
use Illuminate\Support\Facades\Route;

// Ruta pública para iniciar sesión
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas: requieren un token de administrador
Route::middleware('auth:admin_api')->group(function () {

    // Autenticación
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Operaciones CRUD protegidas
    Route::name('api.')->group(function () {
        Route::apiResource('roles', CrudController::class);
        Route::apiResource('administradores', CrudController::class);
        Route::apiResource('categorias', CrudController::class);
        Route::apiResource('presentaciones', CrudController::class);
        Route::apiResource('marcas', CrudController::class);
        Route::apiResource('productos', CrudController::class);
        Route::apiResource('clientes', CrudController::class);
        Route::apiResource('direcciones', CrudController::class);
        Route::apiResource('metodos-pago', CrudController::class);
        Route::apiResource('pedidos', CrudController::class);
        Route::apiResource('productos-pedido', CrudController::class);
        Route::apiResource('repartidores', CrudController::class);
        Route::apiResource('proveedores', CrudController::class);
        Route::apiResource('entregas', CrudController::class);
        Route::apiResource('usuarios', CrudController::class);
    });
});
