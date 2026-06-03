<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductoController extends Controller
{
    /**
     * Listar todos los productos.
     */
    public function index(Request $request)
    {
        $query = Producto::with(['categoria', 'proveedor']);

        // Filtro por búsqueda
        if ($request->filled('buscar')) {
            $query->where(function ($q) use ($request) {
                $q->where('nombre', 'like', "%{$request->buscar}%")
                  ->orWhere('sku', 'like', "%{$request->buscar}%");
            });
        }

        // Filtro por categoría
        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        // Filtro por estado
        if ($request->filled('activo')) {
            $query->where('activo', $request->activo);
        }

        $productos = $query->latest()->paginate(12);
        $categorias = Categoria::activas()->orderBy('nombre')->get();

        return view('productos.index', compact('productos', 'categorias'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        $categorias = Categoria::activas()->orderBy('nombre')->get();
        $proveedores = Proveedor::activos()->orderBy('nombre')->get();
        return view('productos.create', compact('categorias', 'proveedores'));
    }

    /**
     * Guardar nuevo producto.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'descripcion_corta' => 'nullable|string|max:500',
            'precio' => 'required|numeric|min:0',
            'precio_oferta' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:50|unique:productos,sku',
            'imagen_principal' => 'nullable|image|max:2048',
            'material' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:50',
            'dimensiones' => 'nullable|string|max:100',
            'peso' => 'nullable|numeric|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'proveedor_id' => 'nullable|exists:proveedores,id',
            'destacado' => 'boolean',
            'activo' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['nombre']);
        $validated['destacado'] = $request->has('destacado');
        $validated['activo'] = $request->has('activo');

        if ($request->hasFile('imagen_principal')) {
            try {
                $baserow = new \App\Services\BaserowService();
                $validated['imagen_principal'] = $baserow->uploadFile($request->file('imagen_principal'));
            } catch (\Exception $e) {
                return back()->withErrors(['imagen_principal' => $e->getMessage()])->withInput();
            }
        }

        Producto::create($validated);

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Mostrar detalle del producto.
     */
    public function show(Producto $producto)
    {
        $producto->load(['categoria', 'proveedor', 'imagenes']);
        return view('productos.show', compact('producto'));
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Producto $producto)
    {
        $categorias = Categoria::activas()->orderBy('nombre')->get();
        $proveedores = Proveedor::activos()->orderBy('nombre')->get();
        return view('productos.edit', compact('producto', 'categorias', 'proveedores'));
    }

    /**
     * Actualizar producto.
     */
    public function update(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'descripcion_corta' => 'nullable|string|max:500',
            'precio' => 'required|numeric|min:0',
            'precio_oferta' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:50|unique:productos,sku,' . $producto->id,
            'imagen_principal' => 'nullable|image|max:2048',
            'material' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:50',
            'dimensiones' => 'nullable|string|max:100',
            'peso' => 'nullable|numeric|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'proveedor_id' => 'nullable|exists:proveedores,id',
            'destacado' => 'boolean',
            'activo' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['nombre']);
        $validated['destacado'] = $request->has('destacado');
        $validated['activo'] = $request->has('activo');

        if ($request->hasFile('imagen_principal')) {
            if ($producto->imagen_principal && !\Illuminate\Support\Str::startsWith($producto->imagen_principal, ['http://', 'https://'])) {
                Storage::disk('public')->delete($producto->imagen_principal);
            }
            try {
                $baserow = new \App\Services\BaserowService();
                $validated['imagen_principal'] = $baserow->uploadFile($request->file('imagen_principal'));
            } catch (\Exception $e) {
                return back()->withErrors(['imagen_principal' => $e->getMessage()])->withInput();
            }
        }

        $producto->update($validated);

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Eliminar producto.
     */
    public function destroy(Producto $producto)
    {
        if ($producto->imagen_principal && !\Illuminate\Support\Str::startsWith($producto->imagen_principal, ['http://', 'https://'])) {
            Storage::disk('public')->delete($producto->imagen_principal);
        }

        $producto->delete();

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }
}
