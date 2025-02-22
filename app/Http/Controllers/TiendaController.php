<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tienda;
use Illuminate\Support\Facades\Validator;


class TiendaController extends Controller
{
    public function createStore(Request $request)
    {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'vendedor_id' => 'required|exists:vendedores,id',  // Validar que el vendedor exista
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Crear la tienda
        $tienda = Tienda::create([
            'nombre' => $request->nombre,
            'vendedor_id' => $request->vendedor_id,
        ]);

        return response()->json([
            'message' => 'Tienda creada exitosamente',
            'tienda' => $tienda
        ], 201);
    }
    // Método para obtener una tienda por su ID
    public function getStoreById($id)
    {
        // Buscar la tienda por ID
        $tienda = Tienda::find($id);

        // Si la tienda no existe, retornar un error
        if (!$tienda) {
            return response()->json(['error' => 'Tienda no encontrada'], 404);
        }

        // Retornar la tienda encontrada
        return response()->json([
            'tienda' => $tienda
        ], 200);
    }


        // Método para actualizar una tienda por su ID
        public function updateStore(Request $request, $id)
        {
            // Validar los datos de entrada
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255',
                'vendedor_id' => 'required|exists:vendedores,id',  // Asegurarse de que el vendedor exista
            ]);
    
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
    
            // Buscar la tienda por ID
            $tienda = Tienda::find($id);
    
            // Si la tienda no existe, retornar un error
            if (!$tienda) {
                return response()->json(['error' => 'Tienda no encontrada'], 404);
            }
    
            // Actualizar los datos de la tienda
            $tienda->update([
                'nombre' => $request->nombre,
                'vendedor_id' => $request->vendedor_id,
            ]);
    
            return response()->json([
                'message' => 'Tienda actualizada exitosamente',
                'tienda' => $tienda
            ], 200);
        }

         // Método para eliminar una tienda por su ID
    public function deleteStore($id)
    {
        // Buscar la tienda por ID
        $tienda = Tienda::find($id);

        // Si la tienda no existe, retornar un error
        if (!$tienda) {
            return response()->json(['error' => 'Tienda no encontrada'], 404);
        }

        // Eliminar la tienda
        $tienda->delete();

        return response()->json([
            'message' => 'Tienda eliminada exitosamente'
        ], 200);
    }
    
    // Obtener el historial de ventas de una tienda
    public function getSalesHistory($storeId)
    {
        // Validar si la tienda existe
        $tienda = Tienda::find($storeId);
        if (!$tienda) {
            return response()->json(['error' => 'Tienda no encontrada'], 404);
        }

        // Obtener todas las compras que incluyeron productos de esta tienda
        $compras = Compra::whereHas('productos', function ($query) use ($storeId) {
                        $query->where('tienda_id', $storeId);
                    })
                    ->with(['productos' => function ($query) use ($storeId) {
                        $query->where('tienda_id', $storeId);
                    }])
                    ->orderBy('created_at', 'desc')
                    ->get();

        // Verificar si hay ventas
        if ($compras->isEmpty()) {
            return response()->json(['message' => 'No hay ventas registradas para esta tienda'], 200);
        }

        return response()->json([
            'message' => 'Historial de ventas obtenido exitosamente',
            'ventas' => $compras
        ], 200);
    }
}
