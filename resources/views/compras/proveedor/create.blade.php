@extends('layouts.admin')

@section('container')
    <div class="row">
        <div class="col-lg-12">
            <h3>Registrar proveedor</h3>
            {{ Form::open(array('url' => 'compras/proveedor', 'method' => 'POST', 'autocomplete' => 'off')) }}
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
                            <label for="direccion">Dirección</label>
                            <input class="form-control" type="text" name="direccion" value="{{ old('direccion') }}" >
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="tipo_documento">Tipo de documento</label>
                            <select name="tipo_documento" id="tipo_documento" class="form-control">
                                <option value="CC">Cédula de Ciudadanía</option>
                                <option value="TI">Tarjeta de identidad</option>
                                <option value="NIT">NIT</option>
                                <option value="PAS">Pasaporte</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="num_documento">Número de documento</label>
                            <input class="form-control" type="number" name="num_documento" value="{{ old('num_documento') }}">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input class="form-control" type="tel" name="telefono" value="{{ old('telefono') }}">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" type="email" name="email" value="{{ old('email') }}">
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

                    <strong>NO se ha registrado el proveedor</strong>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> --}}
                </div>
        </section>
    @endif
@endsection