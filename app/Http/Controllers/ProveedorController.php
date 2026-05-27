<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Listar todos los proveedores.
     */
    public function index(Request $request)
    {
        $query = Proveedor::withCount('productos');

        if ($request->filled('buscar')) {
            $query->where(function ($q) use ($request) {
                $q->where('nombre', 'like', "%{$request->buscar}%")
                  ->orWhere('contacto', 'like', "%{$request->buscar}%")
                  ->orWhere('email', 'like', "%{$request->buscar}%");
            });
        }

        $proveedores = $query->latest()->paginate(10);
        return view('proveedores.index', compact('proveedores'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        return view('proveedores.create');
    }

    /**
     * Guardar nuevo proveedor.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'contacto' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'direccion' => 'nullable|string',
            'ciudad' => 'nullable|string|max:80',
            'estado' => 'nullable|string|max:80',
            'codigo_postal' => 'nullable|string|max:10',
            'rfc' => 'nullable|string|max:13',
            'activo' => 'boolean',
        ]);

        $validated['activo'] = $request->has('activo');

        Proveedor::create($validated);

        return redirect()->route('admin.proveedores.index')
            ->with('success', 'Proveedor registrado exitosamente.');
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Proveedor $proveedore)
    {
        return view('proveedores.edit', ['proveedor' => $proveedore]);
    }

    /**
     * Actualizar proveedor.
     */
    public function update(Request $request, Proveedor $proveedore)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'contacto' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'direccion' => 'nullable|string',
            'ciudad' => 'nullable|string|max:80',
            'estado' => 'nullable|string|max:80',
            'codigo_postal' => 'nullable|string|max:10',
            'rfc' => 'nullable|string|max:13',
            'activo' => 'boolean',
        ]);

        $validated['activo'] = $request->has('activo');

        $proveedore->update($validated);

        return redirect()->route('admin.proveedores.index')
            ->with('success', 'Proveedor actualizado exitosamente.');
    }

    /**
     * Eliminar proveedor.
     */
    public function destroy(Proveedor $proveedore)
    {
        $proveedore->delete();

        return redirect()->route('admin.proveedores.index')
            ->with('success', 'Proveedor eliminado exitosamente.');
    }
}
