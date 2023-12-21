<div class="modal fade" id="modal-inscribir" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Inscribirse al evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    onclick="resetModal()"></button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate id="formModalInscripcion">
                    <div class="justify-content-center">
                        <div class="mb-2">
                            <label for="carnetParticipante" class="form-label">
                                <h6>Número de carnet *</h6>
                            </label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="carnetParticipante"
                                    pattern="[0-9]{6,10}[\-]?[0-9A-Z]*" placeholder="Ingrese su número de carnet"
                                    onkeyup="setCarnetFeedBack()" maxlength="16" required>
                                    <select class="custom-select" id="selectPais">
                                    </select>
                                <div id="validacionCarnetFeedback" class="invalid-feedback" style="font-size: 14px">
                                    El número de carnet no puede estar vacio.
                                </div>
                                
                            </div>
                        </div>
                        <div style="display: none" id="displayCodAcceso">
                            <div class="mb-2">
                                <label for="codParticipante" class="form-label">
                                    <h6>Código de acceso *</h6>
                                </label>
                                <input type="text" class="form-control" id="codParticipante" pattern=".+"
                                    placeholder="Ingrese el código de acceso">
                                <div class="invalid-feedback" style="font-size: 14px">
                                    El código ingresado es incorrecto.
                                </div>
                            </div>
                            <div class="text-muted" style="font-size: 15px" id="correoParticipante"></div>
                            <div class="row">
                                <div class="col-md-auto d-flex align-items-center">
                                    <h6 class="mb-0 text-muted">¿No recibiste el código de acceso?</h6>
                                </div>
                                <div class="col-md-auto">
                                    <div class="btn btn-ligth text-primary" type="button" onclick="reEnviarCodigo()">
                                        <u>Reenviar código</u>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    onclick="resetModal()">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="validarDatos({{ $evento->id }})" id="botonPrincipal">
                    Inscribirme
                </button>
            </div>
        </div>
    </div>
</div>
<link href="{{ asset('css/participante.css') }}" rel="stylesheet">
<script src="{{ asset('js/Inscripciones/codPaises.js') }}" defer></script>
<script src="{{ asset('js/Inscripciones/inscribirParticipante.js') }}" defer></script>
