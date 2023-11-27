@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 " style="min-height: 500px">
                <h2 class="text-center mb-5 ">Editar actividad</h2>
                <form id="formularioActividad" class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="id" value="{{ $actividad->id }}">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="nombreActividad" class="form-label">Nombre de la actividad*</label>
                                <input name="nombre" type="text" class="form-control custom-input" id="nombreActividad"
                                    value="{{ $actividad->nombre }}" required
                                    placeholder="Ingrese el nombre de la actividad" maxlength="64"
                                    @if (strtotime($actividad->inicio_actividad) <= time()) disabled @endif>
                                <div id="mensajeNombre" class="invalid-feedback">
                                    El nombre no puede estar vacío.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4 ">
                                <label class="form-label">Duración del evento</label>
                            </div>
                            
                            <div class="row justify-content-between pr-0">
                                <div class="col-sm-12 col-md-12 col-lg-5"><strong>Inicio: </strong> {{date('d-m-Y H:i', strtotime($evento->inicio_evento))}} </div>
                                <div class="col-sm-12 col-md-12 col-lg-7"><strong>Fin: </strong> {{date ('d-m-Y H:i', strtotime($evento->fin_evento))}} </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4 ">
                                <label class="form-label">Duración de la actividad *</label>
                            </div>

                            <div class="row mt-3 justify-content-between pr-0">
                                <div class="col-md-5">Inicio</div>
                                <div class="col-md-7 p-0">
                                    <input name="inicio_evento" id="fechaInicio" class="form-control" type="datetime-local"
                                        @if (strtotime($actividad->inicio_actividad) <= time()) min="{{ $evento->inicio_evento }}"
                                    @else
                                        min="{{ date('Y-m-d\TH:i') }}" @endif
                                        max="{{ $evento->fin_evento }}" value="{{ $actividad->inicio_actividad }}" required
                                        @if (strtotime($actividad->inicio_actividad) <= time()) disabled @endif />
                                    <div id="mensajeFechaInicio" class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="row mt-3 justify-content-between">
                                <div class="col-md-4">Fin</div>
                                <div class="col-md-7 p-0">
                                    <input name="fin_evento" id="fechaFin" class="form-control" type="datetime-local"
                                        value="{{ $actividad->fin_actividad }}"
                                        @if (strtotime($actividad->inicio_actividad) <= time()) min="{{ date('Y-m-d\TH:i') }}"    
                                    
                                    @else
                                        min="{{ $evento->inicio_evento }}" @endif
                                        max="{{ $evento->fin_evento }}" required />
                                    <div id="mensajeFechaFin" class="invalid-feedback">
                                        <!--Aqui entran los mensajes de validacion de fecha-->
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label for="detalleActividad" class="form-label">Descripción de la actividad</label>
                                <textarea name="descripcion" class="form-control" id="detalleActividad" rows="5" style="resize: none;"
                                    placeholder="Ingrese una descripción..." maxlength="1000">{{ $actividad->descripcion }}</textarea>
                            </div>
                        </div>

                        <div class="text-center my-4">
                            <button type="reset" class="btn btn-secondary mx-5">Cancelar</button>
                            <button id="confirmarBoton" type="submit" class="btn btn-primary mx-5">Editar</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/Actividad/editarActividad.js') }}" defer></script>
@endsection
