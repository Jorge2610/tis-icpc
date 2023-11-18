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
                            <th scope="col" class="col-sm-3 col-md-2 text-center font-sm">Cantidad de sitios</th>
                        </tr>
                    </thead>
                    <tbody id="datosTabla">
                        @php $contador = 1 @endphp
                        @foreach ($eventos as $evento)
                            <tr onclick="seleccionarEvento({{ $evento->id }}, '{{ $evento->nombre }}', event)"
                                id="{{ $evento->id }}">
                                <th scope="row">{{ $contador++ }}</th>
                                <td>{{ $evento->nombre }}</td>
                                <td class="text-center">{{ $evento->tipoEvento->nombre }}</td>
                                <td class="text-center">{{ date('d-m-Y', strtotime($evento->created_at)) }}</td>
                                <td class="text-center" id="contadorSitios{{ $evento->id }}">
                                    {{ $evento->recursos->count() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="container d-flex flex-column justify-content-center align-items-center border p-3">
                    <div class="col-12 d-flex justify-content-center align-items-center">
                        <h4>Asignar sitio de interes</h4>
                    </div>
                    <h5 id="nombreEvento" class="text-center fw-bold"></h5>
                    <form class="needs-validation" novalidate id="formularioAgregarSitio">
                        <div class="col-md-12 mt-2">
                            <label for="tituloSitio" class="form-label">Titulo</label>
                            <input name="titulo" type="text" class="form-control custom-input" id="tituloSitio"
                                value="" placeholder="Ingrese un titulo" required>
                            <div class="invalid-feedback">
                                El titulo no puede estar vacio.
                            </div>
                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="urlSitio" class="form-label">Enlace al sitio</label>
                            <input name="enlace" type="url" class="form-control custom-input" id="urlSitio"
                                value="" placeholder="https://www.ejemplo.com" required>
                        </div>
                    </form>
                    <div class="d-flex justify-content-center mt-3 gap-3">
                        <button type="button" class="btn btn-light" onclick="resetInputs()"
                            id="asignarSitioCancelar">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="validarDatos()"
                            id="asignarSitioAsignar">Asignar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script src="{{ asset('js/subirSitio.js') }}" defer></script>
@endsection
