@extends('layouts.admin')
@section('title', isset($proveedor) && $proveedor->exists ? 'Editar Proveedor' : 'Nuevo Proveedor')

@section('content')
    <div class="card" style="max-width:700px">
        <div class="card-body">
            <form action="{{ isset($proveedor) && $proveedor->exists ? route('admin.proveedores.update', $proveedor) : route('admin.proveedores.store') }}" method="POST">
                @csrf
                @if(isset($proveedor) && $proveedor->exists) @method('PUT') @endif

                <div class="form-group">
                    <label for="nombre">Nombre de la Empresa *</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $proveedor->nombre ?? '') }}" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="contacto">Persona de Contacto</label>
                        <input type="text" name="contacto" id="contacto" class="form-control" value="{{ old('contacto', $proveedor->contacto ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono', $proveedor->telefono ?? '') }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $proveedor->email ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label for="rfc">RFC</label>
                        <input type="text" name="rfc" id="rfc" class="form-control" value="{{ old('rfc', $proveedor->rfc ?? '') }}" maxlength="13">
                    </div>
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <textarea name="direccion" id="direccion" class="form-control" rows="2">{{ old('direccion', $proveedor->direccion ?? '') }}</textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="ciudad">Ciudad</label>
                        <input type="text" name="ciudad" id="ciudad" class="form-control" value="{{ old('ciudad', $proveedor->ciudad ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <input type="text" name="estado" id="estado" class="form-control" value="{{ old('estado', $proveedor->estado ?? '') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="activo" value="1" {{ old('activo', $proveedor->activo ?? true) ? 'checked' : '' }}>
                        Activo
                    </label>
                </div>
                <div style="display:flex;gap:10px">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ isset($proveedor) && $proveedor->exists ? 'Actualizar' : 'Guardar' }}</button>
                    <a href="{{ route('admin.proveedores.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
