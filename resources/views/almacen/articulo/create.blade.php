@extends('layouts.admin')

@section('container')
    <div class="row">
        <div class="col-lg-12">
            <h3>Crear artículo</h3>
            {{ Form::open(array('url' => 'almacen/articulo', 'method' => 'POST', 'autocomplete' => 'off', 'files' => 'true')) }}
                @csrf

                <div class="row">
                    <div class="col-lg-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input class="form-control" type="text" name="nombre" value="{{ old('nombre') }}" autofocus>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="idcategoria">Categoría</label>
                            <select class="form-control" name="idcategoria" id="idcategoria">
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->idcategoria }}">
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="codigo">Código</label>
                            <input class="form-control" type="text" name="codigo" value="{{ old('codigo') }}">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input class="form-control" type="number" name="stock" value="{{ old('stock') }}">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <input class="form-control" type="text" name="descripcion" value="{{ old('descripcion') }}">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="imagen">Imagen</label>
                            <input class="form-control" type="file" name="imagen">
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
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                    <strong>NO se ha registrado tu categoría</strong>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> --}}
                </div>
        </section>
    @endif
@endsection