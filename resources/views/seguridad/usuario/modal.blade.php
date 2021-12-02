<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" 
id="modal-delete-{{ $usuario->id }}">
	<form action="{{ route('usuario.destroy', $usuario->id) }}" method="POST" >
		@method('delete')
		@csrf
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">x</span>
					</button>
					<h4 class="modal-title">Eliminar: {{ $usuario->name }}</h4>
				</div>
				<div class="modal-body">
					<p>¿Está seguro de <strong>eliminar</strong> esta usuario?</p>
				</div>
				<div class="modal-footer">
					<button class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button class="btn btn-danger" type="submit">Eliminar</button>
				</div>
			</div>
		</div>
	</form>
</div> 