@extends('layouts.admin')
@section('title', 'Proveedores')
@section('actions')
    <a href="{{ route('admin.proveedores.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nuevo Proveedor</a>
@endsection

@section('content')
    <form method="GET" class="search-bar">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar proveedor..." value="{{ request('buscar') }}">
        <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i> Buscar</button>
    </form>

    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Contacto</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Productos</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($proveedores as $prov)
                        <tr>
                            <td><strong>{{ $prov->nombre }}</strong></td>
                            <td>{{ $prov->contacto ?? '—' }}</td>
                            <td>{{ $prov->telefono ?? '—' }}</td>
                            <td>{{ $prov->email ?? '—' }}</td>
                            <td><span class="badge badge-info">{{ $prov->productos_count }}</span></td>
                            <td>
                                @if($prov->activo)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <div style="display:flex;gap:6px">
                                    <a href="{{ route('admin.proveedores.edit', $prov) }}" class="btn btn-secondary btn-icon btn-sm"><i class="fas fa-pen"></i></a>
                                    <form action="{{ route('admin.proveedores.destroy', $prov) }}" method="POST" onsubmit="return confirm('¿Eliminar este proveedor?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-icon btn-sm"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7">
                            <div class="empty-state"><i class="fas fa-truck"></i><h4>Sin proveedores</h4></div>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="pagination-wrapper">{{ $proveedores->withQueryString()->links() }}</div>
@endsection
