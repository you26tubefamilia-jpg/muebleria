@extends('layouts.admin')
@section('title', 'Categorías')
@section('actions')
    <a href="{{ route('admin.categorias.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nueva Categoría</a>
@endsection

@section('content')
    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Productos</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categorias as $cat)
                        <tr>
                            <td>{{ $cat->id }}</td>
                            <td><strong>{{ $cat->nombre }}</strong></td>
                            <td>{{ Str::limit($cat->descripcion, 60) }}</td>
                            <td><span class="badge badge-info">{{ $cat->productos_count }}</span></td>
                            <td>
                                @if($cat->activo)
                                    <span class="badge badge-success">Activa</span>
                                @else
                                    <span class="badge badge-danger">Inactiva</span>
                                @endif
                            </td>
                            <td>
                                <div style="display:flex;gap:6px">
                                    <a href="{{ route('admin.categorias.edit', $cat) }}" class="btn btn-secondary btn-icon btn-sm" title="Editar"><i class="fas fa-pen"></i></a>
                                    <form action="{{ route('admin.categorias.destroy', $cat) }}" method="POST" onsubmit="return confirm('¿Eliminar esta categoría?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-icon btn-sm" title="Eliminar"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-tags"></i>
                                <h4>Sin categorías</h4>
                                <p>Crea tu primera categoría para organizar los productos.</p>
                            </div>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="pagination-wrapper">{{ $categorias->links() }}</div>
@endsection
