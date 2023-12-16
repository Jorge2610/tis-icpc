<div class="modal fade" id="modal-inscribir" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Inscribirme al Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                                            
            <div class="modal-body">
                <div class="justify-content-center">
                    <label class="col-form-label" for="documentoDeIdentificacion">
                       <h5>C.I.</h5>
                    </label>
                    <input id="documentoDeIdentificacion" type="nuber" class="form-control">
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href={{ route('evento.inscripcion', ['id' => $evento->id]) }} type="button" class="btn btn-primary" >Inscribirme</a>
            </div>
        </div>
    </div>
</div>