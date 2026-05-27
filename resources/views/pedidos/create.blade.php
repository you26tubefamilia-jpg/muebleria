@extends('layouts.admin')
@section('title', 'Nuevo Pedido')

@section('content')
    <div class="card" style="max-width:800px">
        <div class="card-body">
            <form action="{{ route('admin.pedidos.store') }}" method="POST" id="pedidoForm">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label for="cliente_id">Cliente *</label>
                        <select name="cliente_id" id="cliente_id" class="form-control" required>
                            <option value="">Seleccionar cliente...</option>
                            @foreach($clientes as $cli)
                                <option value="{{ $cli->id }}" {{ old('cliente_id') == $cli->id ? 'selected' : '' }}>{{ $cli->nombre_completo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="metodo_pago">Método de Pago *</label>
                        <select name="metodo_pago" id="metodo_pago" class="form-control" required>
                            <option value="efectivo">Efectivo</option>
                            <option value="tarjeta">Tarjeta</option>
                            <option value="transferencia">Transferencia</option>
                            <option value="credito">Crédito</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="direccion_envio">Dirección de Envío</label>
                    <textarea name="direccion_envio" id="direccion_envio" class="form-control" rows="2">{{ old('direccion_envio') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="notas">Notas</label>
                    <textarea name="notas" id="notas" class="form-control" rows="2">{{ old('notas') }}</textarea>
                </div>

                <!-- Productos -->
                <div class="card" style="margin-bottom:20px;background:var(--bg-primary)">
                    <div class="card-header">
                        <h3><i class="fas fa-box-open" style="margin-right:8px;color:var(--accent)"></i> Productos</h3>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="agregarProducto()"><i class="fas fa-plus"></i> Agregar</button>
                    </div>
                    <div class="card-body" id="productosContainer">
                        <div class="producto-row" style="display:grid;grid-template-columns:1fr 120px 40px;gap:10px;align-items:end;margin-bottom:10px">
                            <div class="form-group" style="margin:0">
                                <label>Producto</label>
                                <select name="productos[0][id]" class="form-control" required>
                                    <option value="">Seleccionar...</option>
                                    @foreach($productos as $prod)
                                        <option value="{{ $prod->id }}">${{ number_format($prod->precio_final, 2) }} — {{ $prod->nombre }} (Stock: {{ $prod->stock }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" style="margin:0">
                                <label>Cant.</label>
                                <input type="number" name="productos[0][cantidad]" class="form-control" value="1" min="1" required>
                            </div>
                            <div></div>
                        </div>
                    </div>
                </div>

                <div style="display:flex;gap:10px">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Crear Pedido</button>
                    <a href="{{ route('admin.pedidos.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        let productoIndex = 1;
        function agregarProducto() {
            const container = document.getElementById('productosContainer');
            const html = `
                <div class="producto-row" style="display:grid;grid-template-columns:1fr 120px 40px;gap:10px;align-items:end;margin-bottom:10px">
                    <div class="form-group" style="margin:0">
                        <select name="productos[${productoIndex}][id]" class="form-control" required>
                            <option value="">Seleccionar...</option>
                            @foreach($productos as $prod)
                                <option value="{{ $prod->id }}">${{ number_format($prod->precio_final, 2) }} — {{ $prod->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="margin:0">
                        <input type="number" name="productos[${productoIndex}][cantidad]" class="form-control" value="1" min="1" required>
                    </div>
                    <button type="button" class="btn btn-danger btn-icon btn-sm" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            productoIndex++;
        }
    </script>
@endsection
