@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row align-items-end">
            <div class="col-md-2">
                <h4>Tipo de evento</h4>
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
                        <th scope="col" class="col-md-1 ">#</th>
                        <th scope="col" class="col-md-4">Nombre del tipo de evento</th>
                        <th scope="col" class="col-md-2 text-center">Color de referencia</th>
                        <th scope="col" class="col-md-2 text-center">Creador</th>
                        <th scope="col" class="col-md-3 text-center">Fecha de creación</th>
                        <th scope="col" class="col-md-3 text-center">Acción</th>
                    </tr>
                </thead>
                <tbody id="datosTabla">
                    @php
                        $contador = 1;
                    @endphp
                    @foreach ($tiposDeEventos as $tipoDeEvento)
                        @php
                            $fechaFormateada = date('d-m-Y', strtotime($tipoDeEvento->created_at));
                        @endphp
                        <tr>
                            <th scope='row'>{{ $contador++ }}</th>
                            <td>{{ $tipoDeEvento->nombre }}</td>
                            <td class="container-color">
                                <div class="color-cell" style="background-color:{{ $tipoDeEvento->color }};"></div>
                            </td>
                            <td class="text-center">Yo</td>
                            <td class="text-center">{{ $fechaFormateada }}</td>
                            <td class="text-center">
                                {{-- <button type="button" class="btn btn-primary btn-sm">
                                    <i class="bi bi-pencil-fill"></i>
                                </button> --}}
                                <a href="editar-tipo-evento/{{ $tipoDeEvento->id }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>                                
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalEliminarTipoEvento{{ $tipoDeEvento->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                                @component('components.modal')
                                    @slot('modalId', 'modalEliminarTipoEvento'. $tipoDeEvento->id)
                                    @slot('modalTitle', 'Eliminar tipo de evento')
                                    @slot('modalContent')
                                        Esta seguro que quiere eliminar este tipo de evento?
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
    <script src="{{ asset('js/tipoDeEvento.js') }}" defer></script>
@endsection
