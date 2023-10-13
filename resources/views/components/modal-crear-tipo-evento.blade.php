<div>
    <!-- Modal -->
    <div class="modal fade" id="modalCrearTipoEvento" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalCrearTipoEventoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="contenedor-titulo">
                        <h5 class="modal-title" id="modalCrearTipoEventoLabel">Crear tipo de evento</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formularioTipoEvento" class="needs-validation" novalidate>
                        @csrf
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="nombreTipoEvento" class="form-label">Nombre del tipo
                                        de evento *</label>
                                    <input name="nombre" type="text" class="form-control custom-input"
                                        id="nombreTipoEvento" value="" required
                                        placeholder="Ingrese el nombre del tipo de evento" maxlength="64">
                                    <div class="invalid-feedback">
                                        El nombre no puede estar vacio.
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-3">
                                    <label for="detalleTipoEvento" class="form-label">Descripción del
                                        evento</label>
                                    <textarea name="descripcion" class="form-control" id="detalleTipoEvento" rows="6" style="resize: none;" required
                                        placeholder="Ingrese una descripción..." maxlength="500"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row align-items-end">
                                        <div class="col-md-5 mt-3">
                                            <label for="colorTipoEvento" class="form-label">Color de
                                                referencia</label>
                                        </div>
                                        <div class="col-md-1 mt-3 custom-col">
                                            <input name="color" type="color" class="form-control form-control-color"
                                                id="colorTipoEvento" value="#563d7c" title="Choose your color">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="reset" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                                <button id="confirmarBoton" type="submit" class="btn btn-primary">Confirmar</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
