@extends('layouts.admin')
@section('title', 'Editar Categoría')

@section('content')
    <div class="card" style="max-width:600px">
        <div class="card-body">
            <form action="{{ route('admin.categorias.update', $categoria) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $categoria->nombre) }}" required>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion', $categoria->descripcion) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="imagen">Imagen</label>
                    @if($categoria->imagen)
                        <div style="margin-bottom:8px">
                            <img src="{{ asset('storage/' . $categoria->imagen) }}" alt="" style="max-height:80px;border-radius:8px">
                        </div>
                    @endif
                    <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
                </div>
                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="activo" value="1" {{ old('activo', $categoria->activo) ? 'checked' : '' }}>
                        Activa
                    </label>
                </div>
                <div style="display:flex;gap:10px">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Actualizar</button>
                    <a href="{{ route('admin.categorias.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
