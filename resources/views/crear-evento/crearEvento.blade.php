@extends('layouts.app')

@section('content')
    <div class="container">
        <form class="row g-4 needs-validation" method="POST" novalidate id="formularioCrearEvento">
            @csrf
            <div class="col-md-12">
                <h5>Crear evento</h5>
            </div>

            <div class="col-md-5 border-end">

                <div class="col-md-12">
                    <label for="nombreDelEvento" class="form-label">Nombre del evento *</label>
                    <input name="nombre" type="text" class="form-control" id="nombreDelEvento"
                        placeholder="Ingrese el nombre del evento" required>
                    <div class="invalid-feedback">
                        El nombre no puede estar vacio.
                    </div>
                </div>

                <div class="row mt-3">

                    <div class="col-md-6">
                        <label for="tipoDelEvento" class="form-label">Tipo de evento</label>
                        <!-Cargar tipos de evento->
                            <select name="id_tipo_evento" class="form-select" id="tipoDelEvento"
                                aria-placeholder="Elija un tipo de evento..." required>
                                <option value="">Tipo de evento 1</option>
                            </select>
                            <div class="invalid-feedback">
                                Seleccione un tipo de evento.
                            </div>
                    </div>

                    <div class="col-md-6">
                        <label for="gradoDelEvento" class="form-label">Grado</label>
                        <input name="" type="text" class="form-control" id="gradoDelEvento"
                            placeholder="Ingrese el grado del evento" required>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>

                </div>

                <div class="row mt-3">

                    <div class="col-md-6">
                        <label for="institucionDelEvento" class="form-label">Institución</label>
                        <input name="" type="text" class="form-control" id="institucionDelEvento"
                            placeholder="Ingrese la institución del evento" required>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="regionDelEvento" class="form-label">Región</label>
                        <input name="" type="text" class="form-control" id="regionDelEvento"
                            placeholder="Ingrese el grado del evento" required>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>

                </div>

                <div class="col-md-12 mt-3">
                    Configuración del evento
                </div>

                <div class="row">

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <input name="" type="checkbox" class="form-check-input border-dark" id="generoCheck">
                            <label for="genero" class="form-label">Género</label>
                            <select class="form-select" name="" id="genero" disabled>
                                <option value="femenino">Femenino</option>
                                <option value="masculino">Masculino</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <input name="evento_pago" type="checkbox" class="form-check-input border-dark" id="edadCheck">
                            <label for="limiteDeEdad" class="form-label">Limite de edad</label>
                            <select name="limite_edad" id="limiteDeEdad" class="form-select" disabled>
                                <!--Edades de ejemplo-->
                                @for ($i = 10; $i <= 99; $i++)
                                    <option>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">

                        <div class="col-md-6">
                            <input name="por_equipos" type="checkbox" class="form-check-input border-dark" id="equipoCheck">
                            <label class="form-check-label" for="equipoCheck">Por equipos</label>
                        </div>

                        <div class="col-md-6">
                            <input name="requiere_registro" type="checkbox" class="form-check-input border-dark" id="registroCheck">
                            <label class="form-check-label" for="registroCheck">Requiere registro</label>
                        </div>

                    </div>

                    <div class="row mt-3">

                        <div class="col-md-6 mt-2">
                            <input name="evento_pago" type="checkbox" class="form-check-input border-dark" id="eventoPagoCheck">
                            <label class="form-check-label" for="eventoPagoCheck">Evento de pago</label>
                        </div>

                        <div class="col-md-6">
                            <div class="row ">
                                <div class="col-md-4">
                                    <label class="col-form-label" for="costoEvento">Costo</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Bs.</span>
                                        <input name="competencia_general" type="number" class="form-control"
                                            min="0" id="costoEvento" step="0.5" value="0.0">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-7">

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
                        <input name="inicio_evento" id="fechaInicio" class="form-control" type="date"
                            min="<?php echo date('Y-m-d'); ?>" required />
                    </div>

                    <div class="col-md-2">Fin</div>

                    <div class="col-md-4">
                        <input name="fin_evento" id="fechaFin" class="form-control" type="date" required />
                    </div>

                </div>

                <div class="col-md-12">
                    <label for="descripcionDelEvento" class="form-label">Descripción del evento</label>
                    <textarea name="descripcion" class="form-control" id="descripcionDelEvento" rows="8" style="resize: none;"
                        placeholder="Ingrese una descripcion..."></textarea>
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

    </div>

    <script src="{{ asset('js/crearEvento.js') }}" defer></script>
@endsection
