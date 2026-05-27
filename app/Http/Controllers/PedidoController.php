<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\DetallePedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    /**
     * Listar todos los pedidos.
     */
    public function index(Request $request)
    {
        $query = Pedido::with(['cliente', 'vendedor']);

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('buscar')) {
            $query->where(function ($q) use ($request) {
                $q->where('numero_pedido', 'like', "%{$request->buscar}%")
                  ->orWhereHas('cliente', function ($q2) use ($request) {
                      $q2->where('nombre', 'like', "%{$request->buscar}%")
                         ->orWhere('apellidos', 'like', "%{$request->buscar}%");
                  });
            });
        }

        $pedidos = $query->latest()->paginate(10);
        return view('pedidos.index', compact('pedidos'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $productos = Producto::activos()->where('stock', '>', 0)->orderBy('nombre')->get();
        return view('pedidos.create', compact('clientes', 'productos'));
    }

    /**
     * Guardar nuevo pedido.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'metodo_pago' => 'required|in:efectivo,tarjeta,transferencia,credito',
            'direccion_envio' => 'nullable|string',
            'notas' => 'nullable|string',
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $subtotal = 0;
            $detalles = [];

            foreach ($validated['productos'] as $item) {
                $producto = Producto::findOrFail($item['id']);
                
                if ($producto->stock < $item['cantidad']) {
                    throw new \Exception("Stock insuficiente para: {$producto->nombre}");
                }

                $precioUnitario = $producto->precio_final;
                $subtotalItem = $precioUnitario * $item['cantidad'];
                $subtotal += $subtotalItem;

                $detalles[] = [
                    'producto_id' => $producto->id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $precioUnitario,
                    'subtotal' => $subtotalItem,
                ];

                // Descontar stock
                $producto->decrement('stock', $item['cantidad']);
            }

            $iva = $subtotal * 0.16;
            $total = $subtotal + $iva;

            $pedido = Pedido::create([
                'cliente_id' => $validated['cliente_id'],
                'user_id' => auth()->id(),
                'subtotal' => $subtotal,
                'iva' => $iva,
                'total' => $total,
                'metodo_pago' => $validated['metodo_pago'],
                'direccion_envio' => $validated['direccion_envio'] ?? null,
                'notas' => $validated['notas'] ?? null,
            ]);

            foreach ($detalles as $detalle) {
                $pedido->detalles()->create($detalle);
            }

            DB::commit();

            return redirect()->route('admin.pedidos.show', $pedido)
                ->with('success', "Pedido {$pedido->numero_pedido} creado exitosamente.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Mostrar detalle del pedido.
     */
    public function show(Pedido $pedido)
    {
        $pedido->load(['cliente', 'vendedor', 'detalles.producto']);
        return view('pedidos.show', compact('pedido'));
    }

    /**
     * Actualizar estado del pedido.
     */
    public function updateEstado(Request $request, Pedido $pedido)
    {
        $validated = $request->validate([
            'estado' => 'required|in:pendiente,confirmado,en_proceso,enviado,entregado,cancelado',
        ]);

        $pedido->update($validated);

        return redirect()->route('admin.pedidos.show', $pedido)
            ->with('success', 'Estado del pedido actualizado.');
    }

    /**
     * Eliminar pedido.
     */
    public function destroy(Pedido $pedido)
    {
        // Restaurar stock
        foreach ($pedido->detalles as $detalle) {
            $detalle->producto->increment('stock', $detalle->cantidad);
        }

        $pedido->delete();

        return redirect()->route('admin.pedidos.index')
            ->with('success', 'Pedido eliminado exitosamente.');
    }
}
