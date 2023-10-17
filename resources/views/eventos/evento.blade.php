@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>{{ $evento->nombre }}</h3>
        <div class="row mt-5">
            <div class="col-md-3">
                <div class="d-flex flex-column justify-content-center align-items-center border p-3" style="cursor: pointer;"
                    onclick="document.getElementById('imageUpload').click()">
                    <img id="uploadIcon" src="/image/uploading.png" alt="Upload Icon" style="width: 250px; height: 250px;">
                    <button id="uploadButton" class="boton-subir">Presione para subir imagen</button>
                    <img id="imagePreview" src="#" class="img-fluid mt-3" alt="Imagen del evento"
                        style="display: none;">
                </div>
                <input class="form-control" type="file" id="imageUpload" accept="image/*" style="display: none;"
                    onchange="handleImageUpload()">
            </div>

            <div class="col-md-6 border-end">
                <!-- <h2>Detalles del evento</h2>-->
                <p>{{ $evento->descripcion }}</p>
                <table class="table">
                    <tbody>
                        <tr>
                            <th scope="row">Tipo de evento</th>
                            <td>{{ $evento->tipoEvento->nombre }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Grado académico requerido</th>
                            <td>{{ $evento->grado_academico }}</td>
                        </tr>
                        @if ($evento->inicio_inscripcion != null && $evento->fin_inscripcion != null)
                            <tr>
                                <th scope="row">Periodo de inscripción</th>
                                <td>
                                    <span>Del&nbsp;</span>
                                    <span id="fechaInicioIns"
                                        class="mx-2 fst-italic">{{ date('d-m-Y', strtotime($evento->inicio_inscripcion)) }}</span>
                                    <span> al </span>
                                    <span id="fechaFinIns"
                                        class="fst-italic">{{ date('d-m-Y', strtotime($evento->fin_inscripcion)) }}</span>

                                </td>
                            </tr>
                        @endif
                        <tr>
                            <th scope="row">Duración del evento</th>
                            <td>
                                <span>Del&nbsp;</span>
                                <span id="fechaInicioEvento"
                                    class="fst-italic">{{ date('d-m-Y', strtotime($evento->inicio_evento)) }}</span>
                                <span> al </span>
                                <span id="fechaFinEvento"
                                    class="fst-italic">{{ date('d-m-Y', strtotime($evento->fin_evento)) }}</span>
                            </td>
                        </tr>
                        @if ($evento->institucion != null)
                            <tr>
                                <th scope="row">Instituciones admitidas</th>
                                <td>{{ $evento->institucion }}</td>
                            </tr>
                        @endif
                        @if ($evento->region != null)
                            <tr>
                                <th scope="row">Región</th>
                                <td>{{ $evento->region }}</td>
                            </tr>
                        @endif
                        @if ($evento->genero != null)
                            <tr>
                                <th scope="row">Género admitido</th>
                                <td>{{ $evento->region }}</td>
                            </tr>
                        @endif
                        @if ($evento->edad_minima && $evento->edad_maxima)
                            <tr>
                                <th scope="row">Límite de edad</th>
                                <td>Desde los {{ $evento->edad_minima }} hasta los {{ $evento->edad_maxima }} años.</td>
                            </tr>
                        @endif
                        <tr>
                            <th scope="row">¿Es por equipos?</th>
                            @if ($evento->evento_equipos == null)
                                <td>No</td>
                            @else
                                <td>Sí</td>
                            @endif

                        </tr>
                        <tr>
                            <th scope="row">¿El evento requiere registro?</th>
                            @if ($evento->requiere_registro == null)
                                <td>No</td>
                            @else
                                <td>Sí</td>
                            @endif
                        </tr>
                        <tr>
                            <th scope="row">Costo</th>
                            @if ($evento->precio_inscripcion == null)
                                <td>Gratuito</td>
                            @else
                                <td>{{ $evento->precio_inscripcion }} Bs.</td>
                            @endif
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-3">
                <h4 class="ms-3">Patrocinadores
                    <button type="button" class="btn btn-light btn-lg" data-bs-toggle="modal"
                        data-bs-target="#agregarPatrocinador">
                        +
                    </button>
                </h4>
                <div class="col-md-12 ms-5">
                    <img id="imagenPatrocinador" src="/image/logo-departamento.png" class=""
                        alt="Imagen del patrocinador" style="object-fit: cover; max-height: 2cm;">
                </div>
                <div class="col-md-12 ms-5">
                    <img id="imagenPatrocinador" src="/image/logo-umss.png" class="" alt="Imagen del patrocinador"
                        style="object-fit: cover; max-height: 2cm;">
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/mostrarEvento.js') }}" defer></script>
@endsection
