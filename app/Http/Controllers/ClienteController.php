<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Listar todos los clientes.
     */
    public function index(Request $request)
    {
        $query = Cliente::query();

        if ($request->filled('buscar')) {
            $query->where(function ($q) use ($request) {
                $q->where('nombre', 'like', "%{$request->buscar}%")
                  ->orWhere('apellidos', 'like', "%{$request->buscar}%")
                  ->orWhere('email', 'like', "%{$request->buscar}%")
                  ->orWhere('telefono', 'like', "%{$request->buscar}%");
            });
        }

        $clientes = $query->latest()->paginate(10);
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Guardar nuevo cliente.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'email' => 'required|email|max:100',
            'direccion' => 'nullable|string',
            'colonia' => 'nullable|string|max:100',
            'ciudad' => 'nullable|string|max:80',
            'estado' => 'nullable|string|max:80',
            'codigo_postal' => 'nullable|string|max:10',
            'rfc' => 'nullable|string|max:13',
        ]);

        Cliente::create($validated);

        return redirect()->route('admin.clientes.index')
            ->with('success', 'Cliente registrado exitosamente.');
    }

    /**
     * Mostrar detalle del cliente.
     */
    public function show(Cliente $cliente)
    {
        $cliente->load(['pedidos' => function ($q) {
            $q->latest()->take(10);
        }, 'ventas' => function ($q) {
            $q->latest()->take(10);
        }]);

        return view('clientes.show', compact('cliente'));
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Actualizar cliente.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'email' => 'required|email|max:100',
            'direccion' => 'nullable|string',
            'colonia' => 'nullable|string|max:100',
            'ciudad' => 'nullable|string|max:80',
            'estado' => 'nullable|string|max:80',
            'codigo_postal' => 'nullable|string|max:10',
            'rfc' => 'nullable|string|max:13',
        ]);

        $cliente->update($validated);

        return redirect()->route('admin.clientes.index')
            ->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Eliminar cliente.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('admin.clientes.index')
            ->with('success', 'Cliente eliminado exitosamente.');
    }
}
