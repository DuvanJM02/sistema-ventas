@extends('layouts.admin')

@section('container')

    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Lista de categorías <a class="btn btn-success" href="{{ route('categoria.create') }}">Nuevo</a></h3>
            @include('almacen.categoria.buscar')
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Opciones</th>
                    </thead>
                    @foreach ($categorias as $categoria)
                        <tr>
                            <td>{{ $categoria->idcategoria }}</td>
                            <td>{{ $categoria->nombre }}</td>
                            <td>{{ $categoria->descripcion }}</td>
                            <td>
                                <a class="btn btn-warning" href="{{ route('categoria.edit', $categoria->idcategoria) }}">editar</a>
                                <a class="btn btn-danger" href="" data-target="#modal-delete-{{ $categoria->idcategoria }}" data-toggle="modal">eliminar</a>
                            </td>
                        </tr>
                        @include('almacen.categoria.modal')
                    @endforeach
                </table>
            </div>
            <!-- paginación -->
            {{ $categorias->links() }}
        </div>
    </div>

@endsection