<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('public.carrito', compact('cart'));
    }

    public function add(Request $request, Producto $producto)
    {
        $cart = session()->get('cart', []);
        
        $cart[] = [
            'id' => $producto->id,
            'nombre' => $producto->nombre,
            'precio' => $producto->precio_final,
            'imagen' => $producto->imagen_principal
        ];
        
        session()->put('cart', $cart);
        
        return back()->with('success', 'Producto agregado al carrito.');
    }

    public function remove($index)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$index])) {
            unset($cart[$index]);
            session()->put('cart', array_values($cart)); // Reindex
        }
        
        return back()->with('success', 'Producto eliminado del carrito.');
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'El carrito está vacío.');
        }

        $user = auth()->user();
        $cliente = Cliente::where('user_id', $user->id)->first();
        
        if (!$cliente) {
            return back()->with('error', 'No se encontró tu perfil de cliente.');
        }

        DB::beginTransaction();
        try {
            // Calcular total
            $total = collect($cart)->sum('precio');

            // Crear el pedido
            $pedido = Pedido::create([
                'cliente_id' => $cliente->id,
                'numero_pedido' => 'PED-' . strtoupper(uniqid()),
                'total' => $total,
                'estado' => 'pendiente',
                'direccion_envio' => $request->direccion ?? 'A coordinar',
                'notas' => 'Metodo de pago preferido: ' . $request->metodo_pago,
            ]);

            // Crear detalles
            // Agrupamos por id para manejar cantidades
            $itemsGrouped = collect($cart)->groupBy('id');
            foreach ($itemsGrouped as $prodId => $items) {
                $cantidad = $items->count();
                $precio = $items->first()['precio'];
                
                DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $prodId,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precio,
                    'subtotal' => $cantidad * $precio,
                ]);
            }

            // Limpiar carrito
            session()->forget('cart');

            DB::commit();
            return redirect()->route('mi-cuenta')->with('success', '¡Pedido realizado con éxito! Nos contactaremos pronto.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un error al procesar tu pedido. Intenta nuevamente.');
        }
    }
}
