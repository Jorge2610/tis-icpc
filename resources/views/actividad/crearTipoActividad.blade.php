@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5" style="min-height: 500px">
                <h2 class="text-center">Crear tipo de actividad</h2>
                <form id="formularioTipoActividad" class="needs-validation" novalidate>
                    @csrf
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="nombreTipoActividad" class="form-label">Nombre del tipo
                                    de actividad *</label>
                                <input name="nombre" type="text" class="form-control custom-input" id="nombreTipoActividad"
                                    value="" required placeholder="Ingrese el nombre del tipo de actividad"
                                    maxlength="64">
                                <div class="invalid-feedback">
                                    El nombre no puede estar vacio.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <label for="detalleTipoActividad" class="form-label">Descripción del tipo de actividad</label>
                                <textarea name="descripcion" class="form-control" id="detalleTipoActividad" rows="6" style="resize: none;"
                                    placeholder="Ingrese una descripción..." maxlength="500"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row contenedor-titulo-color">
                                    <div class="contenedor-subtitulo">
                                        <div class=" mt-3">
                                            <label for="colorTipoActividad" class="form-label text-container">Color de
                                                referencia</label>
                                        </div>
                                    </div>
                                    <div class=" mt-2 custom-col colum-col">
                                        <input name="color" type="color"
                                            class="form-control-color controlador" id="colorTipoActividad"
                                            value="#563d7c" title="Choose your color">
                                    </div>
                                </div>
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
    <script src="{{ asset('js/TipoDeActividad/crearTipoDeActividad.js') }}" defer></script>
@endsection
