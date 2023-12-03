@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5" style="min-height: 500px">
                <h2 class="text-center">Crear tipo de evento</h2>
                <form id="formularioTipoEvento" class="needs-validation" novalidate>
                    @csrf
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="nombreTipoEvento" class="form-label">Nombre del tipo
                                    de evento *</label>
                                <input name="nombre" type="text" class="form-control custom-input" id="nombreTipoEvento"
                                    value="" required placeholder="Ingrese el nombre del tipo de evento"
                                    maxlength="64" autocomplete="off">
                                <div id="mensajeNombre" class="invalid-feedback">
                                    El nombre no puede estar vacío.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <label for="detalleTipoEvento" class="form-label">Descripción del tipo de evento</label>
                                <textarea name="descripcion" class="form-control" id="detalleTipoEvento" rows="6" style="resize: none;"
                                    placeholder="Ingrese una descripción..." maxlength="500"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row contenedor-titulo-color">
                                    <div class="contenedor-subtitulo">
                                        <div class=" mt-3">
                                            <label for="colorTipoEvento" class="form-label text-container">Color de
                                                referencia</label>
                                        </div>
                                    </div>
                                    <div class=" mt-2 custom-col colum-col">
                                        <input name="color" type="color" class="form-control-color controlador"
                                            id="colorTipoEvento" value="#563d7c" title="Choose your color">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center my-5">
                            <button id="cancelarBoton" type="reset" class="btn btn-secondary mx-5"
                                onClick="quitarValidacion()">Cancelar</button>
                            <button id="confirmarBoton" type="submit" class="btn btn-primary mx-5">Crear</button>
                        </div>
                </form>
                @component('components.modal')
                    @slot('modalId', 'modalTipoEventoExistente')
                    @slot('modalTitle', 'Tipo de evento ya existe')
                    @slot('modalContent')
                        <p>
                            <b>El tipo de evento que intentó crear ya existe,</b>
                            ¿Desea habilitarlo nuevamente?
                        </p>
                    @endslot
                    @slot('modalButton')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="limpiarForm()">
                            No</button>
                        <button type="button" class="btn btn-danger" onclick="restaurarTipoEvento()">Sí</button>
                    @endslot
                @endcomponent

                <div class="modal fade" id="modalActualizarTipoEvento" tabindex="-1" aria-labelledby="modalAnularLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content" style="width: 600px">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    ¿Desea actualizar los datos del tipo de evento?
                                </h5>
                            </div>
                            <div class="modal-body">
                                <div class="row g-4">
                                    <div class="col-md-12">
                                        <h5 id="nombre" class="text-center"></h5>
                                    </div>
                                    <div class="col-md-6 border-end border-2">

                                        <div class="container">
                                            <h6 class="text-center fw-bold">Anterior</h6>
                                            <p class="mt-3"><strong>Descripción:</strong></p>
                                            <div style="height: 100px; " class="overflow-auto">

                                                <p id="antiguoDescripcion" class ="text-break me-3 text-justify"
                                                    style="white-space: pre-line"></p>
                                            </div>
                                            <p class="mt-3"><strong>Color de referencia:</strong></p>
                                            <div id="antiguoColor" class="mx-auto" style="width: 50px; height: 50px; border-radius: 50%">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="container">
                                            <h6 class="text-center fw-bold">Nuevo</h6>
                                            <p class="mt-3"><strong>Descripción:</strong></p>
                                            <div style="height: 100px; text-align: justify" class="overflow-auto">

                                                <p id="nuevoDescripcion" class ="text-break me-3 text-justify"
                                                    style="white-space: pre-line"></p>
                                            </div>
                                            <p class="mt-3"><strong>Color de referencia:</strong></p>
                                            <div id="nuevoColor" class="mx-auto"
                                                style="width: 50px; height: 50px; border-radius: 50%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                    onclick="actualizarTipoEvento()">
                                    No</button>
                                <button type="button" class="btn btn-danger"
                                    onclick="actualizarTipoEvento(true)">Sí</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/TipoDeEvento/crearTipoEvento.js') }}" defer></script>
@endsection
