@extends('layouts.app')

@section('content')
    <div class="container mb-3">
        <div class="d-flex justify-content-center">
            <div class="col-md-8">
                <h2 id="nombreEvento">{{ $evento->nombre }}</h2>
                <h4>Formulario de inscripción</h4>
                <form class="needs-validation" novalidate id="formInscripcionParticipante">
                    <div class="row border border-bottom-0 rounded-top">
                        <h5 class="mt-2">Información general</h5>
                        <div class="col-md-6">
                            <div class="mb-3 mt-1">
                                <label for="nombreParticipante" class="form-label">Nombre(s) *</label>
                                <input type="text" class="form-control" id="nombreParticipante" maxlength="64"
                                    placeholder="Ingrese su nombre o nombres..." pattern="[a-zA-Z]*" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 mt-1">
                                <label for="apellidoParticipante" class="form-label">Apellidos *</label>
                                <input type="text" class="form-control" id="apellidoParticipante" maxlength="64"
                                    placeholder="Ingrese sus apellidos..." required>
                            </div>
                        </div>
                    </div>
                    <div class="row border border-top-0 border-bottom-0 rounded-bottom">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="carnetParticipante" class="form-label">Número de carnet *</label>
                                <input type="text" class="form-control" id="carnetParticipante"
                                    pattern="[0-9]{6,10}[\-]?[0-9A-Z]*" placeholder="Ingrese su número de carnet"
                                    onkeyup="setCarnetFeedBack()" required>
                                <div id="validacionCarnetFeedback" class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="correoParticipante" class="form-label">Correo electrónico *</label>
                                <input type="email" class="form-control" id="correoParticipante" maxlength="64"
                                    placeholder="Ingrese su correo electrónico..." required>
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
                                    max={{ date('Y-m-d', strtotime('-' . $edad_minima . ' year')) }} required>
                                <div class="form-text">
                                    @if ($evento->edad_minima != null && $evento->edad_maxima == null)
                                        Debes ser mayor de {{ $evento->edad_minima }} años para inscribirte al evento.
                                    @elseif ($evento->edad_minima == null && $evento->edad_maxima != null)
                                        Debes ser menor de {{ $evento->edad_minima }} años para inscribirte al evento.
                                    @else
                                        Debes tener entre {{ $evento->edad_minima }} y {{ $evento->edad_maxima }} años
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
                                    <select class="custom-select" id="selectPais"
                                        onchange="setCodPais()">
                                    </select>
                                    <span class="input-group-text rounded-start" id="codPais"></span>
                                    <input type="tel" class="form-control" id="telefonoParticipante" maxlength="15"
                                        pattern="[0-9]{6,15}" placeholder="Ingrese su número telefónico..." required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row border border-top-0 rounded-bottom">
                        <div class="col-md-6" {{ $evento->genero != null ? '' : 'hidden' }}>
                            <div class="mb-3">
                                <label for="generoParticipante" class="form-label">Genero *</label>
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
                    <h6 class="mt-2"><b>Nota:</b> La inscripcion a este evento tiene un costo de
                        {{ $evento->precio_inscripcion }} Bs.</h6>
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
            font-family: "Twemoji Country Flags",  "Segoe UI", "Helvetica Neue", "Noto Sans", "Liberation Sans", "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }
    </style>
    <script src="{{ asset('js/Inscripciones/codPaises.js') }}" defer></script>
    <script src="{{ asset('js/Inscripciones/participante.js') }}" defer></script>
@endsection
