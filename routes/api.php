<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VendedorAuthController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\ProductoController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//http://localhost:8000/api/register/client
Route::post('/register/client', [AuthController::class, 'registerClient']);

//http://localhost:8000/api/login/client
Route::post('/login/client', [AuthController::class, 'loginClient']);

//http://localhost:8000/api/register/vendor
Route::post('/register/vendor', [VendedorAuthController::class, 'registerVendedor']);


//http://localhost:8000/api/login/vendor
Route::post('/login/vendor', [VendedorAuthController::class, 'loginVendor']);

//http://localhost:8000/api/store
Route::post('/store', [TiendaController::class, 'createStore']);

// obtener una tienda por su ID.
//GET http://localhost:8000/api/store/1
Route::get('/store/{id}', [TiendaController::class, 'getStoreById']);

// enviar la petición PUT con los datos actualizados de la tienda.
//PUT http://localhost:8000/api/store/1
Route::put('/store/{id}', [TiendaController::class, 'updateStore']);


// enviar la petición DELETE
//DELETE http://localhost:8000/api/store/1
Route::delete('/store/{id}', [TiendaController::class, 'deleteStore']);

//http://localhost:8000/api/product
Route::post('/product', [ProductoController::class, 'createProduct']);

//PUT http://localhost:8000/api/product/1
Route::put('/product/{id}', [ProductoController::class, 'updateProduct']);

//DELETE http://localhost:8000/api/product/1
Route::delete('/product/{id}', [ProductoController::class, 'deleteProduct']);

