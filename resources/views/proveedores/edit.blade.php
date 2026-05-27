@extends('layouts.admin')
@section('title', 'Editar Proveedor')

@section('content')
    @include('proveedores.create', ['proveedor' => $proveedor])
@endsection
