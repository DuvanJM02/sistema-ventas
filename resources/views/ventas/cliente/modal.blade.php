<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" 
id="modal-delete-{{ $persona->idpersona }}">
	<form action="{{ route('cliente.destroy', $persona->idpersona) }}" method="POST" >
		@method('delete')
		@csrf
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">x</span>
					</button>
					<h4 class="modal-title">Eliminar: {{ $persona->nombre }}</h4>
				</div>
				<div class="modal-body">
					<p>¿Está seguro de <strong>eliminar</strong> esta persona?</p>
				</div>
				<div class="modal-footer">
					<button class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button class="btn btn-danger" type="submit">Eliminar</button>
				</div>
			</div>
		</div>
	</form>
</div> 