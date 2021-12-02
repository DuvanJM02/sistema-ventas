@extends('layouts.admin')

@section('container')
    <div class="row">
        <div class="col-xs-12">
            <h3>Modificar artículo: {{ $articulo->nombre }} </h3>
            {{ Form::model($articulo, ['method' => 'PATCH', 'route' => ['articulo.update', $articulo->idarticulo], 'files' => 'true']) }}
            @csrf

            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input class="form-control" type="text" name="nombre" value="{{ $articulo->nombre }}" autofocus>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="idcategoria">Categoría</label>
                        <select class="form-control" name="idcategoria" id="idcategoria">
                            @foreach ($categorias as $categoria)
                                @if ($categoria->idcategoria == $articulo->idcategoria)
                                    <option value="{{ $categoria->idcategoria }}" selected>
                                        {{ $categoria->nombre }}
                                    </option>
                                @else
                                    <option value="{{ $categoria->idcategoria }}">
                                        {{ $categoria->nombre }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="codigo">Código</label>
                        <input class="form-control" type="text" name="codigo" value="{{ $articulo->codigo }}">
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="stock">Stock</label>
                        <input class="form-control" type="number" name="stock" value="{{ $articulo->stock }}">
                    </div>
                </div>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <input class="form-control" type="text" name="descripcion" value="{{ $articulo->descripcion }}">
                    </div>
                </div><br>
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="imagen">Código de barras</label>
                        <style>
                            .code{
                                height: 80px!important;
                            }

                            .d-flex{
                                display: flex;
                            }

                            .justify-content-center{
                                justify-content: center;
                            }
                        </style>
                        <div class="d-flex justify-content-center">
                            {!! DNS1D::getBarcodeHTML($articulo->codigo, 'C128') !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group text-center">
                        <label for="imagen">Imagen</label>
                        <input class="form-control" type="file" name="imagen">
                        @if ($articulo->imagen != '')
                            <img class="img-thumbnail" src="{{ asset('img/articulos/' . $articulo->imagen) }}"
                                alt="{{ $articulo->nombre }}" width="300px" style="margin-top: 10px;">
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-12">
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

                <strong>NO se ha registrado tu categoría</strong>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> --}}
            </div>
        </section>
    @endif
@endsection
