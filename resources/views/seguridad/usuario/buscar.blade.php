<!-- Usar Laravel Collective -->
{!! Form::open(array('url' => 'seguridad/usuario', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search')) !!}
    <div class="form-group">
        <div class="input-group">
            <input class="form-control" name="searchText" placeholder="Busca..." type="text" value="{{ $searchText }}">
            <span class="input-group-btn">
                <button class="btn btn-primary" type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </span>
        </div>
    </div>
{{ Form::close() }}
