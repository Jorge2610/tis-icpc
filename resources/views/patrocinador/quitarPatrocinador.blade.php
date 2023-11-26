@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-2">
            <h2>Quitar patrocinador de un evento</h2>
        </div>
        <div class="row g-5">
            <div class="col-sm-12 col-md-8" id="tablaEventos">
                <table class="table table-responsive table-striped text-secondary table-hover cursor" id="tablaEvento">
                    <thead>
                        <tr>
                            <th scope="col" class="col-sm-4 col-md-4">Nombre del evento</th>
                            <th scope="col" class="col-sm-3 col-md-3">Tipo de evento</th>
                            <th scope="col" class="col-sm-3 col-md-3 text-center">Fecha de creación</th>
                            <th scope="col" class="col-sm-2 col-md-2 text-center font-sm">Cantidad de patrocinadores</th>

                        </tr>
                    </thead>
                    <tbody id="datosTabla">
                        @foreach ($eventos as $evento)
                            <tr onclick="seleccionarEvento({{ $evento->id }}, '{{ $evento->nombre }}', event)"
                                id="{{ $evento->id }}">
                                <td>{{ $evento->nombre }}</td>
                                <td>{{ $evento->tipoEvento->nombre }}</td>
                                <td class="text-center">{{ date('d-m-Y', strtotime($evento->created_at)) }}</td>
                                <td class="text-center" id="contadorPatrocinadores{{ $evento->id }}">
                                    {{ $evento->eventoPatrocinador->count() }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="container d-flex flex-column border p-3">
                    <div class="col-12 d-flex justify-content-center align-items-center">
                        <h4>Quitar patrocinador de:</h4>
                    </div>
                    <h5 id="nombreEvento" class="text-center fw-bold"></h5>
                    <div class="col-md-12">
                        <div class="row row-cols-2 g-3 mt-2" style="height:48vh; overflow-y: auto; overflow-x: hidden"
                            id="divPatrocinadores">
                            <!-Aca se muestran los patrocinadores de un evento desde el js->
                        </div>
                    </div>
                </div>
                @component('components.modal')
                        @slot('modalId', 'modalQuitarPatrocinador')
                        @slot('modalTitle', 'Confirmacion')
                        @slot('modalContent')
                            ¿Estas seguro de quitar este patrocinador?
                        @endslot
                        @slot('modalButton')
                            <button type="button" class="btn btn-secondary w-25 mx-8" data-bs-dismiss="modal">No</button>
                            <button type="reset" class="btn btn-primary w-25 mx-8" data-bs-dismiss="modal"
                                onclick="quitarPatrocinador()">Sí</button>
                        @endslot
                    @endcomponent
            </div>
        </div>

        <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
        <script src="{{ asset('js/Patrocinador/quitarPatrocinador.js') }}" defer></script>
    @endsection