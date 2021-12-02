@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/jQuery-UI/jquery-ui.min.css') }}">
@endsection

@section('container')

    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Lista de ingresos <a class="btn btn-success" href="{{ route('ingreso.create') }}">Nuevo</a></h3>
            @include('compras.ingreso.buscar')
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <th>Fecha</th>
                        <th>Proveedor</th>
                        <th>Comprobante</th>
                        <th>Impuesto</th>
                        <th>Total ingreso</th>
                        <th>Estado</th>
                        <th>Opciones</th>
                    </thead>
                    @foreach ($ingresos as $ingreso)
                        <tr>
                            <td>{{ $ingreso->fecha_hora }}</td>
                            <td>{{ $ingreso->nombre }}</td>
                            <td>{{ $ingreso->tipo_comprobante . ': ' . $ingreso->serie_comprobante . '-' . $ingreso->num_comprobante }}</td>
                            <td>{{ $ingreso->impuesto }}</td>
                            <td>{{ $ingreso->total }}</td>
                            <td>{{ $ingreso->estado }}</td>
                            <td>
                                <a class="btn btn-info" href="{{ route('ingreso.show', $ingreso->idingreso) }}">Mostrar</a>
                                <a class="btn btn-danger" href="" data-target="#modal-delete-{{ $ingreso->idingreso }}" data-toggle="modal">anular</a>
                            </td>
                        </tr>
                        @include('compras.ingreso.modal')
                    @endforeach
                </table>
            </div>
            <!-- paginación -->
            {{ $ingresos->links() }}
        </div>
    </div>

@endsection

@section('js')
    {{-- <script src="{{ asset('plugins/jQuery-UI/jquery-ui.min.js') }}"></script>

    <script>
        $('#searchText').autocomplete({
            source: function(request, response){
                $.ajax({
                    url: "{{ route('search.ingresos') }}",
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
    </script>  --}}
@endsection