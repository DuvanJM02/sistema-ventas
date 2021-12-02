@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/jQuery-UI/jquery-ui.min.css') }}">
@endsection

@section('container')

    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Lista de ventas
                <a class="btn btn-success" href="{{ route('venta.create') }}">Nuevo</a>
                <a class="btn btn-warning" href="{{ route('venta.create') }}">Reporte</a>
            </h3>
            @include('ventas.venta.buscar')
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Comprobante</th>
                        <th>Impuesto</th>
                        <th>Total venta</th>
                        <th>Estado</th>
                        <th>Opciones</th>
                    </thead>
                    @foreach ($ventas as $venta)
                        <tr>
                            <td>{{ $venta->fecha_hora }}</td>
                            <td>{{ $venta->nombre }}</td>
                            <td>{{ $venta->tipo_comprobante . ': ' . $venta->serie_comprobante . '-' . $venta->num_comprobante }}</td>
                            <td>{{ $venta->impuesto }}</td>
                            <td>{{ $venta->total_venta }}</td>
                            <td>{{ $venta->estado }}</td>
                            <td>
                                <a class="btn btn-info" href="{{ route('venta.show', $venta->idventa) }}">Mostrar</a>
                                <a class="btn btn-danger" href="" data-target="#modal-delete-{{ $venta->idventa }}" data-toggle="modal">anular</a>
                            </td>
                        </tr>
                        @include('ventas.venta.modal')
                    @endforeach
                </table>
            </div>
            <!-- paginación -->
            {{ $ventas->links() }}
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