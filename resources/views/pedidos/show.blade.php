@extends('layouts.admin')
@section('title', 'Pedido ' . $pedido->numero_pedido)

@section('actions')
    <a href="{{ route('admin.pedidos.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
@endsection

@section('content')
    <div style="display:grid;grid-template-columns:1fr 320px;gap:20px">
        <!-- Detalles del Pedido -->
        <div>
            <div class="card" style="margin-bottom:16px">
                <div class="card-header"><h3>Productos del Pedido</h3></div>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Precio Unit.</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pedido->detalles as $det)
                                <tr>
                                    <td><strong>{{ $det->producto->nombre ?? 'Producto eliminado' }}</strong></td>
                                    <td>${{ number_format($det->precio_unitario, 2) }}</td>
                                    <td>{{ $det->cantidad }}</td>
                                    <td class="price">${{ number_format($det->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align:right;font-weight:600">Subtotal</td>
                                <td class="price">${{ number_format($pedido->subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align:right;font-weight:600">IVA (16%)</td>
                                <td>${{ number_format($pedido->iva, 2) }}</td>
                            </tr>
                            @if($pedido->descuento > 0)
                            <tr>
                                <td colspan="3" style="text-align:right;font-weight:600">Descuento</td>
                                <td style="color:var(--success)">-${{ number_format($pedido->descuento, 2) }}</td>
                            </tr>
                            @endif
                            <tr style="font-size:18px">
                                <td colspan="3" style="text-align:right;font-weight:800">Total</td>
                                <td class="price" style="font-size:18px">${{ number_format($pedido->total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            @if($pedido->notas)
                <div class="card">
                    <div class="card-header"><h3>Notas</h3></div>
                    <div class="card-body"><p>{{ $pedido->notas }}</p></div>
                </div>
            @endif
        </div>

        <!-- Panel lateral -->
        <div>
            <div class="card" style="margin-bottom:16px">
                <div class="card-header"><h3>Estado</h3></div>
                <div class="card-body">
                    <form action="{{ route('admin.pedidos.updateEstado', $pedido) }}" method="POST">
                        @csrf @method('PATCH')
                        <div class="form-group">
                            <select name="estado" class="form-control">
                                @foreach(['pendiente','confirmado','en_proceso','enviado','entregado','cancelado'] as $est)
                                    <option value="{{ $est }}" {{ $pedido->estado == $est ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$est)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width:100%"><i class="fas fa-sync"></i> Actualizar Estado</button>
                    </form>
                </div>
            </div>

            <div class="card" style="margin-bottom:16px">
                <div class="card-header"><h3>Información</h3></div>
                <div class="card-body" style="font-size:14px">
                    <p style="margin-bottom:8px"><strong style="color:var(--text-muted)">Cliente:</strong><br>{{ $pedido->cliente->nombre_completo ?? '—' }}</p>
                    <p style="margin-bottom:8px"><strong style="color:var(--text-muted)">Vendedor:</strong><br>{{ $pedido->vendedor->name ?? '—' }}</p>
                    <p style="margin-bottom:8px"><strong style="color:var(--text-muted)">Método de Pago:</strong><br>{{ ucfirst($pedido->metodo_pago) }}</p>
                    <p style="margin-bottom:8px"><strong style="color:var(--text-muted)">Fecha:</strong><br>{{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                    @if($pedido->direccion_envio)
                        <p><strong style="color:var(--text-muted)">Dirección Envío:</strong><br>{{ $pedido->direccion_envio }}</p>
                    @endif
                </div>
            </div>

            @if($pedido->estado == 'entregado' && !$pedido->venta)
                <form action="{{ route('admin.ventas.crearDesdePedido', $pedido) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success" style="width:100%"><i class="fas fa-cash-register"></i> Registrar Venta</button>
                </form>
            @endif
        </div>
    </div>
@endsection
