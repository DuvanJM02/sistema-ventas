@extends('layouts.admin')

@section('container')
    <div class="row">
        <div class="col-xs-6">
            <h3>Crear categoría</h3>
            {{ Form::open(array('url' => 'almacen/categoria', 'method' => 'POST', 'autocomplete' => 'off')) }}
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input class="form-control" type="text" name="nombre" value="{{ old('nombre') }}" autofocus>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <input class="form-control" type="text" name="descripcion" value="{{ old('descripcion') }}">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                    <button class="btn btn-danger" type="reset">Cancelar</button>
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