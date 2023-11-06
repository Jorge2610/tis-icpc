@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-10">
            <h3>{{ $evento->nombre }}</h3>
            
        </div>
        <div class="row mt-5 g-5 gap-2">

            <div class="col-md-3">

                    <x-carrusel :evento="$evento" />
                                
            </div>

            <div class="col-md-6 border-end">

                <p class="descripcion-evento mx-3" style="text-align: justify">{!! nl2br($evento->descripcion) !!}</p>

                <table class="table" >
                    <caption hidden>Tipo de eventos</caption>
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
                                    Del
                                    <span
                                        id="fechaInicioIns">{{ date('d-m-Y', strtotime($evento->inicio_inscripcion)) }}</span>
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

            <div class="col-md-2">
                <div class="col-12 d-flex justify-content-center align-items-center">
                    <h4 class="ms-3">Patrocinadores</h4>
                    <x-modal-agregar-patrocinador :evento="$evento" />
                    </h4>
                </div>

                <div class="row g-4 mt-3" id="contenedorPatrocinadores">
                    <!-Patrocinadores->

                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <script src="{{ asset('js/mostrarEvento.js') }}" defer></script>
@endsection

