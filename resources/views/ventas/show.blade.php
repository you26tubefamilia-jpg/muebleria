@extends('layouts.admin')
@section('title', 'Venta ' . $venta->folio)
@section('actions')
    <a href="{{ route('admin.ventas.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
@endsection

@section('content')
    <div class="card" style="max-width:700px">
        <div class="card-header"><h3>Detalle de Venta</h3></div>
        <div class="card-body">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:20px">
                <div><strong style="color:var(--text-muted);font-size:12px">Folio</strong><br>{{ $venta->folio }}</div>
                <div><strong style="color:var(--text-muted);font-size:12px">Cliente</strong><br>{{ $venta->cliente->nombre_completo ?? '—' }}</div>
                <div><strong style="color:var(--text-muted);font-size:12px">Vendedor</strong><br>{{ $venta->vendedor->name ?? '—' }}</div>
                <div><strong style="color:var(--text-muted);font-size:12px">Método</strong><br>{{ ucfirst($venta->metodo_pago) }}</div>
                <div><strong style="color:var(--text-muted);font-size:12px">Estado</strong><br><span class="badge badge-success">{{ ucfirst($venta->estado_pago) }}</span></div>
                <div><strong style="color:var(--text-muted);font-size:12px">Fecha</strong><br>{{ $venta->created_at->format('d/m/Y H:i') }}</div>
            </div>
            <hr style="border-color:var(--border);margin:16px 0">
            <div style="text-align:right;font-size:14px">
                <p>Subtotal: ${{ number_format($venta->subtotal, 2) }}</p>
                <p>IVA: ${{ number_format($venta->iva, 2) }}</p>
                @if($venta->descuento > 0)<p style="color:var(--success)">Descuento: -${{ number_format($venta->descuento, 2) }}</p>@endif
                <p style="font-size:22px;font-weight:800;color:var(--accent-light);margin-top:8px">Total: ${{ number_format($venta->total, 2) }}</p>
            </div>
        </div>
    </div>

    @if($venta->pedido)
    <div class="card" style="max-width:700px;margin-top:16px">
        <div class="card-header"><h3>Productos (Pedido {{ $venta->pedido->numero_pedido }})</h3></div>
        <div class="table-wrapper">
            <table>
                <thead><tr><th>Producto</th><th>Cant.</th><th>P.U.</th><th>Subtotal</th></tr></thead>
                <tbody>
                    @foreach($venta->pedido->detalles as $det)
                    <tr>
                        <td>{{ $det->producto->nombre ?? '—' }}</td>
                        <td>{{ $det->cantidad }}</td>
                        <td>${{ number_format($det->precio_unitario, 2) }}</td>
                        <td class="price">${{ number_format($det->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
@endsection
