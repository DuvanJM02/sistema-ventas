@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/jQuery-UI/jquery-ui.min.css') }}">
@endsection

@section('container')

    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Lista de artículos 
                <a class="btn btn-success" href="{{ route('articulo.create') }}">Nuevo</a>
                <a class="btn btn-warning" href="{{ route('articulo.imprimir') }}">Reporte</a>
            </h3>
            @include('almacen.articulo.buscar')
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Código</th>
                        <th>Categoría</th>
                        <th>Stock</th>
                        <th>Imagen</th>
                        <th>Estado</th>
                        <th>Opciones</th>
                    </thead>
                    @foreach ($articulos as $articulo)
                        <tr>
                            <td>{{ $articulo->idarticulo }}</td>
                            <td>{{ $articulo->nombre }}</td>
                            <td>{{ $articulo->codigo }}</td>
                            <td>{{ $articulo->categoria }}</td>
                            <td>{{ $articulo->stock }}</td>
                            <td>
                                <img src="{{ asset('img/articulos/' . $articulo->imagen) }}" alt="{{ $articulo->nombre }}" width="100rem" class="img-thumbnail">
                            </td>
                            <td>{{ $articulo->estado }}</td>
                            <td>
                                <a class="btn btn-warning" href="{{ route('articulo.edit', $articulo->idarticulo) }}">editar</a>
                                <a class="btn btn-danger" href="" data-target="#modal-delete-{{ $articulo->idarticulo }}" data-toggle="modal">eliminar</a>
                            </td>
                        </tr>
                        @include('almacen.articulo.modal')
                    @endforeach
                </table>
            </div>
            <!-- paginación -->
            {{ $articulos->links() }}
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('plugins/jQuery-UI/jquery-ui.min.js') }}"></script>

    <script>
        $('#searchText').autocomplete({
            source: function(request, response){
                $.ajax({
                    url: "{{ route('search.articulos') }}",
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