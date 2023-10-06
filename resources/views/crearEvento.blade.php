@extends('layouts.app')

@section('content')
    <div class="container">
        <form class="row g-4">
            <div class="col-4 border-end">
                <div class="col-md-12">
                    <h5>Crear evento</h5>
                </div>
                <div class="col-md-12">
                    <label for="nombreDelEvento" class="form-label">Nombre del evento*</label>
                    <input type="text" class="form-control" id="nombreDelEvento">
                </div>
                <div class="row mt-3">
                    <div class="col-md-8">
                        <label for="tipoDelEvento" class="form-label">Tipo de evento</label>
                        <input type="text" class="form-control" id="tipoDelEvento">
                    </div>
                    <div class="col-md-4">
                        <label for="limiteDeEdad" class="form-label">Limite de edad</label>
                        <select id="limiteDeEdad" class="form-select">
                            <!--Edades de ejemplo-->
                            @for ($i = 15; $i <= 25; $i++)
                                <option>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    Afiche del evento
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <div class="col-md-4">
                        <input type="file" class="form-control custom-input" id="validationCustom03" required
                            style="display: none;" accept="image/*" onchange="previewImage(event)">
                        <label for="validationCustom03" class="custom-file-upload">
                            <div class="col-md-12 border">
                                <img src="{{ URL::asset('/image/uploading.png') }}" class="img" alt="logo_departamento"
                                    id="imagePreview" width="200vh">
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="col-md-12">
                    <label for="descripcionDelEvento" class="form-label">Descripción del evento</label>
                    <textarea class="form-control" id="descripcionDelEvento" rows="5" style="resize: none;"></textarea>
                </div>
                <div class="row">
                    <div class="col-md-8 border-end mt-3">
                        <div class="col-md-12">
                            <h6>Periodo de inscripción</h6>
                        </div>
                        <div class="row">
                            <div class="col-md-2">Inicio</div>
                            <div class="col-md-4">
                                <input id="fechaInscripcionInicio" class="form-control" type="date"
                                    min="<?php echo date('Y-m-d'); ?>" />
                            </div>
                            <div class="col-md-2">Fin</div>
                            <div class="col-md-4">
                                <input id="fechaInscripcionFin" class="form-control" type="date" />
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <h6>Duracion del evento</h6>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-2">Inicio</div>
                            <div class="col-md-4">
                                <input id="fechaInicio" class="form-control" type="date" min="<?php echo date('Y-m-d'); ?>" />
                            </div>
                            <div class="col-md-2">Fin</div>
                            <div class="col-md-4">
                                <input id="fechaFin" class="form-control" type="date" />
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <input type="checkbox" class="form-check-input" id="eventoPagoCheck">
                                <label class="form-check-label" for="eventoPagoCheck">Evento de pago</label>
                            </div>
                            <div class="col-md-6">
                                <input type="checkbox" class="form-check-input" id="competenciaGeneralCheck">
                                <label class="form-check-label" for="competenciaGeneralCheck">Competencia general</label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <input type="checkbox" class="form-check-input" id="equipoCheck">
                                <label class="form-check-label" for="equipoCheck">Por equipos</label>
                            </div>
                            <div class="col-md-6">
                                <input type="checkbox" class="form-check-input" id="registroCheck">
                                <label class="form-check-label" for="registroCheck">Requiere registro</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3 px-4">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                Patrocinadores
                            </div>
                            <div class="col-md-7">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-light btn-lg" data-bs-toggle="modal"
                                    data-bs-target="#modalCrearTipoEvento">
                                    +
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="modalCrearTipoEvento" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCrearTipoEventoLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalCrearTipoEventoLabel">Agregar
                                                    patrocinador
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="container">
                                                    <div class="row">
                                                        <!-- Column for the image -->
                                                        <div class="col-md-4">
                                                            <input type="file" class="form-control custom-input"
                                                                id="validationCustom03" required style="display: none;"
                                                                accept="image/*" onchange="previewImage(event)">
                                                            <label for="validationCustom03" class="custom-file-upload">
                                                                <div id="imagePreview"
                                                                    style="background-image: url('image/uploading.png');">
                                                                </div>
                                                            </label>
                                                            <div class="valid-feedback">
                                                                Looks good!
                                                            </div>
                                                        </div>
                                                        <!-- Column for the rest of the form -->
                                                        <div class="col-md-8">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label for="validationCustom01"
                                                                        class="form-label">Nombre
                                                                        del patrocinador*</label>
                                                                    <input type="text"
                                                                        class="form-control custom-input"
                                                                        id="validationCustom01" value="" required>
                                                                    <div class="valid-feedback">
                                                                        Looks good!
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 mt-3">
                                                                    <label for="validationCustom02"
                                                                        class="form-label">Enlace
                                                                        a la pagina web del patrocinador</label>
                                                                    <input type="url"
                                                                        class="form-control custom-input"
                                                                        id="validationCustom02" value="" required>
                                                                    <div class="valid-feedback">
                                                                        Looks good!
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary custom-btn"
                                                    data-bs-dismiss="modal">Cancelar</button>
                                                <button type="button" class="btn btn-primary">Confirmar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 px-4">
                            <p>Sponsor1</p>
                        </div>
                    </div>
                </div>

                <div class="row mt-3 text-center">
                    <div class="col-md-6">
                        <button type="reset" class="btn btn-light text-primary">Cancelar</button>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">Confirmar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
