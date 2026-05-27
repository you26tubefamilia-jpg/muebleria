<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas Públicas (Tienda)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $categorias = \App\Models\Categoria::activas()->withCount('productos')->get();
    $productosDestacados = \App\Models\Producto::activos()->destacados()->with('categoria')->take(4)->get();
    return view('welcome', compact('categorias', 'productosDestacados'));
})->name('inicio');

Route::get('/catalogo', function (\Illuminate\Http\Request $request) {
    $query = \App\Models\Producto::activos()->with('categoria')->orderBy('created_at', 'desc');
    
    if ($request->has('categoria')) {
        $query->where('categoria_id', $request->categoria);
    }
    
    $productos = $query->paginate(12)->withQueryString();
    $categorias = \App\Models\Categoria::activas()->get();
    
    return view('public.catalogo', compact('productos', 'categorias'));
})->name('catalogo');

/*
|--------------------------------------------------------------------------
| Carrito y Compras
|--------------------------------------------------------------------------
*/
Route::get('/carrito', [\App\Http\Controllers\CartController::class, 'index'])->name('carrito');
Route::post('/carrito/add/{producto}', [\App\Http\Controllers\CartController::class, 'add'])->name('carrito.add');
Route::post('/carrito/remove/{index}', [\App\Http\Controllers\CartController::class, 'remove'])->name('carrito.remove');
Route::post('/carrito/checkout', [\App\Http\Controllers\CartController::class, 'checkout'])->name('carrito.checkout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Perfil de Cliente
|--------------------------------------------------------------------------
*/
Route::get('/mi-cuenta', function () {
    $user = auth()->user();
    if ($user->esAdmin() || $user->esVendedor()) return redirect()->route('admin.dashboard');
    
    $cliente = \App\Models\Cliente::where('user_id', $user->id)->first();
    $pedidos = $cliente ? \App\Models\Pedido::where('cliente_id', $cliente->id)->orderBy('created_at', 'desc')->get() : collect();
    
    return view('public.mi-cuenta', compact('cliente', 'pedidos'));
})->name('mi-cuenta')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Rutas de Autenticación (Breeze)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Rutas del Panel de Administración (Protegidas)
|--------------------------------------------------------------------------
| Requieren: autenticación + rol admin/vendedor
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // CRUD Resources
        Route::resource('categorias', CategoriaController::class)->except(['show']);
        Route::resource('productos', ProductoController::class);
        Route::resource('clientes', ClienteController::class);
        Route::resource('pedidos', PedidoController::class)->except(['edit', 'update']);
        Route::resource('proveedores', ProveedorController::class)->except(['show']);
        Route::resource('ventas', VentaController::class)->only(['index', 'show']);

        // Acciones especiales
        Route::patch('pedidos/{pedido}/estado', [PedidoController::class, 'updateEstado'])->name('pedidos.updateEstado');
        Route::post('ventas/pedido/{pedido}', [VentaController::class, 'crearDesdePedido'])->name('ventas.crearDesdePedido');
    });

require __DIR__.'/auth.php';
