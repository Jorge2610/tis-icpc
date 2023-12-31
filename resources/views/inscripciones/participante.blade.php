@extends('layouts.app')

@section('content')
    <div class="container mb-3" id="formularioInscripcionEvento">
        <div class="d-flex justify-content-center">
            <div class="col-md-8">
                <h2 id="nombreEvento">{{ $evento->nombre }}</h2>
                <h4>Formulario de inscripción</h4>
                <form class="needs-validation" novalidate id="formInscripcionParticipante">
                    <div class="row border border-bottom-0 rounded-top">
                        <h5 class="mt-2">Información general</h5>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="carnetParticipante" class="form-label">Número de carnet</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="carnetParticipante"
                                        value="{{ $participante->ci }}" disabled>
                                    <span class="input-group-text rounded-start"
                                        id="codPaisCarnet">{{ $participante->pais }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="correoParticipante" class="form-label">Correo electrónico *</label>
                                <input type="email" class="form-control" id="correoParticipante" maxlength="64"
                                    placeholder="Ingrese su correo electrónico..." required
                                    value="{{ $participante->correo }}" {{ $participante->correo ? 'disabled' : '' }}>
                            </div>
                        </div>
                    </div>
                    <div class="row border border-top-0 border-bottom-0">
                        <div class="col-md-6">
                            <div class="mb-3 mt-1">
                                <label for="nombreParticipante" class="form-label">Nombre(s) *</label>
                                <input type="text" class="form-control" id="nombreParticipante" maxlength="64"
                                    placeholder="Ingrese su nombre o nombres..." pattern="[a-zA-Z ]+" required
                                    value="{{ $participante->nombres }}" {{ $participante->nombres ? 'disabled' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 mt-1">
                                <label for="apellidoParticipante" class="form-label">Apellido(s) *</label>
                                <input type="text" class="form-control" id="apellidoParticipante" maxlength="64"
                                    placeholder="Ingrese sus apellidos..." pattern="[a-zA-Z ]+" required
                                    value="{{ $participante->apellidos }}" {{ $participante->apellidos ? 'disabled' : '' }}>
                            </div>
                        </div>
                    </div>
                    <div class="row border border-top-0 border-bottom-0 rounded-bottom">
                        <div class="col-md-6">
                            <div class="mb-3">
                                @php
                                    $edad_minima = $evento->edad_minima != null ? $evento->edad_minima : '10';
                                    $edad_maxima = $evento->edad_maxima != null ? $evento->edad_maxima : '99';
                                @endphp
                                <label for="fechaNacParticipante" class="form-label">Fecha de nacimiento *</label>
                                <input type="date" class="form-control" id="fechaNacParticipante"
                                    min={{ date('Y-m-d', strtotime('-' . $edad_maxima . ' year')) }}
                                    max={{ date('Y-m-d', strtotime('-' . $edad_minima . ' year')) }} required
                                    value="{{ $participante->fecha_nacimiento }}"
                                    {{ $participante->fecha_nacimiento ? 'disabled' : '' }}>
                                <div class="form-text">
                                    @if ($evento->edad_minima != null && $evento->edad_maxima == null)
                                        Debes ser mayor de {{ $edad_minima }} años para inscribirte al evento.
                                    @elseif ($evento->edad_minima == null && $evento->edad_maxima != null)
                                        Debes ser menor de {{ $edad_maxima }} años para inscribirte al evento.
                                    @elseif ($evento->edad_minima != null && $evento->edad_maxima != null)
                                        Debes tener entre {{ $edad_minima }} y {{ $edad_maxima }} años
                                        para
                                        inscribirte al evento.
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telefonoParticipante" class="form-label">Teléfono *</label>
                                <div class="input-group">
                                    <input hidden value="{{ $participante->codigo_telefono }}" id="codPaisLit">
                                    <input hidden value="{{ $participante->id }}" id="idParticipante">
                                    <select class="custom-select" id="selectPais" onchange="setCodPais()"
                                        {{ $participante->codigo_telefono ? 'disabled' : '' }}>
                                    </select>
                                    <span class="input-group-text rounded-start" id="codPais"></span>
                                    <input type="tel" class="form-control" id="telefonoParticipante" maxlength="15"
                                        pattern="[0-9]{6,15}" placeholder="Ingrese su número telefónico..." required
                                        value="{{ $participante->telefono }}"
                                        {{ $participante->codigo_telefono ? 'disabled' : '' }}>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row border border-top-0 rounded-bottom">
                        <div class="col-md-6" {{ $evento->genero != null ? '' : 'hidden' }}>
                            <div class="mb-3">
                                <label for="generoParticipante" class="form-label">Género *</label>
                                <select id="generoParticipante" class="form-select form-select" aria-label=".form-select-sm"
                                    disabled>
                                    <option value={{ $evento->genero ? $evento->genero : '' }} selected>
                                        {{ $evento->genero ? $evento->genero : '' }}
                                    </option>
                                </select>
                                <div class="form-text">
                                    El evento solo admite personas de género {{ strtolower($evento->genero) }}.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" {{ $evento->talla == 'on' ? '' : 'hidden' }}>
                            <div class="mb-3">
                                <label for="tallaParticipante" class="form-label">Talla de polera *</label>
                                <select id="tallaParticipante" class="form-select form-select" aria-label=".form-select-sm"
                                    {{ $evento->talla == 'on' ? 'required' : '' }}>
                                    <option value="" selected>Seleccione su talla</option>
                                    <option value="XS">XS</option>
                                    <option value="S">S</option>
                                    <option value="M">M</option>
                                    <option value="L">L</option>
                                    <option value="XL">XL</option>
                                    <option value="XXL">XXL</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row border rounded mt-3"
                        {{ $evento->institucion != null || $evento->grado_academico != null ? '' : 'hidden' }}>
                        <h5 class="mt-2">Información académica</h5>
                        <div class="col-md-6" {{ $evento->institucion != null ? '' : 'hidden' }}>
                            <label for="institucionParticipante" class="form-label">Institución *</label>
                            <select id="institucionParticipante" class="form-select form-select"
                                aria-label=".form-select-sm" {{ $evento->institucion != null ? 'required' : '' }}>
                                <option value="" selected>Seleccione su institución</option>
                                @php
                                    $instituciones = explode('-', $evento->institucion);
                                @endphp
                                @foreach ($instituciones as $institucion)
                                    <option value={{ $institucion }}>{{ $institucion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3" {{ $evento->grado_academico != null ? '' : 'hidden' }}>
                            <label for="gradoAcademicoParticipante" class="form-label">Grado académico *</label>
                            <select id="gradoAcademicoParticipante" class="form-select form-select"
                                aria-label=".form-select-sm" {{ $evento->grado_academico != null ? 'required' : '' }}>
                                <option value="" selected>Seleccione su grado académico</option>
                                @php
                                    $grados = explode('-', $evento->grado_academico);
                                @endphp
                                @foreach ($grados as $grado)
                                    <option value={{ $grado }}>{{ $grado }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
                @if ($evento->precio_inscripcion != null)
                    <h6 class="text-muted mt-2"><b>Nota:</b> La inscripción a este evento tiene un costo de
                        {{ $evento->precio_inscripcion }} Bs.</h6>
                @endif
                @if (!$participante->nombres)
                    <h6 class="text-muted mt-2">
                        <b>*</b> Para asegurar tu participación en este evento, por favor, confirma tu correo
                        electrónico mediante el mensaje de verificación que se enviará a tu correo.
                    </h6>
                @endif
                <div class="d-flex justify-content-end mt-3">
                    <button type="button" class="btn btn-light text-primary me-3" onclick="resetForm()">
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-primary" onclick="validarInputs()">
                        Inscribirme
                    </button>
                </div>
            </div>
        </div>
    </div>
    <link href="{{ asset('css/participante.css') }}" rel="stylesheet">
    <script type="module" defer>
        import {
            polyfillCountryFlagEmojis
        } from "https://cdn.skypack.dev/country-flag-emoji-polyfill";
        polyfillCountryFlagEmojis();
    </script>
    <style>
        * {
            font-family: "Twemoji Country Flags", "Segoe UI", "Helvetica Neue", "Noto Sans", "Liberation Sans", "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }
    </style>
    <script src="{{ asset('js/Inscripciones/codPaises.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.10/dayjs.min.js"></script>
    <script src="{{ asset('js/Inscripciones/participante.js') }}" defer></script>
@endsection
