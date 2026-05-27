@extends('layouts.admin')
@section('title', 'Editar Producto')

@section('content')
    <div class="card" style="max-width:800px">
        <div class="card-body">
            <form action="{{ route('admin.productos.update', $producto) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="form-group">
                    <label for="nombre">Nombre del Producto *</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $producto->nombre) }}" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="categoria_id">Categoría *</label>
                        <select name="categoria_id" id="categoria_id" class="form-control" required>
                            @foreach($categorias as $cat)
                                <option value="{{ $cat->id }}" {{ old('categoria_id', $producto->categoria_id) == $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="proveedor_id">Proveedor</label>
                        <select name="proveedor_id" id="proveedor_id" class="form-control">
                            <option value="">Sin proveedor</option>
                            @foreach($proveedores as $prov)
                                <option value="{{ $prov->id }}" {{ old('proveedor_id', $producto->proveedor_id) == $prov->id ? 'selected' : '' }}>{{ $prov->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="descripcion_corta">Descripción Corta</label>
                    <input type="text" name="descripcion_corta" id="descripcion_corta" class="form-control" value="{{ old('descripcion_corta', $producto->descripcion_corta) }}">
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción Completa</label>
                    <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion', $producto->descripcion) }}</textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="precio">Precio *</label>
                        <input type="number" name="precio" id="precio" class="form-control" value="{{ old('precio', $producto->precio) }}" step="0.01" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="precio_oferta">Precio de Oferta</label>
                        <input type="number" name="precio_oferta" id="precio_oferta" class="form-control" value="{{ old('precio_oferta', $producto->precio_oferta) }}" step="0.01" min="0">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="stock">Stock *</label>
                        <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock', $producto->stock) }}" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="sku">SKU</label>
                        <input type="text" name="sku" id="sku" class="form-control" value="{{ old('sku', $producto->sku) }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="material">Material</label>
                        <input type="text" name="material" id="material" class="form-control" value="{{ old('material', $producto->material) }}">
                    </div>
                    <div class="form-group">
                        <label for="color">Color</label>
                        <input type="text" name="color" id="color" class="form-control" value="{{ old('color', $producto->color) }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="dimensiones">Dimensiones</label>
                        <input type="text" name="dimensiones" id="dimensiones" class="form-control" value="{{ old('dimensiones', $producto->dimensiones) }}">
                    </div>
                    <div class="form-group">
                        <label for="peso">Peso (kg)</label>
                        <input type="number" name="peso" id="peso" class="form-control" value="{{ old('peso', $producto->peso) }}" step="0.01" min="0">
                    </div>
                </div>
                <div class="form-group">
                    <label for="imagen_principal">Imagen Principal</label>
                    @if($producto->imagen_principal)
                        <div style="margin-bottom:8px">
                            <img src="{{ asset('storage/' . $producto->imagen_principal) }}" alt="" style="max-height:100px;border-radius:8px">
                        </div>
                    @endif
                    <input type="file" name="imagen_principal" id="imagen_principal" class="form-control" accept="image/*">
                </div>
                <div class="form-row" style="margin-bottom:20px">
                    <label class="form-check">
                        <input type="checkbox" name="destacado" value="1" {{ old('destacado', $producto->destacado) ? 'checked' : '' }}>
                        Producto Destacado
                    </label>
                    <label class="form-check">
                        <input type="checkbox" name="activo" value="1" {{ old('activo', $producto->activo) ? 'checked' : '' }}>
                        Activo
                    </label>
                </div>
                <div style="display:flex;gap:10px">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Actualizar</button>
                    <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
