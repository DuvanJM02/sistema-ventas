@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/jQuery-UI/jquery-ui.min.css') }}">
@endsection

@section('container')

    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Lista de proveedores <a class="btn btn-success" href="{{ route('proveedor.create') }}">Nuevo</a></h3>
            @include('compras.proveedor.buscar')
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Tipo de documento</th>
                        <th>N° Documento</th>
                        <th>Teléfono</th>
                        <th>Email</th>   
                        <th>Opciones</th>
                    </thead>
                    @foreach ($personas as $persona)
                        <tr>
                            <td>{{ $persona->idpersona }}</td>
                            <td>{{ $persona->nombre }}</td>
                            <td>
                                @if ($persona->tipo_documento == 'PAS')
                                    Pasaporte
                                @else
                                    {{ $persona->tipo_documento }}
                                @endif
                            </td>
                            <td>{{ $persona->num_documento }}</td>
                            <td>{{ $persona->telefono }}</td>
                            <td>{{ $persona->email }}</td>
                            <td>
                                <a class="btn btn-warning" href="{{ route('proveedor.edit', $persona->idpersona) }}">editar</a>
                                <a class="btn btn-danger" href="" data-target="#modal-delete-{{ $persona->idpersona }}" data-toggle="modal">eliminar</a>
                            </td>
                        </tr>
                        @include('compras.proveedor.modal')
                    @endforeach
                </table>
            </div>
            <!-- paginación -->
            {{ $personas->links() }}
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('plugins/jQuery-UI/jquery-ui.min.js') }}"></script>

    <script>
        $('#searchText').autocomplete({
            source: function(request, response){
                $.ajax({
                    url: "{{ route('search.personas') }}",
                    dataType: 'json',
                    data: {
                        term: request.term
                    },
                    success: function(data){
                        response(data)
                    }
                });
            }
        });
    </script> 
@endsection