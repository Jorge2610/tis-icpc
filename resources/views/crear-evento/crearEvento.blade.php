@extends('layouts.app')
@section('content')
    <div class="container">
        <form class="row g-4 needs-validation mt-1" method="POST" novalidate id="formularioCrearEvento">
            @csrf
            <input type="hidden" name="evento_id" value="{{ isset($datos['evento_id']) ? $datos['evento_id'] : '' }}">
            <input type="hidden" id="imagen" name='imagen'
                value="{{ isset($datos['ruta_afiche']) ? $datos['ruta_afiche'] : '' }}">
            <div class="col-md-12">
                @if (Route::currentRouteName() == 'evento.editar')
                    <h2 id="titulo">Editar evento</h2>
                @else
                    <h2 id="titulo">Crear evento</h2>
                @endif
            </div>
            <div class="col-md-6 border-end">
                <div class="col-md-12">
                    <label for="nombreDelEvento" class="form-label">Nombre del evento *</label>
                    <input name="nombre" type="text" class="form-control fecha-editar" id="nombreDelEvento"
                        onchange="datoCambiado()" placeholder="Ingrese el nombre del evento" maxlength="64"
                        value="{{ isset($datos['nombreDelEvento']) ? $datos['nombreDelEvento'] : '' }}" required>
                    <div id="mensajeNombre" class="invalid-feedback">
                        El nombre no puede estar vacio.
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <label for="tipoDelEvento" class="form-label">Tipo de evento</label>
                        <!-Cargar tipos de evento->
                            <select name="id_tipo_evento" class="form-select fecha-editar" id="tipoDelEvento"
                                onchange="datoCambiado()" aria-placeholder="Elija un tipo de evento..."
                                data-id="{{ $datos['id_tipo_evento'] }}" required>
                            </select>
                            <div class="invalid-feedback">
                                Seleccione un tipo de evento.
                            </div>
                    </div>
                    <div class="col-md-6">
                        <label for="select-region" class="form-label">Región</label>
                        <select class="form-select" name="region" id="select-region" required>
                            @foreach (['Internacional', 'Nacional', 'Departamental'] as $regionDato)
                                <option value="{{ $regionDato }}" @if ($datos['region'] == $regionDato || 'Departamental' == $regionDato) selected @endif>
                                    {{ $regionDato }}
                                </option>
                                @if ($datos['region'] == $regionDato && date('Y-m-d') >= $datos['inicio_inscripcion'])
                                @break;
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-6 col-md-12 mb-3 ">
                    <button id="btnGroupDrop1" type="button" class="btn dropdown-toggle w-100 text-start ps-3 pt-2 pb-2 "
                        style ="border-color: rgb(207, 207, 207)" data-bs-toggle="dropdown" aria-expanded="false">
                        Instituciones admitidas
                    </button>
                    <ul class="dropdown-menu p-3 col-lg-2 col-md-4" id="ul-institucion" aria-labelledby="btnGroupDrop1"
                        data-institucion="{{ $datos['institucion'] }}">
                        @foreach (['TODAS', 'UMSS', 'UMSA', 'UPSA', 'UCB', 'UPB', 'UNIFRANZ'] as $institucion)
                            <li @if ($institucion == 'Todas') id="todas-institucion" @endif>
                                <input class="form-check-input institucion border-dark" type="checkbox"
                                    value="{{ $institucion }}" id="check-institucion-{{ $institucion }}">
                                <label class="form-check-label" for="check-institucion-{{ $institucion }}">
                                    {{ $institucion }}
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-6 col-md-12">
                    <button id="boton-grado" type="button" class="btn dropdown-toggle w-100 text-start ps-3 pt-2 pb-2"
                        style ="border-color: rgb(207, 207, 207)" data-bs-toggle="dropdown" aria-expanded="false">
                        Grado académico requerido
                    </button>
                    <ul class="dropdown-menu p-3 col-lg-2 col-md-4" id="ul-grado" aria-labelledby="boton-grado"
                        data-grado="{{ $datos['grado_academico'] }}">
                        @foreach (['Todas', 'Primaria', 'Secundaria', 'Universidad', 'Licenciatura', 'Maestria', 'Doctorado'] as $grado)
                            <li @if ($grado == 'Todas') id="todas-grado" @endif>
                                <input class="form-check-input grado-requerido border-dark" type="checkbox"
                                    value="{{ $grado }}" id="input-grado-{{ $grado }}">
                                <label class="form-check-label" for="input-grado-{{ $grado }}">
                                    {{ $grado }}
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-md-12 mt-3">
                Configuración del evento
            </div>

            <div class="row">

                <div class="row mt-4">
                    <div class="col-md-6">
                        <input name="evento_genero" type="checkbox" class="form-check-input border-dark"
                            id="generoCheck" onchange="datoCambiado()" data-id="{{ $datos['genero'] }}"
                            @if ($datos['genero']) checked @endif>
                        <label for="genero" class="form-check-label">Género admitido</label>
                        <select class="form-select fecha-editar" name="genero" id="genero" style="display:none;">
                            @foreach (['Femenino', 'Masculino'] as $sexo)
                                <option value="{{ $sexo }}" @if ($datos['genero'] == $sexo) selected @endif>
                                    {{ $sexo }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <input name="rango_edad" type="checkbox" class="form-check-input border-dark fecha-editar"
                            id="edadCheck" onchange="datoCambiado()" data-id="{{ $datos['edad_minima'] }}"
                            @if ($datos['edad_minima']) checked @endif>
                        <label for="limiteDeEdad" class="form-check-label">Rango de edad</label>
                        <div class="valid-feedback" id="ValidoRangoEdad">
                            </div>
                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                Rango de edades no válido
                            </div>
                        <div class="row" id="rangosDeEdad" style="display: none;">
                            <div class="col-md-6">
                                <div class="row " id="rangoMin">
                                    <div class="col-md-3">
                                        <label for="edadMinima" class="form-label">Min</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input name="edad_minima" type="number"
                                                class="form-control input-edad fecha-editar" min="10"
                                                id="edadMinima" step="1" max="99"
                                                value="{{ isset($datos['edad_minima']) ? $datos['edad_minima'] : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row " id="rangoMax">
                                    <div class="col-md-3">
                                        <label for="edadMaxima" class="form-label">Max</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input name="edad_maxima" type="number"
                                                class="form-control input-edad fecha-editar" id="edadMaxima"
                                                step="1" min="10" max="99"
                                                value="{{ isset($datos['edad_maxima']) ? $datos['edad_maxima'] : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">

                    <div class="col-md-6">
                        <input name="evento_equipos" type="checkbox"
                            class="form-check-input border-dark fecha-editar" onchange="datoCambiado()"
                            id="equipoCheck" @if ($datos['evento_equipos']) checked @endif>
                        <label class="form-check-label " for="equipoCheck">Por equipos</label>
                    </div>

                    <div class="col-md-6">
                        <input name="requiere_registro" type="checkbox"
                            class="form-check-input border-dark fecha-editar" onchange="datoCambiado()"
                            id="registroCheck" @if ($datos['requiere_registro']) checked @endif>
                        <label class="form-check-label" for="registroCheck">Requiere registro</label>
                    </div>

                </div>

                <div class="row mt-4">

                    <div class="col-md-6 mt-2">
                        <input name="evento_pago" type="checkbox" class="form-check-input border-dark fecha-editar"
                            onchange="datoCambiado()" id="eventoPagoCheck"
                            data-id="{{ $datos['precio_inscripcion'] }}"
                            @if ($datos['precio_inscripcion']) checked @endif>
                        <label class="form-check-label" for="eventoPagoCheck">Evento de pago</label>
                    </div>

                    <div class="col-md-6">
                        <div class="row " id="eventoPago" style="display: none;">
                            <div class="col-md-4">
                                <label class="col-form-label" for="costoEvento">Costo</label>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Bs.</span>
                                    <input name="precio_inscripcion" type="number" class="form-control fecha-editar"
                                        min="1" id="costoEvento" step="0.5"
                                        value="{{ isset($datos['precio_inscripcion']) ? $datos['precio_inscripcion'] : '0.0' }}">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-6">



            <div class="col-md-12 mt-4  ms-3">
                <h6>Duración del evento *</h6>
            </div>

            <div class="row mt-3 ms-3">

                <div class="col-md-1 col-sm-3 align-self-center">Inicio:</div>

                <div class="col-lg-12 col-md-12 col-sm-9">
                    <input name="inicio_evento" id="fechaInicio" class="form-control fecha-editar"
                        type="datetime-local" onchange="datoCambiado()" min=""
                        value="{{ isset($datos['inicio_evento']) ? $datos['inicio_evento'] : '' }}" required />
                </div>

                <div class="col-md-1 col-sm-3 align-self-center">Fin:</div>

                <div class="col-lg-12 col-md-12 col-sm-9">
                    <input name="fin_evento" id="fechaFin" class="form-control" type="datetime-local"
                        onchange="datoCambiado()" min=""
                        value="{{ isset($datos['fin_evento']) ? $datos['fin_evento'] : '' }}" required />
                </div>

            </div>

            <div class="col-md-12 mt-5  ms-3">
                <label for="descripcionDelEvento" class="form-label">Descripción del evento</label>
                <textarea name="descripcion" class="form-control" id="descripcionDelEvento" rows="8" style="resize: none;"
                    onchange="datoCambiado()" placeholder="Ingrese una descripción..." maxlength="2048">{{ $datos['descripcionDelEvento'] }}</textarea>
            </div>

            <div class="row mt-4 text-center">
                <div class="col-md-6">
                    <!-Añadir el modal de confirmacion antes de hacer el reset al form->
                        <button type="button" class="btn btn-light text-primary" data-bs-toggle="modal"
                            data-bs-target="#modalCancelar">
                            Cancelar
                        </button>
                        @component('components.modal')
                            @slot('modalId', 'modalCancelar')
                            @slot('modalTitle', 'Confirmacion')
                            @slot('modalContent')
                                @if (Route::currentRouteName() == 'evento.editar')
                                    ¿Está seguro de cancelar la edición del evento?
                                @else
                                    ¿Está seguro de cancelar el evento?
                                @endif
                            @endslot
                            @slot('modalButton')
                                <button type="button" class="btn btn-secondary w-25 mx-8"
                                    data-bs-dismiss="modal">No</button>
                                <button type="reset" class="btn btn-primary w-25 mx-8" data-bs-dismiss="modal"
                                    onclick="cerrar()">Sí</button>
                            @endslot
                        @endcomponent
                </div>
                <div class="col-md-6">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modalConfirmacion">
                        Confirmar
                    </button>
                    @component('components.modal')
                        @slot('modalId', 'modalConfirmacion')
                        @slot('modalTitle', 'Confirmacion')
                        @slot('modalContent')
                            @if (Route::currentRouteName() == 'evento.editar')
                                ¿Está seguro de editar el evento?
                            @else
                                ¿Está seguro de crear el evento?
                            @endif
                        @endslot
                        @slot('modalButton')
                            <button type="button" class="btn btn-secondary w-25 mx-8" data-bs-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-primary w-25 mx-8">Sí</button>
                        @endslot
                    @endcomponent
                </div>
            </div>

        </div>

    </form>

    <div class="col-12 mt-4"></div>

</div>
<script src="{{ asset('js/Evento/crearEvento.js') }}" defer></script>
<script src="{{ asset('js/Evento/validarEvento.js') }}" defer></script>
@endsection
