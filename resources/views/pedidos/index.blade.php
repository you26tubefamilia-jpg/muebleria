@extends('layouts.admin')
@section('title', 'Pedidos')
@section('actions')
    <a href="{{ route('admin.pedidos.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nuevo Pedido</a>
@endsection

@section('content')
    <form method="GET" class="search-bar">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar pedido o cliente..." value="{{ request('buscar') }}">
        <select name="estado" class="form-control" style="max-width:180px">
            <option value="">Todos los estados</option>
            @foreach(['pendiente','confirmado','en_proceso','enviado','entregado','cancelado'] as $est)
                <option value="{{ $est }}" {{ request('estado') == $est ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$est)) }}</option>
            @endforeach
        </select>
        <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i> Filtrar</button>
    </form>

    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>N° Pedido</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Método Pago</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pedidos as $ped)
                        <tr>
                            <td><strong>{{ $ped->numero_pedido }}</strong></td>
                            <td>{{ $ped->cliente->nombre_completo ?? '—' }}</td>
                            <td class="price">${{ number_format($ped->total, 2) }}</td>
                            <td>{{ ucfirst($ped->metodo_pago) }}</td>
                            <td>
                                @switch($ped->estado)
                                    @case('pendiente') <span class="badge badge-warning">Pendiente</span> @break
                                    @case('confirmado') <span class="badge badge-info">Confirmado</span> @break
                                    @case('en_proceso') <span class="badge badge-info">En Proceso</span> @break
                                    @case('enviado') <span class="badge badge-info">Enviado</span> @break
                                    @case('entregado') <span class="badge badge-success">Entregado</span> @break
                                    @case('cancelado') <span class="badge badge-danger">Cancelado</span> @break
                                @endswitch
                            </td>
                            <td>{{ $ped->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div style="display:flex;gap:6px">
                                    <a href="{{ route('admin.pedidos.show', $ped) }}" class="btn btn-secondary btn-icon btn-sm"><i class="fas fa-eye"></i></a>
                                    <form action="{{ route('admin.pedidos.destroy', $ped) }}" method="POST" onsubmit="return confirm('¿Eliminar este pedido?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-icon btn-sm"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7">
                            <div class="empty-state"><i class="fas fa-clipboard-list"></i><h4>Sin pedidos</h4></div>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="pagination-wrapper">{{ $pedidos->withQueryString()->links() }}</div>
@endsection
