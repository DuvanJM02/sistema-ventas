@extends('layouts.admin')

@section('css')
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/css/bootstrap-select.min.css">

@endsection

@section('container')
    <div class="row">
        <div class="col-lg-12">
            <h3>Nuevo ingreso</h3>
            {{ Form::open(array('url' => 'compras/ingreso', 'method' => 'POST', 'autocomplete' => 'off')) }}
                @csrf

                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="idproveedor">Proveedor</label>
                            <select name="idproveedor" id="idproveedor" class="form-control selectpicker" data-live-search="true">
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
                            <input class="form-control" type="number" name="serie_comprobante" value="{{ old('serie_comprobante') }}">
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4 col-xs-12">
                        <div class="form-group">
                            <label for="num_comprobante">N° de comprobante</label>
                            <input class="form-control" type="number" name="num_comprobante" value="{{ old('num_comprobante') }}" min="0" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="col-lg-4 col-xs-12">
                                <label for="">Artículo</label>
                                <select name="pidarticulo" id="pidarticulo" class="form-control selectpicker" data-live-search='true'>
                                    @foreach ($articulos as $articulo)
                                        <option value="{{ $articulo->idarticulo }}">{{ $articulo->articulo }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2 col-xs-12">
                                <div class="form-group">
                                    <label for="pcantidad">Cantidad</label>
                                    <input type="number" min="0" class="form-control" name="pcantidad" id="pcantidad" value="{{ old('pcantidad') }}">
                                </div>
                            </div>
                            <div class="col-lg-2 col-xs-12">
                                <div class="form-group">
                                    <label for="pprecio_compra">Precio de compra</label>
                                    <input type="number" min="0" class="form-control" name="pprecio_compra" id="pprecio_compra" value="{{ old('pprecio_compra') }}">
                                </div>
                            </div>
                            <div class="col-lg-2 col-xs-12">
                                <div class="form-group">
                                    <label for="pprecio_venta">Precio de venta</label>
                                    <input type="number" min="0" class="form-control" name="pprecio_venta" id="pprecio_venta" value="{{ old('pprecio_venta') }}">
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
                                            <th>Precio compra</th>
                                            <th>Precio venta</th>
                                            <th>Subtotal</th>
                                        </thead>
                                        <tfoot style="border: 1px solid cadetblue">
                                            <th><strong>TOTAL</strong></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th><h4 id="total">$ . 0</h4></th>
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
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                    <strong>NO se ha registrado el INGRESO</strong>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> --}}
                </div>
        </section>
    @endif

    @push('scripts')
        <script>
            $(document).ready(function(){
                $('#btn_Add').click(function(){
                    agregar();
                });
            });

            var cont = 0;
            total = 0;
            subtotal = [];
            $('#guardar').hide();

            function agregar(){
                idarticulo = $('#pidarticulo').val();
                articulo = $('#pidarticulo option:selected').text();
                cantidad = $('#pcantidad').val();
                precio_compra = $('#pprecio_compra').val();
                precio_venta = $('#pprecio_venta').val();

                if(idarticulo != "" && cantidad != "" && cantidad > 0 && precio_compra != "" && precio_venta != ""){
                    subtotal[cont] = (cantidad * precio_compra);
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
                                        <input type="number" name="precio_compra[]" value="${precio_compra}">
                                    </td>
                                    <td>
                                        <input type="number" name="precio_venta[]" value="${precio_venta}">
                                    </td>
                                    <td>
                                        ${subtotal[cont]}
                                    </td>
                                </tr>`;
                    cont++;
                    limpiar();
                    $('#total').html('$ ' + total);
                    evaluar();
                    $('#detalles').append(fila);
                }else{
                    alert('Error al ingresar el detalle, verifique los datos del articulos.')
                }
            }

            function limpiar(){
                $('#pcantidad').val('');
                $('#pprecio_compra').val('');
                $('#pprecio_venta').val('');
            }

            function evaluar(){
                if(total > 0){
                    $('#guardar').show();
                }else{
                    $('#guardar').hide();
                }
            }

            function eliminar(index){
                total = total - subtotal[index];
                $('#total').html('$/.'  + total);
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