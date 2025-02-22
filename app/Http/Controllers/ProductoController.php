<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    // Método para crear un producto
    public function createProduct(Request $request)
    {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'tienda_id' => 'required|exists:tiendas,id',  // Validar que la tienda exista
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Crear el producto
        $producto = Producto::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'tienda_id' => $request->tienda_id,
        ]);

        return response()->json([
            'message' => 'Producto creado exitosamente',
            'producto' => $producto
        ], 201);
    }

        // Método para actualizar un producto por su ID
        public function updateProduct(Request $request, $id)
        {
            // Validar los datos de entrada
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255',
                'precio' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'tienda_id' => 'required|exists:tiendas,id',  // Validar que la tienda exista
            ]);
    
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
    
            // Buscar el producto por ID
            $producto = Producto::find($id);
    
            // Si el producto no existe, retornar un error
            if (!$producto) {
                return response()->json(['error' => 'Producto no encontrado'], 404);
            }
    
            // Actualizar los datos del producto
            $producto->update([
                'nombre' => $request->nombre,
                'precio' => $request->precio,
                'stock' => $request->stock,
                'tienda_id' => $request->tienda_id,
            ]);
    
            return response()->json([
                'message' => 'Producto actualizado exitosamente',
                'producto' => $producto
            ], 200);
        }

        // Método para eliminar un producto por su ID
        public function deleteProduct($id)
        {
            // Buscar el producto por ID
            $producto = Producto::find($id);

            // Si el producto no existe, retornar un error
            if (!$producto) {
                return response()->json(['error' => 'Producto no encontrado'], 404);
            }

            // Eliminar el producto
            $producto->delete();

            return response()->json([
                'message' => 'Producto eliminado exitosamente'
            ], 200);
        }

}
