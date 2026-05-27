@extends('layouts.admin')
@section('title', isset($cliente) ? 'Editar Cliente' : 'Nuevo Cliente')

@section('content')
    <div class="card" style="max-width:700px">
        <div class="card-body">
            <form action="{{ isset($cliente) ? route('admin.clientes.update', $cliente) : route('admin.clientes.store') }}" method="POST">
                @csrf
                @if(isset($cliente)) @method('PUT') @endif

                <div class="form-row">
                    <div class="form-group">
                        <label for="nombre">Nombre *</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $cliente->nombre ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="apellidos">Apellidos *</label>
                        <input type="text" name="apellidos" id="apellidos" class="form-control" value="{{ old('apellidos', $cliente->apellidos ?? '') }}" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $cliente->email ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono', $cliente->telefono ?? '') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <textarea name="direccion" id="direccion" class="form-control" rows="2">{{ old('direccion', $cliente->direccion ?? '') }}</textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="colonia">Colonia</label>
                        <input type="text" name="colonia" id="colonia" class="form-control" value="{{ old('colonia', $cliente->colonia ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label for="ciudad">Ciudad</label>
                        <input type="text" name="ciudad" id="ciudad" class="form-control" value="{{ old('ciudad', $cliente->ciudad ?? '') }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <input type="text" name="estado" id="estado" class="form-control" value="{{ old('estado', $cliente->estado ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label for="codigo_postal">Código Postal</label>
                        <input type="text" name="codigo_postal" id="codigo_postal" class="form-control" value="{{ old('codigo_postal', $cliente->codigo_postal ?? '') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="rfc">RFC</label>
                    <input type="text" name="rfc" id="rfc" class="form-control" value="{{ old('rfc', $cliente->rfc ?? '') }}" maxlength="13">
                </div>
                <div style="display:flex;gap:10px">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ isset($cliente) ? 'Actualizar' : 'Guardar' }}</button>
                    <a href="{{ route('admin.clientes.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
