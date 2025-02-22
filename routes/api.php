<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VendedorAuthController;

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
