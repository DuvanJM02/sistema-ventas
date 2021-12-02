@extends('layouts.admin')

@section('container')

    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Lista de usuarios <a class="btn btn-success" href="{{ route('usuario.create') }}">Nuevo</a></h3>
            @include('seguridad.usuario.buscar')
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Opciones</th>
                    </thead>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id }}</td>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>
                                <a class="btn btn-warning" href="{{ route('usuario.edit', $usuario->id) }}">editar</a>
                                <a class="btn btn-danger" href="" data-target="#modal-delete-{{ $usuario->id }}" data-toggle="modal">eliminar</a>
                            </td>
                        </tr>
                        @include('seguridad.usuario.modal')
                    @endforeach
                </table>
            </div>
            <!-- paginación -->
            {{ $usuarios->links() }}
        </div>
    </div>

@endsection