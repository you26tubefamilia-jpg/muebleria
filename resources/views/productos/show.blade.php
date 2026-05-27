@extends('layouts.admin')
@section('title', $producto->nombre)

@section('actions')
    <a href="{{ route('admin.productos.edit', $producto) }}" class="btn btn-secondary"><i class="fas fa-pen"></i> Editar</a>
    <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
@endsection

@section('content')
    <div style="display:grid;grid-template-columns:320px 1fr;gap:20px">
        <!-- Imagen -->
        <div class="card">
            <div class="card-body" style="text-align:center">
                @if($producto->imagen_principal)
                    <img src="{{ asset('storage/' . $producto->imagen_principal) }}" alt="{{ $producto->nombre }}" style="width:100%;max-height:300px;object-fit:cover;border-radius:8px">
                @else
                    <div style="width:100%;height:250px;background:var(--bg-hover);border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--text-muted)">
                        <i class="fas fa-image" style="font-size:48px"></i>
                    </div>
                @endif

                <div style="margin-top:16px">
                    @if($producto->tiene_descuento)
                        <span class="badge badge-danger" style="font-size:14px;padding:6px 14px">-{{ $producto->porcentaje_descuento }}%</span>
                    @endif
                    <div style="margin-top:8px">
                        <span class="price" style="font-size:28px">${{ number_format($producto->precio_final, 2) }}</span>
                        @if($producto->tiene_descuento)
                            <span class="price-old" style="font-size:16px">${{ number_format($producto->precio, 2) }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Detalles -->
        <div>
            <div class="card" style="margin-bottom:16px">
                <div class="card-header"><h3>Información General</h3></div>
                <div class="card-body">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                        <div><strong style="color:var(--text-muted);font-size:12px">SKU</strong><br>{{ $producto->sku ?? 'N/A' }}</div>
                        <div><strong style="color:var(--text-muted);font-size:12px">Categoría</strong><br>{{ $producto->categoria->nombre ?? '—' }}</div>
                        <div><strong style="color:var(--text-muted);font-size:12px">Proveedor</strong><br>{{ $producto->proveedor->nombre ?? 'Sin proveedor' }}</div>
                        <div><strong style="color:var(--text-muted);font-size:12px">Stock</strong><br>
                            <span class="badge {{ $producto->stock <= 5 ? 'badge-danger' : 'badge-success' }}">{{ $producto->stock }} unidades</span>
                        </div>
                        <div><strong style="color:var(--text-muted);font-size:12px">Material</strong><br>{{ $producto->material ?? 'N/A' }}</div>
                        <div><strong style="color:var(--text-muted);font-size:12px">Color</strong><br>{{ $producto->color ?? 'N/A' }}</div>
                        <div><strong style="color:var(--text-muted);font-size:12px">Dimensiones</strong><br>{{ $producto->dimensiones ?? 'N/A' }}</div>
                        <div><strong style="color:var(--text-muted);font-size:12px">Peso</strong><br>{{ $producto->peso ? $producto->peso . ' kg' : 'N/A' }}</div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header"><h3>Descripción</h3></div>
                <div class="card-body">
                    @if($producto->descripcion_corta)
                        <p style="color:var(--accent-light);margin-bottom:12px"><em>{{ $producto->descripcion_corta }}</em></p>
                    @endif
                    <p>{{ $producto->descripcion ?? 'Sin descripción.' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
