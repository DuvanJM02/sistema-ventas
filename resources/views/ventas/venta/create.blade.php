@extends('layouts.admin')

@section('css')
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/css/bootstrap-select.min.css">

@endsection

@section('container')
    <div class="row">
        <div class="col-lg-12">
            <h3>Nueva venta</h3>
            {{ Form::open(['url' => 'ventas/venta', 'method' => 'POST', 'autocomplete' => 'off']) }}
            @csrf

            <div class="row">
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="idcliente">Cliente</label>
                        <select name="idcliente" id="idcliente" class="form-control selectpicker" data-live-search="true">
                            @foreach ($personas as $persona)
                                <option value="{{ $persona->idpersona }}">{{ $persona->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label for="tipo_comprobante">Tipo de comprobante</label>
                        <select name="tipo_comprobante" id="tipo_comprobante" class="form-control">
                            <option value="Boleta">Boleta</option>
                            <option value="Factura">Factura</option>
                            <option value="Tiquete">Tiquete</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label for="serie_comprobante">Serie de comprobante</label>
                        <input class="form-control" type="number" name="serie_comprobante"
                            value="{{ old('serie_comprobante') }}">
                    </div>
                </div>
                <div class="col-lg-4 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label for="num_comprobante">N° de comprobante</label>
                        <input class="form-control" type="number" name="num_comprobante"
                            value="{{ old('num_comprobante') }}" min="0" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <div class="col-lg-4 col-xs-12">
                            <label for="">Artículo</label>
                            <select name="pidarticulo" id="pidarticulo" class="form-control selectpicker"
                                data-live-search='true'>
                                @foreach ($articulos as $articulo)
                                    <option
                                        value="{{ $articulo->idarticulo }}_{{ $articulo->stock }}_{{ $articulo->precio_promedio }}">
                                        {{ $articulo->articulo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2 col-xs-12">
                            <div class="form-group">
                                <label for="pcantidad">Cantidad</label>
                                <input type="number" min="0" class="form-control" name="pcantidad" id="pcantidad"
                                    value="{{ old('pcantidad') }}">
                            </div>
                        </div>
                        <div class="col-lg-2 col-xs-12">
                            <div class="form-group">
                                <label for="pstock">Stock</label>
                                <input type="number" min="0" class="form-control" name="pstock" id="pstock"
                                    value="{{ old('pstock') }}" disabled>
                            </div>
                        </div>
                        <div class="col-lg-2 col-xs-12">
                            <div class="form-group">
                                <label for="pprecio_venta">Precio de venta</label>
                                <input type="number" min="0" class="form-control" name="pprecio_venta" id="pprecio_venta"
                                    value="{{ old('pprecio_venta') }}" disabled>
                            </div>
                        </div>
                        <div class="col-lg-2 col-xs-12">
                            <div class="form-group">
                                <label for="pdescuento">Descuento</label>
                                <input type="number" min="0" class="form-control" name="pdescuento" id="pdescuento"
                                    value="{{ old('pdescuento') }}">
                            </div>
                        </div>
                        <div class="col-lg-2 col-xs-12">
                            <div class="form-group">
                                <button type="button" class="btn btn-warning" id="btn_Add">Agregar</button>
                            </div>
                        </div>
                        <div class="col-lg-12 col-xs-12">
                            <div class="form-group">
                                <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                                    <thead style="background: cadetblue;">
                                        <th>Opciones</th>
                                        <th>Artículo</th>
                                        <th>Cantidad</th>
                                        <th>Precio venta</th>
                                        <th>Descuento</th>
                                        <th>Subtotal</th>
                                    </thead>
                                    <tfoot style="border: 1px solid cadetblue">
                                        <th><strong>TOTAL</strong></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>
                                            <h4 id="total">$ . 0</h4>
                                            <input type="hidden" name="total_venta" id="total_venta">
                                        </th>
                                    </tfoot>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-12" id="guardar">
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Guardar</button>
                        <button class="btn btn-danger" type="reset">Cancelar</button>
                    </div>
                </div>
            </div>

            {{ Form::close() }}
        </div>
    </div>


    @if ($errors->any())
        <section class="errores">
            <div class="alert alert-danger " role="alert">
                {{-- @error('nombre')
                        <strong>¡ERROR!</strong> {{ $message }}
                        <br>
                    @enderror
                    @error('descripcion')
                        <strong>¡ERROR!</strong> {{ $message }}
                        <br>
                    @enderror --}}

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

                <strong>NO se ha registrado la VENTA</strong>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> --}}
            </div>
        </section>
    @endif

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#btn_Add').click(function() {
                    agregar();
                });
            });

            var cont = 0;
            total = 0;
            subtotal = [];
            $('#guardar').hide();
            $('#pidarticulo').change(mostrarValor);

            function mostrarValor() {
                datosArticulo = document.getElementById('pidarticulo').value.split('_');
                $('#pprecio_venta').val(datosArticulo[2]);
                $('#pstock').val(datosArticulo[1]);
            }

            function agregar() {
                datosArticulo = document.getElementById('pidarticulo').value.split('_');

                idarticulo = datosArticulo[0];
                articulo = $('#pidarticulo option:selected').text();
                cantidad = $('#pcantidad').val();

                descuento = $('#pdescuento').val();
                precio_venta = $('#pprecio_venta').val();
                stock = $('#pstock').val();

                if (idarticulo != "" && cantidad != "" && cantidad > 0 && descuento != "" && precio_venta != "") {

                    if (stock >= cantidad) {

                        subtotal[cont] = (cantidad * precio_venta - descuento);
                        total = total + subtotal[cont];

                        var fila = `<tr class="selected" id="fila${cont}">
                                    <td>
                                        <button type="button" class="btn btn-danger" onclick="eliminar(${cont});">x</button>
                                    </td>
                                    <td>
                                        <input type="hidden" name="idarticulo[]" value="${idarticulo}">
                                        ${articulo}
                                    </td>
                                    <td>
                                        <input type="number" name="cantidad[]" value="${cantidad}">
                                    </td>
                                    <td>
                                        <input type="number" name="precio_venta[]" value="${precio_venta}">
                                    </td>
                                    <td>
                                        <input type="number" name="descuento[]" value="${descuento}">
                                    </td>
                                    <td>
                                        ${subtotal[cont]}
                                    </td>
                                </tr>`;
                        cont++;
                        limpiar();
                        $('#total').html('$ ' + total);
                        $('#total_venta').val(total);
                        evaluar();
                        $('#detalles').append(fila);
                    }else{
                        alert('La cantidad a vender supera al stock');
                    }

                } else {
                    alert('Error al ingresar los detalles, verifique los datos del articulos.')
                }
            }

            function limpiar() {
                $('#pcantidad').val('');
                $('#pdescuento').val('');
                $('#pprecio_venta').val('');
            }

            function evaluar() {
                if (total > 0) {
                    $('#guardar').show();
                } else {
                    $('#guardar').hide();
                }
            }

            function eliminar(index) {
                total = total - subtotal[index];
                $('#total').html('$/.' + total);
                $('#total_venta').val(total);
                $('#fila' + index).remove();
                evaluar();
            }
        </script>
    @endpush

@section('js')
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/js/bootstrap-select.min.js"></script>
@endsection
@endsection
