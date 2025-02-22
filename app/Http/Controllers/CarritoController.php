<?php

namespace App\Http\Controllers;
use App\Models\Carrito;
use App\Models\Producto;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ProductoController;
class CarritoController extends Controller
{
    // Método para crear un carrito para un cliente
    public function createCart(Request $request, $clienteId)
    {
        // Validar si el cliente existe
        
        $cliente = Cliente::find($clienteId);

        if (!$cliente) {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        // Crear el carrito
        $carrito = Carrito::create([
            'cliente_id' => $clienteId,
            'estado' => 'pendiente',  // El carrito inicia como pendiente
        ]);

        return response()->json([
            'message' => 'Carrito creado exitosamente',
            'carrito' => $carrito
        ], 201);
    }

    // Método para agregar un producto al carrito
    public function addProductToCart(Request $request, $cartId)
    {


        // Validar si el carrito existe
        $carrito = Carrito::find($cartId);

        if (!$carrito) {
            return response()->json(['error' => 'Carrito no encontrado'], 404);
        }

        // Validar si el producto existe
        $producto = Producto::find($request->producto_id);

        if (!$producto) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        // Validar si la cantidad es válida
        $validator = Validator::make($request->all(), [
            'cantidad' => 'required|integer|min:1|max:' . $producto->stock, // La cantidad no puede exceder el stock disponible
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Agregar el producto al carrito
        $carrito->productos()->attach($producto->id, [
            'cantidad' => $request->cantidad,
            'precio' => $producto->precio,
            'compra_id' => $cartId, 
        ]);

        return response()->json([
            'message' => 'Producto agregado al carrito exitosamente',
            'carrito' => $carrito->load('productos') // Retorna el carrito con los productos
        ], 200);
    }
    
    
    // Método para eliminar un producto del carrito
    public function removeProductFromCart($cartId, Request $request)
    {
        // Validar si el carrito existe
        $carrito = Carrito::find($cartId);

        if (!$carrito) {
            return response()->json(['error' => 'Carrito no encontrado'], 404);
        }

        // Validar si el producto existe en el carrito
        $producto = Producto::find($request->producto_id);

        if (!$producto) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        // Verificar si el producto está en el carrito
        if (!$carrito->productos->contains($producto->id)) {
            return response()->json(['error' => 'El producto no está en el carrito'], 400);
        }

        // Eliminar el producto del carrito
        $carrito->productos()->detach($producto->id);

        return response()->json([
            'message' => 'Producto eliminado del carrito exitosamente',
            'carrito' => $carrito->load('productos') // Retorna el carrito con los productos restantes
        ], 200);
    }


    // Método para finalizar la compra y descontar el stock
    public function checkout($cartId, Request $request)
    {
        // Validar si el carrito existe
        $carrito = Carrito::find($cartId);

        if (!$carrito) {
            return response()->json(['error' => 'Carrito no encontrado'], 404);
        }

        // Verificar si el carrito está vacío
        if ($carrito->productos->isEmpty()) {
            return response()->json(['error' => 'El carrito está vacío'], 400);
        }

        // Validar si hay stock suficiente para cada producto
        foreach ($carrito->productos as $producto) {
            if ($producto->pivot->cantidad > $producto->stock) {
                return response()->json([
                    'error' => 'Stock insuficiente para el producto: ' . $producto->nombre
                ], 400);
            }
        }

        // Comenzar la transacción para asegurar que se descuente el stock correctamente
        DB::beginTransaction();

        try {
            // Crear una nueva compra para el cliente
            $compra = Compra::create([
                'cliente_id' => $carrito->cliente_id,
                'total' => $carrito->productos->sum(function ($producto) {
                    return $producto->precio * $producto->pivot->cantidad;
                }),
            ]);

            // Descontar el stock de los productos y registrar la compra de cada uno
            foreach ($carrito->productos as $producto) {
                $producto->stock -= $producto->pivot->cantidad;
                $producto->save();

                // Registrar la venta en la tabla de ventas (historial de compras)
                $compra->productos()->attach($producto->id, [
                    'cantidad' => $producto->pivot->cantidad,
                    'precio' => $producto->precio,
                ]);
            }

            // Eliminar el carrito después de la compra
            $carrito->productos()->detach();

            // Confirmar la transacción
            DB::commit();

            return response()->json([
                'message' => 'Compra realizada exitosamente',
                'compra' => $compra
            ], 200);
        } catch (\Exception $e) {
            // Si algo falla, revertir la transacción
            DB::rollBack();
            return response()->json(['error' => 'Hubo un error al procesar la compra'], 500);
        }
    }
}
