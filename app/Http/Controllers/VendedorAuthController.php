<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Vendedor;

class VendedorAuthController extends Controller
{
    public function registerVendedor(Request $request)
    {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255|unique:vendedores',
            'contraseña' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Crear el vendedor
        $vendedor = Vendedor::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'contraseña' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Vendedor registrado exitosamente',
            'vendedor' => $vendedor
        ], 201);
    }


    public function loginVendor(Request $request)
    {   
        // Validar datos de entrada
        $validator = Validator::make($request->all(), [
            'correo' => 'required|email',
            'contraseña' => 'required|string|min:6',
        ]);
  
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        // Buscar vendedor por email
        $vendedor = Vendedor::where('correo', $request->correo)->first();

        // Verificar la contraseña
        if (!$vendedor || !Hash::check($request->contraseña, $vendedor->contraseña)) {
            
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }

        // Generar token de autenticación
         $token = bin2hex(random_bytes(40));

        return response()->json([
            'message' => 'Login exitoso',
            'vendedor' => $vendedor,
            'token' => $token,
        ], 200);
    }
}
