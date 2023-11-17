@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5" style="min-height: 500px">
                <h2 class="text-center">Crear actividad</h2>
                <form id="formularioActividad" class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="evento_id" value="{{$id}}">
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
                            <div class="col-md-12 mt-4 ">
                                <h6>Duracion de la actividad *</h6>
                            </div>
                            
                            <div class="row mt-3">

                                <div class="col-md-1">Inicio</div>

                                <div class="col-md-5">
                                    <input name="inicio_evento" id="fechaInicio" class="form-control" type="datetime-local"
                                        onchange="datoCambiado()" min="" required />
                                </div>

                                <div class="col-md-1">Fin</div>

                                <div class="col-md-5">
                                    <input name="fin_evento" id="fechaFin" class="form-control" type="datetime-local"
                                        onchange="datoCambiado()" min="" required />
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
                        
                        <div class="text-center my-5">
                            <button type="reset" class="btn btn-secondary mx-5">Cancelar</button>
                            <button id="confirmarBoton" type="submit" class="btn btn-primary mx-5">Crear</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/Actividad/crearActividad.js') }}" defer></script>
@endsection
