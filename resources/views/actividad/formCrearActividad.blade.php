@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4" style="min-height: 500px">
                <h2 class="text-center">Crear actividad</h2>
                <form id="formularioActividad" class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="evento_id" value="{{$evento->id}}">
                    <input type="hidden" id="fecha_evento_inicio" value="{{$evento->inicio_evento}}">
                    <input type="hidden" id="fecha_evento_fin" value="{{$evento->fin_evento}}">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="nombreActividad" class="form-label">Nombre de la actividad *</label>
                                <input name="nombre" type="text" class="form-control custom-input" id="nombreActividad"
                                    value="" required placeholder="Ingrese el nombre de la actividad"
                                    maxlength="64">
                                <div class="invalid-feedback">
                                    El nombre no puede estar vacio.
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="tipoDeActividad" class="form-label">Tipo de actividad</label>
                                <!-Cargar tipos de actividad->
                                <select name="id_tipo_actividad" class="form-select fecha-editar" id="tipoDeActividad"
                                    onchange="datoCambiado()" aria-placeholder="Elija un tipo de actividad..."
                                required>

                                </select>
                                <div class="invalid-feedback">
                                    Seleccione un tipo de actividad.
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mt-4 ">
                                <label class="form-label">Duración de la actividad *</label>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-md-1 ml-2">Inicio</div>
                                <div class="col-md-10 mr-2">
                                    <input name="inicio_evento" id="fechaInicio" class="form-control" type="datetime-local" min="{{$evento->inicio_evento}}" max="{{$evento->fin_evento}}" required />
                                    <div id="mensajeFechaInicio" class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-1">Fin</div>
                                <div class="col-md-10">
                                    <input name="fin_evento" id="fechaFin" class="form-control" type="datetime-local" min="{{$evento->inicio_evento}}" max="{{$evento->fin_evento}}" required />
                                    <div id="mensajeFechaFin" class="invalid-feedback">
                                        <!--Aqui entran los mensajes de validacion de fecha-->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label for="detalleActividad" class="form-label">Descripción de la actividad</label>
                                <textarea name="descripcion" class="form-control" id="detalleActividad" rows="6" style="resize: none;"
                                    placeholder="Ingrese una descripción..." maxlength="1000"></textarea>
                            </div>
                        </div>
                        
                        <div class="text-center my-4">
                            <button type="reset" class="btn btn-secondary mx-5">Cancelar</button>
                            <button id="confirmarBoton" type="submit" class="btn btn-primary mx-5">Crear</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/Actividad/crearActividad.js') }}" defer></script>
@endsection
