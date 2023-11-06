@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row g-5">
            <div class="col-sm-12 col-md-8">
                <table class="table table-responsive table-striped text-secondary table-hover cursor" id="tablaEvento">
                    <caption>eventos</caption>
                    <thead>
                        <tr>
                            <th scope="col" class="col-sm-2 col-md-1">#</th>
                            <th scope="col" class="col-sm-4 col-md-4">Nombre del evento</th>
                            <th scope="col" class="col-sm-0 col-md-3 text-center">Tipo de evento</th>
                            <th scope="col" class="col-sm-3 col-md-2 text-center">Fecha de creación</th>
                            <th scope="col" class="col-sm-3 col-md-2 text-center font-sm">Cantidad de recursos</th>

                        </tr>
                    </thead>
                    <tbody id="datosTabla">
                        @php $contador = 1 @endphp
                        @foreach ($recursos as $recurso)
                        <tr onclick="seleccionarEvento({{ $recurso->id }}, '{{ $recurso->titulo }}', event)" id="{{ $recurso->id }}">
                                <th scope="row">{{ $contador++ }}</th>
                                <td>{{ $recurso->nombre }}</td>
                                <td class="text-center">{{ $recurso->tipoEvento->nombre }}</td>
                                <td class="text-center">{{ date('d-m-Y', strtotime($recurso->created_at)) }}</td>
                                <td class="text-center" id="contadorrecursos{{ $recurso->id }}">
                                    {{ $recurso->recursos->count() }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-sm-12 col-md-4">
                <div
                    class="container d-flex flex-column justify-content-center align-items-center border p-3">
                    <form class="needs-validation" novalidate id="formularioAgregarRecurso">
                        <div class="col-md-12 mt-2">
                            <div class="text-center">
                            <label class="form-label fs-4" style="font-weight: bold;">Agregar recurso</label>
                            </div>
                            <label for="tituloRecurso" class="form-label">Titulo</label>
                            <input name="id_evento" type="hidden" id="id_evento">
                            <input name="titulo" type="text" class="form-control custom-input" id="titulorecurso"
                                value="" placeholder="Ingrese un titulo" required>
                            <div class="invalid-feedback">
                                El nombre no puede estar vacio.
                            </div>
                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="urlRecurso" class="form-label">Enlace al recurso</label>
                            <input name="enlace" type="text" class="form-control custom-input" id="urlRecurso"
                                value="" pattern="www\..+\..+|http://www\..+\..+|https://www\..+\..+" placeholder="https://www.ejemplo.com">
                        </div>
                    </form>
                    <div class="d-flex justify-content-center mt-3">
                        <button type="button" class="btn btn-light" onclick="resetInputs()"
                            id="asignarRecursoCancelar">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="validarDatos()"
                            id="asignarRecursoAsignar">Asignar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('js/subirRecurso.js') }}" defer></script>
@endsection
