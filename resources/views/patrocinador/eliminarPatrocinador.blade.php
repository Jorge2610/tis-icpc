@extends('layouts.app')

@section('content')
    <div class="container 70vh">
        <div class="row g-5">
            <div class="col-sm-12 col-md-9">
                <table class="table table-responsive table-striped text-secondary table-hover cursor" id="tablaEvento">
                    <caption>eventos</caption>
                    <thead>
                        <tr>
                            <th scope="col" class="col-sm-2 col-md-1">#</th>
                            <th scope="col" class="col-sm-4 col-md-4">Nombre del evento</th>
                            <th scope="col" class="col-sm-0 col-md-3 text-center">Tipo de evento</th>
                            <th scope="col" class="col-sm-3 col-md-2 text-center">Fecha de creación</th>
                            <th scope="col" class="col-sm-3 col-md-2 text-center font-sm">Cantidad de patrocinadores</th>

                        </tr>
                    </thead>
                    <tbody id="datosTabla">
                        @php $contador = 1 @endphp
                        @foreach ($patrocinadores as $patrocinador)
                            <tr onclick="seleccionarEvento({{ $patrocinador->id }}, '{{ $patrocinador->nombre }}', event)"
                                id="{{ $patrocinador->id }}">
                                <th scope="row">{{ $contador++ }}</th>
                                <td>{{ $patrocinador->nombre }}</td>
                                <td class="text-center">{{ $patrocinador->tipoEvento->nombre }}</td>
                                <td class="text-center">{{ date('d-m-Y', strtotime($patrocinador->created_at)) }}</td>
                                <td class="text-center" id="contadorPatrocinadores{{ $patrocinador->id }}">
                                    {{ $patrocinador->patrocinadores->count() }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="col-sm-12 col-md-3">
                <div class="col-12 d-flex justify-content-center align-items-center">
                    <h4>Patrocinadores</h4>
                </div>
                <h5 id="nombreEvento" class="text-center fw-bold col-md-12"></h5>
                <div class="row g-4 mt-3" id="contenedorPatrocinadores">
                    <!-Patrocinadores->

                </div>
                @component('components.modal')
                    @slot('modalId', 'modalBorrarPatrocinador')
                    @slot('modalTitle', 'Confirmacion')
                    @slot('modalContent')
                        ¿Está seguro de eliminar al patrocinador?
                    @endslot
                    @slot('modalButton')
                        <button type="button" class="btn btn-secondary w-25 mx-8" data-bs-dismiss="modal">No</button>
                        <button type="button" class="btn btn-primary w-25 mx-8" data-bs-dismiss="modal"
                            onclick="borrar1()">Sí</button>
                    @endslot
                @endcomponent
            </div>
        </div>
    </div>
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script src="{{ asset('js/eliminarPatrocinador.js') }}" defer></script>
@endsection
