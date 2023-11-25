@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row g-5">
            <div class="col-sm-12 col-md-8">
                <table class="table table-responsive table-striped text-secondary table-hover cursor" id="tablaEvento">
                    <caption>Eventos</caption>
                    <thead>
                        <tr>
                            <th scope="col" class="col-sm-4 col-md-4">Nombre del evento</th>
                            <th scope="col" class="col-sm-0 col-md-3 text-center">Tipo de evento</th>
                            <th scope="col" class="col-sm-3 col-md-2 text-center">Fecha de creación</th>
                            <th scope="col" class="col-sm-3 col-md-2 text-center font-sm">Cantidad de sitios</th>
                        </tr>
                    </thead>
                    <tbody id="datosTabla">
                        @foreach ($eventos as $evento)
                            <tr onclick="seleccionarEvento({{ $evento->id }}, '{{ $evento->nombre }}', event)"
                                id="{{ $evento->id }}">
                                <td>{{ $evento->nombre }}</td>
                                <td class="text-center">{{ $evento->tipoEvento->nombre }}</td>
                                <td class="text-center">{{ date('d-m-Y', strtotime($evento->created_at)) }}</td>
                                <td class="text-center" id="contadorSitios{{ $evento->id }}">
                                    {{ $evento->sitios->count() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-sm-12 col-md-4" >
                <div class="container d-flex flex-column justify-content-center align-items-center border p-3" >
                    <div class="col-12 d-flex justify-content-center align-items-center">
                        <h4>Quitar sitio de interés</h4>
                    </div>
                    <h5 id="nombreEvento" class="text-center fw-bold"></h5>
                    <div id="sitiosContenedor" style="height:48vh; overflow-y: scroll;">
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
    <script src="{{ asset('js/SitiosInteres/quitarSitio.js') }}" defer></script>
@endsection
