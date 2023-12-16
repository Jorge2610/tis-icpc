<div class="modal fade" id="modal-inscribir" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Inscribirme al Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                                            
            <div class="modal-body">
                <div class="justify-content-center" id="containerNombre">
                    <label class="col-form-label" for="documentoDeIdentificacion">
                       <h5>Nombre del equipo</h5>
                    </label>
                    <input id="nombreEquipo" type="text" class="form-control" >
                    <div class="invalid-feedback">
                    El nombre no puede estar vacío.
                    </div>
                </div>
                {{-- crear equipo --}}
                <div class="collapse mt-2" id="collapGmail" >
                <div class="card card-body" style="min-height: auto;">
                    <div id="contenedorCorreo">
                        <label for="inputEmail">Correo Electrónico</label>
                        <input type="email" class="form-control" id="inputEmail" 
                        aria-describedby="emailHelp" placeholder="Ingresa tu correo electrónico" required>
                    </div>
                    <div id="codigoValidacion" style="display: none;">
                        <p>Enviamos un codigo a su correo coloque el código</p>
                        <label for="codigo1">Codigo</label>
                        <input type="text" id="codigo1" class="form-control" >
                    </div>
                </div>
                </div>
                {{-- validcion gmail --}}
                <div class="collapse" id="collapseVerificaiconGmail">
                <div class="card card-body">
                <p>Este nombre de grupo ya fue registrado, hemos enviado un codigo al registrado correo.</p>
                        <label for="codigo1">Codigo</label>
                        <input type="text" id="codigo1" class="form-control" >
                        <div class="col-md-12 p-3">
                            <button type="button" class="btn btn-secondary btn-sm">Atras</button>
                            <button type="button" class="btn btn-primary btn-sm" 
                            onclick="registrarEquipo()">
                                Enviar
                            </button> 
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
    </div>
</div>
<script src="{{ asset('js/Inscripciones/inscribirEquipo.js') }}" defer></script>