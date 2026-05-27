@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-box-open"></i></div>
            <div class="stat-info">
                <h4>Productos</h4>
                <div class="stat-value">{{ $totalProductos }}</div>
                <small style="color:var(--text-muted)">{{ $productosActivos }} activos</small>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon amber"><i class="fas fa-tags"></i></div>
            <div class="stat-info">
                <h4>Categorías</h4>
                <div class="stat-value">{{ $totalCategorias }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red"><i class="fas fa-clock"></i></div>
            <div class="stat-info">
                <h4>Pedidos Pendientes</h4>
                <div class="stat-value">{{ $pedidosPendientes }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-cash-register"></i></div>
            <div class="stat-info">
                <h4>Ventas del Día</h4>
                <div class="stat-value">${{ number_format($ventasHoy, 2) }}</div>
                <small style="color:var(--text-muted)">Mes: ${{ number_format($ventasMes, 2) }}</small>
            </div>
        </div>
    </div>

    <!-- Tables -->
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-top:20px">
        <div class="card">
            <div class="card-header"><h3>Últimos Pedidos</h3></div>
            <div class="table-wrapper">
                <table>
                    <thead><tr><th>Pedido</th><th>Total</th><th>Estado</th></tr></thead>
                    <tbody>
                        @forelse($ultimosPedidos as $ped)
                        <tr>
                            <td>{{ $ped->numero_pedido }}</td>
                            <td class="price">${{ number_format($ped->total, 2) }}</td>
                            <td><span class="badge badge-default">{{ ucfirst($ped->estado) }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="3" style="text-align:center;color:var(--text-muted)">Sin pedidos</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h3>Últimas Ventas</h3></div>
            <div class="table-wrapper">
                <table>
                    <thead><tr><th>Folio</th><th>Total</th><th>Estado</th></tr></thead>
                    <tbody>
                        @forelse($ultimasVentas as $venta)
                        <tr>
                            <td>{{ $venta->folio }}</td>
                            <td class="price">${{ number_format($venta->total, 2) }}</td>
                            <td><span class="badge badge-success">{{ ucfirst($venta->estado_pago) }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="3" style="text-align:center;color:var(--text-muted)">Sin ventas</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
