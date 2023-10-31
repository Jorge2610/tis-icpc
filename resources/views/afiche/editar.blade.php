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
                            <th scope="col" class="col-sm-3 col-md-2 text-center font-sm">Cantidad de afiches</th>

                        </tr>
                    </thead>
                    <tbody id="datosTabla">
                        @php
                            $contador = 1;
                        @endphp
                        @foreach ($afiches as $afiche)
                            <tr onclick="seleccionarEvento({{ $afiche }})" id="{{ $afiche->id }}">
                                <th scope="row">{{ $contador++ }}</th>
                                <td>{{ $afiche->nombre }}</td>
                                <td class="text-center">{{ $afiche->tipoEvento->nombre }}</td>
                                <td class="text-center">{{ date('d-m-Y', strtotime($afiche->created_at)) }}</td>
                                <td class="text-center" id="contadorAfiches{{ $afiche->id }}">
                                    {{ $afiche->afiches->count() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="container ">
                    <h5 id="nombreEvento"></h5>
                    <div class="row" id="contenedorAsignar">

                    </div>
                    @component('components.modal')
                        @slot('modalId', 'modalCambiarAfiche')
                        @slot('modalTitle', 'Confirmacion')
                        @slot('modalContent')
                            ¿Estas seguro de cambiar el afiche?
                        @endslot
                        @slot('modalButton')
                            <button type="button" class="btn btn-secondary w-25 mx-8" data-bs-dismiss="modal" onclick="cancelarSubidaAfiche()">No</button>
                            <button type="reset" class="btn btn-primary w-25 mx-8" data-bs-dismiss="modal" onclick="cambiarAfiche()">Sí</button>
                        @endslot
                    @endcomponent

                    @component('components.modal')
                        @slot('modalId', 'modalEliminarAfiche')
                        @slot('modalTitle', 'Confirmacion')
                        @slot('modalContent')
                            ¿Estas seguro de eliminar el afiche?
                        @endslot
                        @slot('modalButton')
                            <button type="button" class="btn btn-secondary w-25 mx-8" data-bs-dismiss="modal">No</button>
                            <button type="reset" class="btn btn-primary w-25 mx-8" data-bs-dismiss="modal" onclick="eliminarAfiche()">Sí</button>
                        @endslot
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>

    <script src="{{ asset('js/editarAfiche.js') }}" defer></script>
@endsection
