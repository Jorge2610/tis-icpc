<div class="modal fade" id="modal-inscribir" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <for id="inscribirEquipo" class="needs-validation" novalidate>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Registar equipo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                                            
            <div class="modal-body">
                <div class="justify-content-center" id="containerNombre">
                    <label class="form-label" for="documentoDeIdentificacion">
                       Nombre del equipo
                    </label>
                    <input evento_id={{$evento->id}} id="nombreEquipo" type="text" class="form-control" 
                    placeholder="Ingrese el nombre de equipo">
                    <div class="invalid-feedback">
                    El nombre no puede estar vacío.
                    </div>
                </div>
                
                    <div id="contenedorCorreo" class="mt-3">
                        <label for="inputEmail">Correo Electrónico</label>
                        <input type="email" class="form-control" id="inputEmail" 
                        aria-describedby="emailHelp" placeholder="Ingresa tu correo electrónico" required>
                        <div class="invalid-feedback">
                            El correo no puede estar vacío.
                        </div>
                    </div>
                    <div id="codigoValidacion" style="display: none;">
                        <p>Enviamos un codigo a su correo coloque el código</p>
                        <label for="codigo1">Codigo</label>
                        <input type="text" id="codigo1" class="form-control">
                        <div class="invalid-feedback">
                            Código no valido.
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