@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-2">
            <h4>Eliminar patrocinador</h4>
        </div>
        <div class="row g-5">
            <div class="col-sm-12 col-md-12">
                <table class="table table-responsive table-striped text-secondary" id="tablaEvento">
                    <thead>
                        <tr>
                            <th scope="col" class="col-sm-3 col-md-3">Nombre del patrocinador</th>
                            <th scope="col" class="col-sm-3 col-md-3">Enlace web</th>
                            <th scope="col" class="col-sm-3 col-md-3">Imagen</th>
                            <th scope="col" class="col-sm-1 col-md-1">Fecha de creación</th>
                            <th scope="col" class="col-sm-1 col-md-1">Eventos asociados</th>
                            <th scope="col" class="col-sm-1 col-md-1">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="datosTabla">
                        @foreach ($patrocinadores as $patrocinador)
                            <tr id="{{ $patrocinador->id }}">
                                <td>{{ $patrocinador->nombre }}</td>
                                <td>
                                    <a class="d-inline-block text-truncate" href="{{ $patrocinador->enlace_web }}"
                                        target="_blank" style="max-width: 250px;" title="{{ $patrocinador->enlace_web }}">
                                        {{ $patrocinador->enlace_web }}
                                    </a>
                                </td>
                                <td><a href="{{ $patrocinador->ruta_imagen }}"
                                        target="_blank">{{ $patrocinador->nombre }}</a></td>
                                <td>{{ date('d-m-Y', strtotime($patrocinador->created_at)) }}</td>
                                <td class="text-center">{{ $patrocinador->eventoPatrocinador->count() }}</td>
                                <td class="text-center">
                                    <button data-bs-toggle="modal"
                                        data-bs-target="#modalEliminarPatrocinador{{ $patrocinador->id }}"
                                        title="Eliminar patrocinador" type="button" class="btn btn-danger btn-sm"
                                        {{ $patrocinador->eventoPatrocinador->count() > 0 ? 'disabled' : '' }}>
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    @component('components.modal')
                                        @slot('modalId', 'modalEliminarPatrocinador' . $patrocinador->id)
                                        @slot('modalTitle', 'Eliminar patrocinador')
                                        @slot('modalContent')
                                            ¿Esta seguro que quiere eliminar este patrocinador?
                                        @endslot
                                        @slot('modalButton')
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                            <button type="button" class="btn btn-danger"
                                                onclick="eliminarPatrocinador({{ $patrocinador->id }})">Sí</button>
                                        @endslot
                                    @endcomponent
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script src="{{ asset('js/Patrocinador/eliminarPatrocinador.js') }}" defer></script>
@endsection
