<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\Cliente;

class CompraController extends Controller
{
    // Obtener el historial de compras de un cliente
    public function getPurchaseHistory($clientId)
    {
        // Validar si el cliente existe
        $cliente = Cliente::find($clientId);
        if (!$cliente) {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        // Obtener todas las compras del cliente con los productos comprados
        $compras = Compra::where('cliente_id', $clientId)
                    ->with('productos') // Cargar los productos relacionados
                    ->orderBy('created_at', 'desc')
                    ->get();

        // Verificar si el cliente tiene compras
        if ($compras->isEmpty()) {
            return response()->json(['message' => 'No hay compras registradas para este cliente'], 200);
        }

        return response()->json([
            'message' => 'Historial de compras obtenido exitosamente',
            'compras' => $compras
        ], 200);
    }
}
