@extends('layouts.admin')
@section('title', 'Editar Cliente')

@section('content')
    @include('clientes.create', ['cliente' => $cliente])
@endsection
