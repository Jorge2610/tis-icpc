<div class="modal fade" id="modal-inscribir" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <for id="inscribirEquipo" class="needs-validation" novalidate>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Registrar equipo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                                            
            <div class="modal-body">
                <div class="justify-content-center" id="containerNombre">
                    <label class="form-label" for="documentoDeIdentificacion">
                        <h6>Nombre del equipo*</h6>
                    </label>
                    <input evento_id={{$evento->id}} id="nombreEquipo" type="text" class="form-control" 
                    placeholder="Ingrese el nombre de equipo">
                    <div class="invalid-feedback" id="mensajeErrorNombre">
                    El nombre no puede estar vacío.
                    </div>
                </div>
                
                    <div id="contenedorCorreo" class="mt-3">
                        <label for="inputEmail">
                            <h6>Correo electrónico*</h6>
                        </label>
                        <input type="email" class="form-control" id="inputEmail" 
                        aria-describedby="emailHelp" placeholder="Ingresa tu correo electrónico" required>
                        <div class="invalid-feedback" id="mensajeErrorCorreo">
                            El correo no puede estar vacío.
                        </div>
                    </div>
                    <div id="codigoValidacion" style="display: none;">
                        <label for="codigo1">
                            <h6>Código de acceso*</h6>
                        </label>
                        <input type="text" id="codigo1" class="form-control">
                        <div class="invalid-feedback">
                            Código no valido.
                        </div>
                            <div class="text-muted" style="font-size: 15 px">
                                Se envio un código a su correo.
                            </div>
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
            <div class="modal-footer">
                <button id="button-equipo-cancelar"type="button"
                 class="btn btn-secondary" onclick="cancelarEquipo()">
                    Cancelar
                </button>
                <button id="button-equipo-confirmacion"  type="button" 
                class="btn btn-primary"  onclick="ingresarNombreEquipo()">
                    Inscribir
                </button>
            </div>
        </div>
        </for>
    </div>
</div>
<script src="{{ asset('js/Inscripciones/inscribirEquipo.js') }}" defer></script>