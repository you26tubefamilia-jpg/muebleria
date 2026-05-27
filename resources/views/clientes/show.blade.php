@extends('layouts.admin')
@section('title', $cliente->nombre_completo)

@section('actions')
    <a href="{{ route('admin.clientes.edit', $cliente) }}" class="btn btn-secondary"><i class="fas fa-pen"></i> Editar</a>
    <a href="{{ route('admin.clientes.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
@endsection

@section('content')
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">
        <div class="card">
            <div class="card-header"><h3><i class="fas fa-user" style="margin-right:8px;color:var(--accent)"></i> Datos del Cliente</h3></div>
            <div class="card-body">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                    <div><strong style="color:var(--text-muted);font-size:12px">Email</strong><br>{{ $cliente->email }}</div>
                    <div><strong style="color:var(--text-muted);font-size:12px">Teléfono</strong><br>{{ $cliente->telefono ?? 'N/A' }}</div>
                    <div><strong style="color:var(--text-muted);font-size:12px">Dirección</strong><br>{{ $cliente->direccion ?? 'N/A' }}</div>
                    <div><strong style="color:var(--text-muted);font-size:12px">Ciudad</strong><br>{{ $cliente->ciudad ?? 'N/A' }}, {{ $cliente->estado ?? '' }}</div>
                    <div><strong style="color:var(--text-muted);font-size:12px">C.P.</strong><br>{{ $cliente->codigo_postal ?? 'N/A' }}</div>
                    <div><strong style="color:var(--text-muted);font-size:12px">RFC</strong><br>{{ $cliente->rfc ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h3><i class="fas fa-clipboard-list" style="margin-right:8px;color:var(--info)"></i> Últimos Pedidos</h3></div>
            <div class="table-wrapper">
                <table>
                    <thead><tr><th>Pedido</th><th>Total</th><th>Estado</th></tr></thead>
                    <tbody>
                        @forelse($cliente->pedidos as $pedido)
                            <tr>
                                <td><a href="{{ route('admin.pedidos.show', $pedido) }}" style="color:var(--accent-light)">{{ $pedido->numero_pedido }}</a></td>
                                <td class="price">${{ number_format($pedido->total, 2) }}</td>
                                <td><span class="badge badge-default">{{ ucfirst($pedido->estado) }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="3" style="text-align:center;color:var(--text-muted)">Sin pedidos</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
