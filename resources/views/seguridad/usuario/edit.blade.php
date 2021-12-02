@extends('layouts.admin')

@section('container')
    <div class="row">
        <div class="col-xs-6">
            <h3>Modificar usuario: {{ $usuario->name }} </h3>
            {{ Form::model($usuario, ['method' => 'PATCH', 'route' => ['usuario.update', $usuario->id]]) }}
                @csrf
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input class="form-control" type="text" name="name" value="{{ $usuario->name }}" autofocus>
                </div>
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input class="form-control" type="email" name="email" value="{{ $usuario->email }}">
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input class="form-control" type="password" name="password" value="">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirme contraseña</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
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

                    <strong>NO se ha registrado tu usuario</strong>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> --}}
                </div>
        </section>
    @endif
@endsection