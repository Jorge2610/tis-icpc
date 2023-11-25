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
                            <th scope="col" class="col-sm-3 col-md-2 text-center font-sm">Cantidad de afiches</th>

                        </tr>
                    </thead>
                    <tbody id="datosTabla">
                        @foreach ($afiches as $afiche)
                            <tr onclick="seleccionarEvento({{ $afiche }})" id="{{ $afiche->id }}">
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
                    <div class="col-12 d-flex justify-content-center align-items-center">
                        <h4>Afiches</h4>
                    </div>
                    <h5 id="nombreEvento" class="text-center fw-bold"></h5>
                    <div class="row gap-2 mt-2 d-flex justify-content-center" id="contenedorAsignar">

                    </div>
                    @component('components.modal')
                        @slot('modalId', 'modalCambiarAfiche')
                        @slot('modalTitle', 'Confirmacion')
                        @slot('modalContent')
                            ¿Está seguro de cambiar el afiche?
                        @endslot
                        @slot('modalButton')
                            <button type="button" class="btn btn-secondary w-25 mx-8" data-bs-dismiss="modal"
                                onclick="cancelarSubidaAfiche()">No</button>
                            <button type="reset" class="btn btn-primary w-25 mx-8" data-bs-dismiss="modal"
                                onclick="cambiarAfiche()">Sí</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/Afiche/editarAfiche.js') }}" defer></script>
@endsection
