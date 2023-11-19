@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-10">
            <h3>{{ $evento->nombre }}</h3>

        </div>
        <div class="row mt-5 g-5 gap-2">
            @if ($evento->afiches->count() > 0)
                <div class="col-md-3">
                    <x-carrusel :evento="$evento" />
                </div>

                <div class="col-md-6 border-end">
                @else
                    <div class="col-md-9 border-end">
            @endif

            <p class="descripcion-evento mx-3" style="text-align: justify">{!! nl2br($evento->descripcion) !!}</p>

            <table class="table">
                <caption hidden>Tipo de eventos</caption>
                <tbody>
                    <tr>
                        <th scope="row">Tipo de evento</th>
                        <td>{{ $evento->tipoEvento->nombre }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Grado académico requerido</th>
                        <td>{{ $evento->grado_academico == null ? 'Ninguno' : $evento->grado_academico }}</td>
                    </tr>
                    @if ($evento->inicio_inscripcion != null && $evento->fin_inscripcion != null)
                        <tr>
                            <th scope="row">Periodo de inscripción</th>
                            <td>
                                Del
                                <span id="fechaInicioIns">{{ date('d-m-Y', strtotime($evento->inicio_inscripcion)) }}</span>
                                al
                                <span id="fechaFinIns">{{ date('d-m-Y', strtotime($evento->fin_inscripcion)) }}</span>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th scope="row">Duración del evento</th>
                        <td>
                            Del </span>
                            <span id="fechaInicioEvento">{{ date('d-m-Y', strtotime($evento->inicio_evento)) }}</span>
                            al
                            <span id="fechaFinEvento">{{ date('d-m-Y', strtotime($evento->fin_evento)) }}</span>
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
                            <td>{{ $evento->genero }}</td>
                        </tr>
                    @endif
                    @if ($evento->edad_minima || $evento->edad_maxima)
                        <tr>
                            <th scope="row">Límite de edad</th>
                            <td>{{ $evento->edad_minima ? 'Desde los ' . $evento->edad_minima . ' años' : '' }}
                                {{ $evento->edad_maxima ? ($evento->edad_minima ? 'h' : 'H') . 'asta los ' . $evento->edad_maxima . ' años' : '' }}
                            </td>
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

        <div class="col-md-2">
            @if ($evento->sitios->count() > 0)
                <div class="col-12">
                    <h4 class="">Enlaces de interés: </h4>
                </div>

                <div class="row mb-5 d-flex">
                    @foreach ($evento->sitios as $sitio)
                        <a href="{{ $sitio->enlace }}" class="text-decoration-none text-primary fs-6 mt-2 text-truncate"
                            title="{{ $sitio->enlace }}" target="_blank"> {{ $sitio->titulo }}</a>
                    @endforeach

                </div>
            @endif

            @if ($evento->eventoPatrocinador->count() > 0)
                <div class="col-12 d-flex justify-content-center align-items-center ">
                    <div class="col-12 align-items-left">
                        <h4 class="">Patrocinadores: </h4>
                    </div>
                </div>
            @endif

            <div class="row g-4 mt-1">
                @foreach ($evento->eventoPatrocinador as $patrocinador)
                    <div class="col-12 col-md-12 d-flex justify-content-center">
                        <div id="imagenPatrocinador">
                            <a href="{{ $patrocinador->patrocinadores->enlace_web }}" class="text-decoration-none"
                                title="{{ $patrocinador->patrocinadores->nombre }}" target="_blank">
                                <img id="imagenPatrocinador" src="{{ $patrocinador->patrocinadores->ruta_imagen }}"
                                    alt="Imagen del patrocinador"
                                    style="object-fit: cover; max-height: 7rem; max-width: 100%;">
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>

        </div>
    </div>
    </div>
    </div>
    </div>

@endsection
