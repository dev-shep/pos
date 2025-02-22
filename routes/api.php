<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VendedorAuthController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CompraController;

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

//crear carrito No es necesario enviar datos en el cuerpo de la solicitud (body), ya que estamos creando el carrito usando solo el clienteId
//http://localhost:8000/api/cart/1
Route::post('/cart/{clienteId}', [CarritoController::class, 'createCart']);


//PUT http://localhost:8000/api/cart/1/add-product
Route::put('/cart/{cartId}/add-product', [CarritoController::class, 'addProductToCart']);

//PUT http://localhost:8000/api/cart/1/remove-product
Route::put('/cart/{cartId}/remove-product', [CarritoController::class, 'removeProductFromCart']);

//POST http://localhost:8000/api/cart/1/checkout
Route::post('/cart/{cartId}/checkout', [CarritoController::class, 'checkout']);

//GET http://localhost:8000/api/purchase-history/1
Route::get('/purchase-history/{clientId}', [CompraController::class, 'getPurchaseHistory']);

//GET http://localhost:8000/api/sales-history/1
Route::get('/sales-history/{storeId}', [TiendaController::class, 'getSalesHistory']);
