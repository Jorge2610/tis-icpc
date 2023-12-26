@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <h2>Detalle de evento</h2>
            </div>

            <div class="col-md-12">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ URL::to('/eventos') }}">Eventos</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detalle de evento</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-main  g-5">
                <div class="row">
                    @if ($evento->afiches->count() > 0)
                        <div class="col-md-5 col-sm-5">
                            <x-carrusel :evento="$evento" />
                        </div>

                        <div class="col-md-7 col-sm-7  mt-3 " style="font-size: small">
                        @else
                            <div class="col-md-12 col-sm-12  mt-3 " style="font-size: small">
                    @endif
                    <div class="row">
                        <div class="col-lg-9 col-md-12 col-sm-12 col-12">
                            <h3>{{ $evento->nombre }}</h3>
                            <p class="fs-6 mb-0">{{ $evento->tipoEvento->nombre }}
                            <p>
                        </div>
                        @if (
                            $evento->actividades->where('inscripcion', 1)->filter(function ($actividad) {
                                    $currentDateTime = now()->format('Y-m-d H:i:s');
                                    return $actividad->inicio_actividad <= $currentDateTime && $currentDateTime <= $actividad->fin_actividad;
                                })->count() > 0)
                            <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                                <div class="row mt-3 d-flex">
                                    <button type="button" class="btn btn-primary w-100 justify-content-center"
                                        data-bs-toggle="modal" data-bs-target="#modal-inscribir">
                                        {{ $evento->equipo_maximo == null ? 'Inscribirme' : 'Inscribir equipo' }}
                                    </button>
                                    <!-- Modal -->
                                    @if ($evento->equipo_maximo == null)
                                        @component('components.modal-inscribir-participante')
                                        @else
                                            @component('components.modal-inscribir-grupo')
                                            @endif
                                            @slot('evento', $evento)
                                        @endcomponent
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if ($participantes->count() > 0)
                            @php
                                $plural = $participantes->count() > 1 ? 's' : '';
                            @endphp
                            <div class="d-flex justify-content-end fs-6">
                                Este evento tiene {{ $participantes->count() }}
                                participante{{ $plural }} inscrito{{ $plural }}.
                            </div>
                        @endif
                        @if ($equipos > 0)
                            @php
                                $plural = $equipos > 1 ? 's' : '';
                            @endphp
                            <div class="d-flex justify-content-end fs-6">
                                Este evento tiene {{ $equipos }}
                                equipo{{ $plural }} inscrito{{ $plural }}.
                            </div>
                        @endif

                        <hr>
                        <h5>Información del evento:</h5>
                        <div class="row mt-3">
                            <div class="col-8">
                                <strong>Inicio del evento:</strong>
                                {{ date('d-m-Y', strtotime($evento->inicio_evento)) }}
                            </div>
                            <div class="col-4">
                                <strong>Hora:</strong>
                                {{ date('H:i', strtotime($evento->inicio_evento)) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <strong>Fin del evento:</strong>
                                {{ date('d-m-Y', strtotime($evento->fin_evento)) }}
                            </div>
                            <div class="col-4 ">
                                <strong>Hora:</strong>
                                {{ date('H:i', strtotime($evento->fin_evento)) }}
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <strong>Grado académico requerido:</strong>
                                {{ $evento->grado_academico == null ? 'Ninguno' : $evento->grado_academico }}
                            </div>
                        </div>
                        @if ($evento->institucion)
                            <div class="row mt-3">
                                <div class="col-12">
                                    <strong>Instituciones admitidas:</strong>
                                    {{ $evento->institucion }}
                                </div>
                            </div>
                        @endif
                        @if ($evento->region)
                            <div class="row mt-3">
                                <div class="col-12">
                                    <strong>Región:</strong>
                                    {{ $evento->region }}
                                </div>
                            </div>
                        @endif
                        @if ($evento->genero)
                            <div class="row mt-3">
                                <div class="col-12">
                                    <strong>Género admitido:</strong>
                                    {{ $evento->genero }}
                                </div>
                            </div>
                        @endif
                        @if ($evento->edad_minima || $evento->edad_maxima)
                            <div class="row mt-3">
                                <div class="col-12">
                                    <strong>Límite de edad:</strong>
                                    {{ $evento->edad_minima ? 'Desde los ' . $evento->edad_minima . ' años' : '' }}
                                    {{ $evento->edad_maxima ? ($evento->edad_minima ? 'h' : 'H') . 'asta los ' . $evento->edad_maxima . ' años' : '' }}
                                </div>
                            </div>
                        @endif


                        @if ($evento->equipo_minimo || $evento->equipo_maximo)
                            <div class="row mt-3">
                                <div class="col-12">
                                    <strong>El evento es por equipos: de
                                        {{ $evento->equipo_minimo ? $evento->equipo_minimo : 2 }} a
                                        {{ $evento->equipo_maximo }} participantes</strong>
                                </div>
                            </div>
                        @endif
                        <div class="row mt-3 fs-5">
                            @if ($evento->precio_inscripcion == null)
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <strong>Costo de inscripción:</strong>
                                        GRATUITO
                                    </div>
                                </div>
                            @else
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <strong>Costo de inscripción:</strong>
                                        {{ $evento->precio_inscripcion }} Bs.
                                    </div>
                                </div>
                            @endif
                        </div>


                    </div>
                </div>
            </div>
        </div>
        @if ($evento->descripcion !== null)
            <div class="row mt-5">
                <div class="col-md-12 {{ $evento->sitios->count() > 0 ? 'col-lg-9' : 'col-lg-12' }} border-end ">
                    <h3 class="">Descripción</h3>
                    <hr>
                    <p class="px-4 text-break " style="text-align: justify">{!! nl2br($evento->descripcion) !!}</p>
                </div>
            @else
                <div class="row mt-5">
        @endif
        @if ($evento->sitios->count() > 0)
            <div class="col-md-12 {{ $evento->descripcion !== null ? 'col-lg-3' : 'col-lg-12' }} ">

                <h3>Sitios de interés</h3>
                <hr>
                @foreach ($evento->sitios as $sitio)
                    <div class="">
                        <a href="{{ $sitio->enlace }}" class="text-decoration-none text-primary fs-6 mt-2 text-truncate"
                            title="{{ $sitio->enlace }}" target="_blank"> {{ $sitio->titulo }}</a>
                    </div>
                @endforeach

            </div>
        @endif

        </div>
        @if ($evento->actividades->count() > 0)
            <div class="row mt-5">
                <div class="col-md-12">
                    <h3>Actividades</h3>
                    <hr>
                    @foreach ($evento->actividades as $actividad)
                        <div class="card my-3
                        @if ($actividad->fin_actividad < now()->format('Y-m-d H:i:s')) shadow-none
                        @elseif(
                            $actividad->inicio_actividad <= now()->format('Y-m-d H:i:s') &&
                                now()->format('Y-m-d H:i:s') <= $actividad->fin_actividad)
                            shadow-lg bg-body rounded
                        @else
                            shadow bg-body rounded @endif
                    "
                            style="min-height: auto">
                            <div class="card-body mt-3">
                                <h5 class="card-title text-center fw-bold">{{ $actividad->nombre }}</h5>
                                <hr>
                                <div class="row">
                                    @if ($actividad->inscripcion == 1)
                                        <p class="card-text col-lg-2 col-sm-3 col-4"><strong> Inicio: </strong>
                                            {{ date('d-m-Y', strtotime($actividad->inicio_actividad)) }}
                                        </p>
                                        <p class="card-text col-lg-7 col-sm-7 col-5">
                                            <strong>Hora: </strong> {{ date('H:i', strtotime($actividad->inicio_actividad)) }}
                                        </p>
                                        <div class="alert alert-primary text-center col-lg-3 col-sm-2 col-3"
                                            style="height:25px;padding:0;width:200px">
                                            Actividad de inscripción
                                        </div>
                                    @else
                                        <p class="card-text col-lg-2 col-sm-4 col-6"><strong> Inicio: </strong>
                                            {{ date('d-m-Y', strtotime($actividad->inicio_actividad)) }}

                                        </p>
                                        <p class="card-text col-lg-10 col-sm-8 col-6">
                                            <strong>Hora: </strong> {{ date('H:i', strtotime($actividad->inicio_actividad)) }}
                                        </p>
                                    @endif

                                    <p class="card-text col-lg-2 col-sm-4 col-6"><strong> Fin: </strong>
                                        {{ date('d-m-Y', strtotime($actividad->fin_actividad)) }}
                                    </p>
                                    <p class="card-text col-lg-10 col-sm-8 col-6">
                                        <strong>Hora: </strong> {{ date('H:i', strtotime($actividad->fin_actividad)) }}
                                    </p>

                                    <p class="card-text col-12 px-4 text-break" style="text-align: justify">
                                        {!! nl2br($actividad->descripcion) !!}
                                    </p>
                                </div>


                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($evento->eventoPatrocinador->count() > 0)
            <div class="row mt-5">
                <div class="col-md-12">
                    <h3 class="">Patrocinadores</h3>
                    <hr>
                    <div class="row mt-3 gap-3">
                        @foreach ($evento->eventoPatrocinador as $patrocinador)
                            <div id="imagenPatrocinador" class="col-auto">
                                @if ($patrocinador->patrocinadores->enlace_web !== null)
                                    <a class="text-decoration-none" href="{{ $patrocinador->patrocinadores->enlace_web }}"
                                        target="_blank">
                                    @else
                                        <a class="text-decoration-none" title="{{ $patrocinador->patrocinadores->nombre }}"
                                            target="_blank">
                                @endif
                                <img id="imagenPatrocinador" src="{{ $patrocinador->patrocinadores->ruta_imagen }}"
                                    alt="Imagen del patrocinador" style="object-fit: cover; max-height: 7rem; max-width: 100%;"
                                    title="{{ $patrocinador->patrocinadores->nombre }}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        </div>
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

        {{-- <div class="col-10">
            <h3>{{ $evento->nombre }}</h3>
        </div>
        <div class="row mt-5 g-5 gap-2">
            <div class="col-md-9">
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
                <hr>
                <div>
                    <h4>Actividades: </h4>
                    @foreach ($evento->actividades as $actividad)
                        <div class="card my-3" style="min-height: auto">
                            <div class="card-body mt-3">
                                <h5 class="card-title text-center fw-bold">{{ $actividad->nombre }}</h5>
                                <hr>
                                <p class="card-text"><strong> Inicio: </strong>
                                    {{ date('d-m-Y  H:i', strtotime($actividad->inicio_actividad)) }}</p>
                                <p class="card-text"><strong> Fin: </strong>
                                    {{ date('d-m-Y  H:i', strtotime($actividad->fin_actividad)) }}</p>
                                <p class="card-text fs-6 text-justify" style="">{{ $actividad->descripcion }}</p>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-2">
                @if ($evento->sitios->count() > 0)
                    <div class="col-12">
                        <h4 class="">Sitios de interés: </h4>
                    </div>

                    <div class="row mb-5 d-flex">
                        @foreach ($evento->sitios as $sitio)
                            <a href="{{ $sitio->enlace }}"
                                class="text-decoration-none text-primary fs-6 mt-2 text-truncate"
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
                                <a href="{{ $patrocinador->patrocinadores->enlace_web ? $patrocinador->patrocinadores->enlace_web : '#' }}"
                                    class="text-decoration-none" title="{{ $patrocinador->patrocinadores->nombre }}"
                                    target="_blank">
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
    </div> --}}
    @endsection
