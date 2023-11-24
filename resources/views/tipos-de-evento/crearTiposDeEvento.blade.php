@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5" style="min-height: 500px">
                <h2 class="text-center">Crear tipo de evento</h2>
                <form id="formularioTipoEvento" class="needs-validation" novalidate>
                    @csrf
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="nombreTipoEvento" class="form-label">Nombre del tipo
                                    de evento *</label>
                                <input name="nombre" type="text" class="form-control custom-input" id="nombreTipoEvento"
                                    value="" required placeholder="Ingrese el nombre del tipo de evento"
                                    maxlength="64">
                                <div id="mensajeNombre" class="invalid-feedback">
                                    El nombre no puede estar vacio.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <label for="detalleTipoEvento" class="form-label">Descripción del tipo de evento</label>
                                <textarea name="descripcion" class="form-control" id="detalleTipoEvento" rows="6" style="resize: none;"
                                    placeholder="Ingrese una descripción..." maxlength="500"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row contenedor-titulo-color">
                                    <div class="contenedor-subtitulo">
                                        <div class=" mt-3">
                                            <label for="colorTipoEvento" class="form-label text-container">Color de
                                                referencia</label>
                                        </div>
                                    </div>
                                    <div class=" mt-2 custom-col colum-col">
                                        <input name="color" type="color"
                                            class="form-control-color controlador" id="colorTipoEvento"
                                            value="#563d7c" title="Choose your color">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center my-5">
                            <button id="cancelarBoton" type="reset" class="btn btn-secondary mx-5" onClick="quitarValidacion()">Cancelar</button>
                            <button id="confirmarBoton" type="submit" class="btn btn-primary mx-5">Crear</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/TipoDeEvento/crearTipoEvento.js') }}" defer></script>
@endsection
