<div>
    <div class="modal fade" id="modalAgregarPatrocinador" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalAgregarPatrocinadorLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar
                        patrocinador
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="resetModal('modalAgregarPatrocinador', 'formularioAgregarPatrocinador')"></button>
                </div>
                <form class="needs-validation" method="POST" novalidate id="formularioAgregarPatrocinador">
                    @csrf
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4">
                                    <input name="logo" type="file" class="form-control custom-input" id="validationCustomImage"
                                        required style="display: none;" accept="image/*"
                                        onchange="previewSponsorLogo(event)">
                                    <label for="validationCustomImage" class="custom-file-upload">
                                        <div id="sponsorPreview">
                                        </div>
                                    </label>
                                    <div class="invalid-feedback">
                                        Se requiere una imagen.
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="validationCustomName" class="form-label">Nombre
                                                del patrocinador *</label>
                                                <input name="id_evento" type="hidden" id="id_evento"  value="{{ $evento->id }}">
                                                <input name="nombre" type="text" class="form-control custom-input"
                                                id="validationCustomName" value="" placeholder="Ingrese un nombre"
                                                required>
                                            <div class="invalid-feedback">
                                                El nombre no puede estar vacio.
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <label for="validationCustomLink" class="form-label">Enlace
                                                a la pagina web del patrocinador</label>
                                            <input name="enlace_web" type="url" class="form-control custom-input"
                                                id="validationCustomLink" value=""
                                                placeholder="https://www.patrocinador.com">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary custom-btn" data-bs-dismiss="modal"
                        onclick="resetModal('modalAgregarPatrocinador', 'formularioAgregarPatrocinador')">Cancelar</button>
                    <button type="button" onclick="guardarPatrocinador()" class="btn btn-primary">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
</div>
