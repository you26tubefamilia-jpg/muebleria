@extends('layouts.admin')
@section('title', 'Clientes')
@section('actions')
    <a href="{{ route('admin.clientes.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nuevo Cliente</a>
@endsection

@section('content')
    <form method="GET" class="search-bar">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar cliente..." value="{{ request('buscar') }}">
        <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i> Buscar</button>
    </form>

    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Ciudad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clientes as $cli)
                        <tr>
                            <td><strong>{{ $cli->nombre_completo }}</strong></td>
                            <td>{{ $cli->email }}</td>
                            <td>{{ $cli->telefono ?? '—' }}</td>
                            <td>{{ $cli->ciudad ?? '—' }}</td>
                            <td>
                                <div style="display:flex;gap:6px">
                                    <a href="{{ route('admin.clientes.show', $cli) }}" class="btn btn-secondary btn-icon btn-sm"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('admin.clientes.edit', $cli) }}" class="btn btn-secondary btn-icon btn-sm"><i class="fas fa-pen"></i></a>
                                    <form action="{{ route('admin.clientes.destroy', $cli) }}" method="POST" onsubmit="return confirm('¿Eliminar este cliente?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-icon btn-sm"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5">
                            <div class="empty-state"><i class="fas fa-users"></i><h4>Sin clientes</h4></div>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="pagination-wrapper">{{ $clientes->withQueryString()->links() }}</div>
@endsection
