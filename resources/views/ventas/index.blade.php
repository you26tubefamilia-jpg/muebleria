@extends('layouts.admin')
@section('title', 'Ventas')

@section('content')
    <div class="stats-grid" style="margin-bottom:20px">
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-cash-register"></i></div>
            <div class="stat-info"><h4>Ventas Hoy</h4><div class="stat-value">${{ number_format($ventasHoy, 2) }}</div></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon amber"><i class="fas fa-chart-line"></i></div>
            <div class="stat-info"><h4>Total Acumulado</h4><div class="stat-value">${{ number_format($totalVentas, 2) }}</div></div>
        </div>
    </div>

    <form method="GET" class="search-bar">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar folio o cliente..." value="{{ request('buscar') }}">
        <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i> Filtrar</button>
    </form>

    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead><tr><th>Folio</th><th>Cliente</th><th>Total</th><th>Estado</th><th>Fecha</th><th></th></tr></thead>
                <tbody>
                    @forelse($ventas as $venta)
                        <tr>
                            <td><strong>{{ $venta->folio }}</strong></td>
                            <td>{{ $venta->cliente->nombre_completo ?? '—' }}</td>
                            <td class="price">${{ number_format($venta->total, 2) }}</td>
                            <td><span class="badge badge-success">{{ ucfirst($venta->estado_pago) }}</span></td>
                            <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                            <td><a href="{{ route('admin.ventas.show', $venta) }}" class="btn btn-secondary btn-icon btn-sm"><i class="fas fa-eye"></i></a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6"><div class="empty-state"><i class="fas fa-cash-register"></i><h4>Sin ventas</h4></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="pagination-wrapper">{{ $ventas->withQueryString()->links() }}</div>
@endsection
