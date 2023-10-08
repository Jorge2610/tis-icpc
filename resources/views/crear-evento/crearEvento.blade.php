@extends('layouts.app')

@section('content')
    <div class="container">
        <form class="row g-4 needs-validation" method="POST" novalidate id="formularioCrearEvento">
            @csrf
            <div class="col-md-4 border-end">
                <div class="col-md-12">
                    <h5>Crear evento</h5>
                </div>
                <div class="col-md-12">
                    <label for="nombreDelEvento" class="form-label">Nombre del evento *</label>
                    <input name="nombre" type="text" class="form-control" id="nombreDelEvento"
                        placeholder="Ingrese el nombre del evento" required>
                    <div class="invalid-feedback">
                        El nombre no puede estar vacio.
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-8">
                        <label for="tipoDelEvento" class="form-label">Tipo de evento</label>
                        <!-Cargar tipos de evento->
                            <select name="id_tipo_evento" class="form-select" id="tipoDelEvento" aria-placeholder="Elija un tipo de evento..."
                                required>
                                <option value="">Tipo de evento 1</option>
                            </select>
                            <div class="invalid-feedback">
                                Seleccione un tipo de evento.
                            </div>
                    </div>
                    <div class="col-md-4">
                        <label for="limiteDeEdad" class="form-label">Limite de edad</label>
                        <select name="limite_edad" id="limiteDeEdad" class="form-select">
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
                        <input name="imagen" type="file" class="form-control input" id="validacionAfiche" style="display: none;"
                            accept="image/*" onchange="previewAfiche(event)">
                        <label for="validacionAfiche" class="file-upload">
                            <div class="col-md-12 border">
                                <img src="{{ URL::asset('/image/uploading.png') }}" class="img-fluid" alt="aficheImg"
                                    id="afiche">
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="col-md-12">
                    <label for="descripcionDelEvento" class="form-label">Descripción del evento</label>
                    <textarea name="descripcion" class="form-control" id="descripcionDelEvento" rows="5" style="resize: none;" placeholder="Ingrese una descripcion..."></textarea>
                </div>
                <div class="row">
                    <div class="col-md-8 border-end mt-3">
                        <div class="col-md-12">
                            <h6>Periodo de inscripción</h6>
                        </div>
                        <div class="row">
                            <div class="col-md-2">Inicio</div>
                            <div class="col-md-4">
                                <input name="inicio_inscripcion" id="fechaInscripcionInicio" class="form-control" type="date"
                                    min="<?php echo date('Y-m-d'); ?>" />
                            </div>
                            <div class="col-md-2">Fin</div>
                            <div class="col-md-4">
                                <input name="fin_inscripcion" id="fechaInscripcionFin" class="form-control" type="date" />
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <h6>Duracion del evento *</h6>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-2">Inicio</div>
                            <div class="col-md-4">
                                <input name="inicio_evento" id="fechaInicio" class="form-control" type="date" min="<?php echo date('Y-m-d'); ?>" required/>
                            </div>
                            <div class="col-md-2">Fin</div>
                            <div class="col-md-4">
                                <input name="fin_evento" id="fechaFin" class="form-control" type="date" required/>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <input name="evento_pago" type="checkbox" class="form-check-input" id="eventoPagoCheck">
                                <label class="form-check-label" for="eventoPagoCheck">Evento de pago</label>
                            </div>
                            <div class="col-md-6">
                                <input name="competencia_general" type="checkbox" class="form-check-input" id="competenciaGeneralCheck">
                                <label class="form-check-label" for="competenciaGeneralCheck">Competencia general</label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <input name="por_equipos" type="checkbox" class="form-check-input" id="equipoCheck">
                                <label class="form-check-label" for="equipoCheck">Por equipos</label>
                            </div>
                            <div class="col-md-6">
                                <input name="requiere_registro" type="checkbox" class="form-check-input" id="registroCheck">
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
                                <button type="button" class="btn btn-light btn-lg" data-bs-toggle="modal"
                                    data-bs-target="#modalAgregarPatrocinador">
                                    +
                                </button>
                                <!-El modal esta ubicado fuera de el form principal->
                            </div>
                        </div>
                        <div class="col-md-12 px-4">
                            <!-Hacer que se muestre el nombre de los patrocinadores que se van agregando->
                            <p>Patrocinador1</p>
                        </div>
                    </div>
                </div>

                <div class="row mt-4 text-center">
                    <div class="col-md-6">
                        <!-Añadir el modal de confirmacion antes de hacer el reset al form->
                        <button type="reset" class="btn btn-light text-primary">Cancelar</button>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">Confirmar</button>
                    </div>
                </div>
            </div>
        </form>
        <x-ModalAgregarPatrocinador/>
    </div>

    <script src="{{ asset('js/crearEvento.js') }}" defer></script>
@endsection
