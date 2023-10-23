<div>
    <div class="modal fade" id="modalCancelar" tabindex="-1" aria-labelledby="modalCancelarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCancelarLabel">Confirmación</h5>
                </div>
                <div class="modal-body">
                    @if (Route::currentRouteName() == 'evento.editar')
                        ¿Está seguro de cancelar la edicion del evento?
                    @else
                        ¿Está seguro de cancelar el evento?
                    @endif
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary w-25 mx-8" data-bs-dismiss="modal">No</button>
                    <button type="reset" class="btn btn-primary w-25 mx-8" data-bs-dismiss="modal"
                        onclick="cerrar({{ Route::currentRouteName() == 'evento.editar' }})">Sí</button>
                </div>
            </div>
        </div>
    </div>
</div>
