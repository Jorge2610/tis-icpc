<div>
    <div class="modal fade" id="modalConfirmacion" tabindex="-1" aria-labelledby="modalConfirmacionLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalConfirmacionLabel">Confirmación</h5>
                </div>
                <div class="modal-body">
                    @if (Route::currentRouteName() == 'evento.editar')
                        ¿Está seguro de editar evento?
                    @else
                        ¿Está seguro de crear evento?
                    @endif
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary w-25 mx-8" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary w-25 mx-8">Sí</button>
                </div>
            </div>
        </div>
    </div>
</div>
