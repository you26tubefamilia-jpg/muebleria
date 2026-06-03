@extends('layouts.admin')
@section('title', 'Productos')
@section('actions')
    <a href="{{ route('admin.productos.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nuevo Producto</a>
@endsection

@section('content')
    <!-- Filtros -->
    <form method="GET" class="search-bar">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar por nombre o SKU..." value="{{ request('buscar') }}">
        <select name="categoria_id" class="form-control" style="max-width:200px">
            <option value="">Todas las categorías</option>
            @foreach($categorias as $cat)
                <option value="{{ $cat->id }}" {{ request('categoria_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
            @endforeach
        </select>
        <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i> Filtrar</button>
        @if(request()->hasAny(['buscar','categoria_id']))
            <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary btn-sm">Limpiar</a>
        @endif
    </form>

    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>SKU</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productos as $prod)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px">
                                    @if($prod->imagen_principal)
                                        <img src="{{ $prod->imagen_url }}" alt="" style="width:40px;height:40px;border-radius:8px;object-fit:cover">
                                    @else
                                        <div style="width:40px;height:40px;border-radius:8px;background:var(--bg-hover);display:flex;align-items:center;justify-content:center;color:var(--text-muted)"><i class="fas fa-image"></i></div>
                                    @endif
                                    <div>
                                        <strong>{{ $prod->nombre }}</strong>
                                        @if($prod->destacado) <i class="fas fa-star" style="color:var(--warning);font-size:11px" title="Destacado"></i> @endif
                                    </div>
                                </div>
                            </td>
                            <td style="font-family:monospace;font-size:12px">{{ $prod->sku ?? '—' }}</td>
                            <td><span class="badge badge-default">{{ $prod->categoria->nombre ?? '—' }}</span></td>
                            <td>
                                <span class="price">${{ number_format($prod->precio_final, 2) }}</span>
                                @if($prod->tiene_descuento)
                                    <span class="price-old">${{ number_format($prod->precio, 2) }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $prod->stock <= 5 ? ($prod->stock <= 2 ? 'badge-danger' : 'badge-warning') : 'badge-success' }}">
                                    {{ $prod->stock }}
                                </span>
                            </td>
                            <td>
                                @if($prod->activo)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <div style="display:flex;gap:6px">
                                    <a href="{{ route('admin.productos.show', $prod) }}" class="btn btn-secondary btn-icon btn-sm" title="Ver"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('admin.productos.edit', $prod) }}" class="btn btn-secondary btn-icon btn-sm" title="Editar"><i class="fas fa-pen"></i></a>
                                    <form action="{{ route('admin.productos.destroy', $prod) }}" method="POST" onsubmit="return confirm('¿Eliminar este producto?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-icon btn-sm" title="Eliminar"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7">
                            <div class="empty-state">
                                <i class="fas fa-box-open"></i>
                                <h4>Sin productos</h4>
                                <p>Agrega tu primer producto al catálogo.</p>
                            </div>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="pagination-wrapper">{{ $productos->withQueryString()->links() }}</div>
@endsection
