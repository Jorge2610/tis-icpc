@extends('layouts.app')

@section('content')
    <div class="container">
        <form class="row g-4 needs-validation mt-1" method="POST" novalidate id="formularioCrearEvento">
            @csrf
            <input type="hidden" name="evento_id" value="{{ isset($datos['evento_id']) ? $datos['evento_id'] : '' }}">
            <input type="hidden" id="imagen" name='imagen' value="{{isset($datos['ruta_afiche']) ? $datos['ruta_afiche'] : ''}}">
            <div class="col-md-12">
                @if(Route::currentRouteName() == 'evento.editar')
                    <h5 id="titulo">Editar evento</h5>
                @else
                    <h5 id="titulo">Crear evento</h5>
                @endif
            </div>

            <div class="col-md-5 border-end">

                <div class="col-md-12">
                    <label for="nombreDelEvento" class="form-label">Nombre del evento *</label>
                    <input name="nombre" type="text" class="form-control" id="nombreDelEvento" onchange="datoCambiado()"
                        placeholder="Ingrese el nombre del evento" maxlength="64" value="{{ isset($datos['nombreDelEvento'])? $datos['nombreDelEvento'] : ''}}" required>
                    <div class="invalid-feedback">
                        El nombre no puede estar vacio.
                    </div>
                </div>

                <div class="row mt-4">

                    <div class="col-md-6">
                        <label for="tipoDelEvento" class="form-label">Tipo de evento</label>
                        <!-Cargar tipos de evento->
                            <select name="id_tipo_evento" class="form-select" id="tipoDelEvento"
                                aria-placeholder="Elija un tipo de evento..." data-id="{{$datos['id_tipo_evento']}}"> 
                                
                            </select>
                            <div class="invalid-feedback">
                                Seleccione un tipo de evento.
                            </div>
                    </div>

                    <div class="col-md-6">
                        <label for="gradoDelEvento" class="form-label">Grado academico requerido</label>
                        <select name="grado_academico" class="form-select" id="gradoDelEvento"
                            aria-placeholder="Elija un tipo de evento...">
                            @foreach(['Ninguno', 'Primaria', 'Secundaria', 'Universidad', 'Licenciatura', 'Maestria', 'Doctorado'] as $grado)
                                <option value="{{ $grado }}" @if($datos['grado_academico'] == $grado) selected @endif>
                                    {{ $grado }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>

                </div>

                <div class="row mt-4">

                    <div class="col-md-6">
                        <label for="institucionDelEvento" class="form-label">Instituciones admitidas</label>
                        <input name="institucion" type="text" class="form-control" id="institucionDelEvento"
                            placeholder="Ingrese la institución del evento" value="{{ isset($datos['institucion'])? $datos['institucion'] : '' }}">
                        <div class="invalid-feedback">
                            Este campo no puede estar vacio.
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="regionDelEvento" class="form-label">Región</label>
                        <input name="region" type="text" class="form-control" id="regionDelEvento"
                            placeholder="Ingrese el grado del evento" maxlength="64"  value="{{ isset($datos['region'])? $datos['region']:''}}">
                    </div>
                </div>

                <div class="col-md-12 mt-5">
                    Configuración del evento
                </div>

                <div class="row">

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <input name="evento_genero" type="checkbox" class="form-check-input border-dark" id="generoCheck" data-id="{{$datos['genero']}}" @if($datos['genero']) checked @endif>
                            <label for="genero" class="form-label">Género admitido</label>
                            <select class="form-select" name="genero" id="genero" style="display:none;">
                            @foreach(['Femenino', 'Masculino'] as $sexo)
                                <option value="{{ $sexo }}" @if($datos['genero'] == $sexo) selected @endif>
                                    {{ $sexo }}
                                </option>
                            @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <input name="rango_edad" type="checkbox" class="form-check-input border-dark" id="edadCheck"data-id="{{$datos['edad_minima']}}" @if($datos['edad_minima']) checked @endif>
                            <label for="limiteDeEdad" class="form-label">Rango de edad</label>
                            <div class="row" id="rangosDeEdad" style="display: none;">
                                <div class="col-md-6">
                                    <div class="row " id="rangoMin">
                                        <div class="col-md-4">
                                            <label for="edadMinima" class="form-label">Min</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <input name="edad_minima" type="number" class="form-control" min="0"
                                                    id="edadMinima" step="1" value="{{ isset($datos['edad_minima']) ? $datos['edad_minima'] : '0' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row " id="rangoMax">
                                        <div class="col-md-4">
                                            <label for="edadMaxima" class="form-label">Max</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <input name="edad_maxima" type="number" class="form-control"
                                                    id="edadMaxima" step="1" value="{{ isset($datos['edad_maxima']) ? $datos['edad_maxima'] : '0' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">

                        <div class="col-md-6">
                            <input name="evento_equipos" type="checkbox" class="form-check-input border-dark"
                                id="equipoCheck" @if($datos['evento_equipos']) checked @endif>
                            <label class="form-check-label" for="equipoCheck">Por equipos</label>
                        </div>

                        <div class="col-md-6">
                            <input name="requiere_registro" type="checkbox" class="form-check-input border-dark"
                                id="registroCheck" @if($datos['requiere_registro']) checked @endif>
                            <label class="form-check-label" for="registroCheck">Requiere registro</label>
                        </div>

                    </div>

                    <div class="row mt-4">

                        <div class="col-md-6 mt-2">
                            <input name="evento_pago" type="checkbox" class="form-check-input border-dark"
                                id="eventoPagoCheck" data-id="{{$datos['precio_inscripcion']}}" @if($datos['precio_inscripcion']) checked @endif>
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
                                        <input name="precio_inscripcion" type="number" class="form-control"
                                            min="0" id="costoEvento" step="0.5" value="{{ isset($datos['precio_inscripcion']) ? $datos['precio_inscripcion'] : '0.0' }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-7">

                <div class="col-md-12 ms-3">
                    <h6>Periodo de inscripción</h6>
                </div>

                <div class="row mt-3 ms-3">

                    <div class="col-md-2">Inicio</div>

                    <div class="col-md-4">
                        <input name="inicio_inscripcion" id="fechaInscripcionInicio" class="form-control" type="date"
                            min="" value="{{ isset($datos['inicio_inscripcion'])? $datos['inicio_inscripcion']:'' }}"/>
                    </div>

                    <div class="col-md-2">Fin</div>

                    <div class="col-md-4">
                        <input name="fin_inscripcion" id="fechaInscripcionFin" class="form-control" type="date"
                        min="" value="{{ isset($datos['fin_inscripcion'])? $datos['fin_inscripcion']:'' }}"/> 
                    </div>

                </div>

                <div class="col-md-12 mt-4  ms-3">
                    <h6>Duracion del evento *</h6>
                </div>

                <div class="row mt-3 ms-3">

                    <div class="col-md-2">Inicio</div>

                    <div class="col-md-4">
                        <input name="inicio_evento" id="fechaInicio" class="form-control" type="datetime-local"
                            min="" value="{{ isset($datos['inicio_evento'])? $datos['inicio_evento']:'' }}" required />
                    </div>

                    <div class="col-md-2">Fin</div>

                    <div class="col-md-4">
                        <input name="fin_evento" id="fechaFin" class="form-control" type="datetime-local"
                        min="" value="{{ isset($datos['fin_evento'])? $datos['fin_evento']:'' }}" required />
                    </div>

                </div>

                <div class="col-md-12 mt-5  ms-3">
                    <label for="descripcionDelEvento" class="form-label">Descripción del evento</label>
                    <textarea name="descripcion" class="form-control" id="descripcionDelEvento" rows="8" style="resize: none;"
                        placeholder="Ingrese una descripcion...">{{ $datos['descripcionDelEvento'] }}</textarea>
                </div>

                <div class="row mt-4 text-center">
                    <div class="col-md-6">
                        <!-Añadir el modal de confirmacion antes de hacer el reset al form->
                        <button type="button" class="btn btn-light text-primary" data-bs-toggle="modal" data-bs-target="#modalCancelar">
                                Cancelar
                            </button>
                            <x-modal-cancelar/>
                    </div>
                    <div class="col-md-6">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalConfirmacion">
                                Confirmar
                            </button>
                            <x-modal-confirmacion/>
                    </div>
                </div>

            </div>

        </form>

        <div class="col-12 mt-4"></div>

    </div>

    <script src="{{ asset('js/crearEvento.js') }}" defer></script>
@endsection
