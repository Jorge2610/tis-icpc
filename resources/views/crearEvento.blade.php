@extends('layouts.app')

@section('content')
<div class="container">
    <form class="row g-4">
        <div class="col-5 border-end">
            <div class="col-12">
                <h5>Crear evento</h5>
            </div>
            <div class="col-12">
                <label for="nombreDelEvento" class="form-label">Nombre del evento*</label>
                <input type="text" class="form-control" id="nombreDelEvento">
            </div>
            <div class="row mt-3">
                <div class="col-9">
                    <label for="tipoDelEvento" class="form-label">Tipo de evento</label>
                    <input type="text" class="form-control" id="tipoDelEvento">
                </div>
                <div class="col-3">
                    <label for="limiteDeEdad" class="form-label">Limite de edad</label>
                    <select id="limiteDeEdad" class="form-select">
                        <!--Edades de ejemplo-->
                        <option>15</option>
                        <option>16</option>
                        <option>17</option>
                    </select>
                </div>
            </div>
            <div class="col-12 mt-3">
                <h6>Periodo de inscripción</h6>
            </div>
            <div class="row">
                <div class="col-2">Inicio</div>
                <div class="col-4">
                    <input id="fechaInscripcionInicio" class="form-control" type="date" min="<?php echo date("Y-m-d"); ?>" />
                </div>
                <div class="col-2">Fin</div>
                <div class="col-4">
                    <input id="fechaInscripcionFin" class="form-control" type="date" />
                </div>
            </div>
            <div class="col-12 mt-3">
                <h6>Duracion del evento</h6>
            </div>
            <div class="row mt-3">
                <div class="col-2">Inicio</div>
                <div class="col-4">
                    <input id="fechaInicio" class="form-control" type="date" min="<?php echo date("Y-m-d"); ?>" />
                </div>
                <div class="col-2">Fin</div>
                <div class="col-4">
                    <input id="fechaFin" class="form-control" type="date" />
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-6">
                    <input type="checkbox" class="form-check-input" id="eventoPagoCheck">
                    <label class="form-check-label" for="eventoPagoCheck">Evento de pago</label>
                </div>
                <div class="col-6">
                    <input type="checkbox" class="form-check-input" id="competenciaGeneralCheck">
                    <label class="form-check-label" for="competenciaGeneralCheck">Competencia general</label>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-6">
                    <input type="checkbox" class="form-check-input" id="equipoCheck">
                    <label class="form-check-label" for="equipoCheck">Por equipos</label>
                </div>
                <div class="col-6">
                    <input type="checkbox" class="form-check-input" id="registroCheck">
                    <label class="form-check-label" for="registroCheck">Requiere registro</label>
                </div>
            </div>
        </div>
        <div class="col-7">
            <div class="col-12">
                <label for="descripcionDelEvento" class="form-label">Descripción del evento</label>
                <textarea class="form-control" id="descripcionDelEvento" rows="14" style="resize: none;"></textarea>
            </div>
            <div class="row mt-3 text-center">
                <div class="col-6">
                    <button type="reset" class="btn btn-light text-primary">Cancelar</button>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection