@extends('layouts.admin')

@section('container')
    <div class="row">
        <div class="col-xs-12">
            <h3>Modificar proveedor: {{ $persona->nombre }} </h3>
            {{ Form::model($persona, ['method' => 'PATCH', 'route' => ['proveedor.update', $persona->idpersona]]) }}
                @csrf

                <div class="row">
                    <div class="col-lg-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input class="form-control" type="text" name="nombre" value="{{ $persona->nombre }}" autofocus>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            <input class="form-control" type="text" name="direccion" value="{{ $persona->direccion }}" >
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="tipo_documento">Tipo de documento</label>
                            <select name="tipo_documento" id="tipo_documento" class="form-control">

                                @if ($persona->tipo_documento == 'CC')
                                    <option value="CC" selected>Cédula de Ciudadanía</option>
                                    <option value="TI">Tarjeta de identidad</option>
                                    <option value="NIT">NIT</option>
                                    <option value="PAS">Pasaporte</option>
                                @elseif ($persona->tipo_documento == 'TI')
                                    <option value="CC">Cédula de Ciudadanía</option>
                                    <option value="TI" selected>Tarjeta de identidad</option>
                                    <option value="NIT">NIT</option>
                                    <option value="PAS">Pasaporte</option>
                                @elseif ($persona->tipo_documento == 'NIT')
                                    <option value="CC">Cédula de Ciudadanía</option>
                                    <option value="TI">Tarjeta de identidad</option>
                                    <option value="NIT" selected>NIT</option>
                                    <option value="PAS">Pasaporte</option>
                                @else
                                    <option value="CC">Cédula de Ciudadanía</option>
                                    <option value="TI">Tarjeta de identidad</option>
                                    <option value="NIT">NIT</option>
                                    <option value="PAS" selected>Pasaporte</option>
                                @endif

                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="num_documento">Número de documento</label>
                            <input class="form-control" type="number" name="num_documento" value="{{ $persona->num_documento }}">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input class="form-control" type="tel" name="telefono" value="{{ $persona->telefono }}">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" type="email" name="email" value="{{ $persona->email }}">
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