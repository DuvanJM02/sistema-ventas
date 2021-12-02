@extends('layouts.admin')

@section('css')
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/css/bootstrap-select.min.css">

@endsection

@section('container')
    <div class="row">
        <div class="col-lg-12">
            <h3>Nuevo ingreso</h3>
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="idproveedor">Proveedor</label>
                        <p>{{ $ingreso->nombre }}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label for="tipo_comprobante">Tipo de comprobante</label>
                        <p>{{ $ingreso->tipo_comprobante }}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label for="serie_comprobante">Serie de comprobante</label>
                        <p>{{ $ingreso->serie_comprobante }}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label for="num_comprobante">N° de comprobante</label>
                        <p><p>{{ $ingreso->num_comprobante }}</p></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-body">
                        
                        <div class="col-lg-12 col-xs-12">
                            <div class="form-group">
                                <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                                    <thead style="background-color: cadetblue">
                                        
                                        <th>Artículo</th>
                                        <th>Cantidad</th>
                                        <th>Precio compra</th>
                                        <th>Precio venta</th>
                                        <th>Subtotal</th>
                                    </thead>
                                    <tfoot style="border: 1px solid cadetblue">
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>
                                            <h4 >$ <span id="total">{{ $ingreso->total }}</span></h4>
                                        </th>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($detalles as $detalle)
                                            <tr>
                                                <td>{{ $detalle->articulo }}</td>
                                                <td>{{ $detalle->cantidad }}</td>
                                                <td>{{ $detalle->precio_compra }}</td>
                                                <td>{{ $detalle->precio_venta }}</td>
                                                <td>{{ $detalle->cantidad * $detalle->precio_compra }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('js')
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/js/bootstrap-select.min.js"></script>
@endsection
@endsection
