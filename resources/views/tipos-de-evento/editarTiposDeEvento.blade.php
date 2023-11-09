@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5" style="min-height: 500px">
            <h2 class="text-center">Editar tipo de evento</h2>

            <!-- Muestra alertas -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif


            <form id="formularioTipoEvento" class="needs-validation" novalidate method="POST" action="{{ route('tipo-eventos.update', ['id' => $tipoEvento->id]) }}">
                @csrf
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="nombreTipoEvento" class="form-label">Nombre del tipo de evento *</label>
                            <input name="nombre" type="text" class="form-control custom-input"
                                id="nombreTipoEvento" value="{{ $tipoEvento->nombre }}" required
                                placeholder="Ingrese el nombre del tipo de evento" maxlength="64">
                            <div class="invalid-feedback">
                                El nombre no puede estar vacío.
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="detalleTipoEvento" class="form-label">Descripción del tipo de evento</label>
                            <textarea name="descripcion" class="form-control" id="detalleTipoEvento" rows="6" style="resize: none;"
                                placeholder="Ingrese una descripción..." maxlength="500">{{ $tipoEvento->descripcion }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row contenedor-titulo-color">
                                <div class="contenedor-subtitulo">
                                    <div class="mt-3">
                                        <label for="colorTipoEvento" class="form-label text-container">Color de referencia</label>
                                    </div>
                                </div>
                                <div class="mt-2 custom-col colum-col">
                                    <input name="color" type="color"
                                        class="form-control form-control-color controlador" id="colorTipoEvento"
                                        value="{{ $tipoEvento->color }}" title="Choose your color">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center my-5">
                        <a href="/admin/tipos-de-evento" class="btn btn-secondary mx-5">Cancelar</a>
                        <button id="confirmarBoton" onclick="editarTipoEvento({{ $tipoEvento->id }})" class="btn btn-primary mx-5">Editar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('js/TipoDeEvento/administrarTipoEvento.js') }}" defer></script>
@endsection
