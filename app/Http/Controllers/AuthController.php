<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function registerClient(Request $request)
    {
        // Validar los datos
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255|unique:clientes',
            'contraseña' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Crear el cliente
        $client = Cliente::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'contraseña' => Hash::make($request->contraseña),
        ]);

        return response()->json([
            'message' => 'Cliente registrado exitosamente',
            'client' => $client
        ], 201);
    }


    public function loginClient(Request $request)
    {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'correo' => 'required|email',
            'contraseña' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Buscar el cliente por email
        $client = Cliente::where('correo', $request->correo)->first();

        // Verificar la contraseña
        if (!$client || !Hash::check($request->contraseña, $client->contraseña)) {
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }

        // Generar token de sesión (si usas Laravel Sanctum o JWT, puedes mejorarlo)
        $token = bin2hex(random_bytes(40));

        return response()->json([
            'message' => 'Login exitoso',
            'client' => $client,
            'token' => $token,
        ], 200);
    }
}
