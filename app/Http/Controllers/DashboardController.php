<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Pedido;
use App\Models\Venta;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Mostrar el dashboard principal.
     */
    public function index()
    {
        $totalProductos = Producto::count();
        $productosActivos = Producto::activos()->count();
        $totalCategorias = Categoria::count();
        $pedidosPendientes = Pedido::pendientes()->count();
        $ventasHoy = Venta::hoy()->pagadas()->sum('total');
        $ventasMes = Venta::pagadas()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');
        
        $ultimosPedidos = Pedido::with('cliente')
            ->latest()
            ->take(5)
            ->get();

        $ultimasVentas = Venta::with('cliente')
            ->latest()
            ->take(5)
            ->get();

        $productosPocoStock = Producto::activos()
            ->where('stock', '<=', 5)
            ->orderBy('stock')
            ->take(10)
            ->get();

        return view('dashboard', compact(
            'totalProductos',
            'productosActivos',
            'totalCategorias',
            'pedidosPendientes',
            'ventasHoy',
            'ventasMes',
            'ultimosPedidos',
            'ultimasVentas',
            'productosPocoStock'
        ));
    }
}
