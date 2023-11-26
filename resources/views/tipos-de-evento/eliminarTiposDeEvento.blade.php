@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row align-items-end">
            <div class="col-md-2">
                <h2>Eliminar tipo de evento</h2>
            </div>
            <div class="col-md-1">
                <x-ModalCrearTipoEvento />
            </div>
            <div class="col-md-9">

            </div>
        </div>
        <div class="row mt-3">
            <table class="table table-striped text-secondary" id="tablaTipoDeEvento">
                <caption>Tipo de eventos</caption>
                <thead>
                    <tr>
                        <th scope="col" class="col-md-2">Nombre del tipo de evento</th>
                        <th scope="col" class="col-md-2 text-center">Color de referencia</th>
                        <th scope="col" class="col-md-2 text-center">Autor</th>
                        <th scope="col" class="col-md-2 text-center">Fecha de creación</th>
                        <th scope="col" class="col-md-3 text-center">Eventos asociados</th>
                        <th scope="col" class="col-md-3 text-center">Acción</th>
                    </tr>
                </thead>
                <tbody id="datosTabla">
                    @foreach ($tiposDeEventos as $tipoDeEvento)
                        @if( $tipoDeEvento->eventos->count()==0)
                            <tr>
                                <td>{{ $tipoDeEvento->nombre }}</td>
                                <td class="container-color">
                                    <div class="color-cell" style="background-color:{{ $tipoDeEvento->color }};"></div>
                                </td>
                                <td class="text-center">Yo</td>
                                <td class="text-center">{{ date('d-m-Y', strtotime($tipoDeEvento->created_at)) }}</td>
                                <td class="text-center">{{ $tipoDeEvento->eventos->count() }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalEliminarTipoEvento{{ $tipoDeEvento->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    @component('components.modal')
                                        @slot('modalId', 'modalEliminarTipoEvento' . $tipoDeEvento->id)
                                        @slot('modalTitle', 'Eliminar tipo de evento')
                                        @slot('modalContent')
                                            ¿Está seguro de eliminar este tipo de evento?
                                        @endslot
                                        @slot('modalButton')
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="button" class="btn btn-danger"
                                                onclick="eliminarTipoEvento({{ $tipoDeEvento->id }})">Aceptar</button>
                                        @endslot
                                    @endcomponent
                                    @component('components.modal')
                                        @slot('modalId', 'modalExito')
                                        @slot('modalTitle', 'Éxito')
                                        @slot('modalContent')
                                            <div id="modalMensajeExito">
                                                Eliminado satisfactoriamente!
                                            </div>
                                        @endslot
                                        @slot('modalButton')
                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
                                        @endslot
                                    @endcomponent

                                    <!-- Modal de Error -->
                                    @component('components.modal')
                                        @slot('modalId', 'modalError')
                                        @slot('modalTitle', 'Error')
                                        @slot('modalContent')
                                            <div id="modalMensajeError">El tipo de evento que quieres eliminar tiene
                                                eventos asociados a el!
                                            </div>
                                        @endslot
                                        @slot('modalButton')
                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
                                        @endslot
                                    @endcomponent
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script src="{{ asset('js/TipoDeEvento/eliminarTipoEvento.js') }}" defer></script>
@endsection
