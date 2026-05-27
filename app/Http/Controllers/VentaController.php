<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Pedido;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    /**
     * Listar todas las ventas.
     */
    public function index(Request $request)
    {
        $query = Venta::with(['cliente', 'vendedor']);

        if ($request->filled('buscar')) {
            $query->where(function ($q) use ($request) {
                $q->where('folio', 'like', "%{$request->buscar}%")
                  ->orWhereHas('cliente', function ($q2) use ($request) {
                      $q2->where('nombre', 'like', "%{$request->buscar}%")
                         ->orWhere('apellidos', 'like', "%{$request->buscar}%");
                  });
            });
        }

        if ($request->filled('estado_pago')) {
            $query->where('estado_pago', $request->estado_pago);
        }

        $ventas = $query->latest()->paginate(10);

        $totalVentas = Venta::pagadas()->sum('total');
        $ventasHoy = Venta::hoy()->pagadas()->sum('total');

        return view('ventas.index', compact('ventas', 'totalVentas', 'ventasHoy'));
    }

    /**
     * Crear venta desde un pedido entregado.
     */
    public function crearDesdePedido(Pedido $pedido)
    {
        if ($pedido->venta) {
            return redirect()->route('ventas.index')
                ->with('error', 'Este pedido ya tiene una venta asociada.');
        }

        $venta = Venta::create([
            'pedido_id' => $pedido->id,
            'cliente_id' => $pedido->cliente_id,
            'user_id' => auth()->id(),
            'subtotal' => $pedido->subtotal,
            'iva' => $pedido->iva,
            'descuento' => $pedido->descuento,
            'total' => $pedido->total,
            'metodo_pago' => $pedido->metodo_pago,
            'estado_pago' => 'pagado',
        ]);

        return redirect()->route('ventas.index')
            ->with('success', "Venta {$venta->folio} registrada exitosamente.");
    }

    /**
     * Mostrar detalle de la venta.
     */
    public function show(Venta $venta)
    {
        $venta->load(['cliente', 'vendedor', 'pedido.detalles.producto']);
        return view('ventas.show', compact('venta'));
    }
}
