@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-2">
            <h4>Cancelar evento</h4>
        </div>
        <div class="row g-5">
            <div class="col-sm-12">
                <table class="table table-responsive table-striped text-secondary  cursor" id="tablaEvento">
                    <caption>Eventos</caption>
                    <thead>
                        <tr>
                            <th scope="col" class="col-sm-2 col-md-1">#</th>
                            <th scope="col" class="col-sm-4 col-md-4">Nombre del evento</th>
                            <th scope="col" class="col-sm-0 col-md-3 text-center">Tipo de evento</th>
                            <th scope="col" class="col-sm-3 col-md-2 text-center">Fecha de creación</th>
                            <th scope="col" class="col-sm-3 col-md-2 text-center font-sm">Acción</th>

                        </tr>
                    </thead>
                    <tbody id="datosTabla">
                        @php $contador = 1 @endphp
                        @foreach ($eventos as $evento)
                            @php
                                $cancelar = 1;
                                if (date('d-m-Y', strtotime($evento->inicio_inscripcion)) < date('d-m-Y')) {
                                    $cancelar = 0;
                                }
                            @endphp
                            <tr id="{{ $evento->id }}">
                                <th scope="row">{{ $contador++ }}</th>
                                <td>{{ $evento->nombre }}</td>
                                <td class="text-center">{{ $evento->tipoEvento->nombre }}</td>
                                <td class="text-center">{{ date('d-m-Y', strtotime($evento->created_at)) }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="setEventoId({{ $evento->id }})" id="botonAccion" style="width: 8vh"
                                        data-bs-toggle="modal"
                                        data-bs-target="{{ $cancelar === 1 ? '#modalCancelar' : '#modalAnular' }}">
                                        {{ $cancelar === 1 ? 'Cancelar' : 'Anular' }}
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!- Modal cancelar evento>
                    <div class="modal fade" id="modalCancelar" tabindex="-1" aria-labelledby="modalCancelarLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalCancelarLabel">
                                        Confirmar cancelación
                                    </h5>
                                </div>
                                <div class="modal-body">
                                    <div class="container px-4">
                                        <label for="motivoCancelacion" class="form-label">
                                            Motivo de la
                                            cancelación
                                        </label>
                                        <input type="text" class="form-control" id="motivoCancelacion"
                                            placeholder="Ingrese el motivo de la cancelación" value=""
                                            maxlength="128">
                                    </div>
                                </div>
                                <div class="modal-footer d-flex justify-content-center">
                                    <button type="button" class="btn btn-secondary w-25 mx-8"
                                        data-bs-dismiss="modal">No</button>
                                    <button type="button" class="btn btn-primary w-25 mx-8"
                                        onclick="cancelarEvento()">Sí</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!- Modal anular evento>
                        <div class="modal fade" id="modalAnular" tabindex="-1" aria-labelledby="modalAnularLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalAnularLabel">
                                            Confirmar anulación
                                        </h5>
                                    </div>
                                    <form class="needs-validation" novalidate id="formularioAnulacion">
                                        <div class="modal-body">
                                            <div class="container px-5">
                                                <div class="row">
                                                    <label for="motivoAnulacion" class="form-label">
                                                        Motivo de la
                                                        anulación *
                                                    </label>
                                                    <input type="text" class="form-control" id="motivoAnulacion"
                                                        placeholder="Ingrese el motivo de la anulación" value=""
                                                        required maxlength="64">
                                                    <div class="invalid-feedback">
                                                        El motivo de anulacion no puede estar vacio.
                                                    </div>
                                                </div>

                                                <div class="row mt-2">
                                                    <label for="descripcionAnulacion" class="form-label">
                                                        Descripción del motivo de la anulación
                                                    </label>
                                                    <textarea class="form-control" id="descripcionAnulacion" rows="3" style="resize: none;"
                                                        placeholder="Ingrese una descripcion..." maxlength="512">
                                                </textarea>
                                                </div>

                                                <div class="row mt-2">
                                                    <label for="archivosRespaldo" class="form-label">
                                                        Subir archivo de respaldo
                                                    </label>
                                                    <input type="file" class="form-control" id="archivosRespaldo">
                                                </div>

                                                <div class="row mt-2">
                                                    <label for="contrasenia" class="form-label">
                                                        Contraseña *
                                                    </label>
                                                    <input type="password" class="form-control" id="contrasenia"
                                                        placeholder="Ingrese su contraseña" pattern="" required>
                                                    <div class="invalid-feedback">
                                                        Contraseña incorrecta.
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </form>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button type="button" class="btn btn-secondary w-25 mx-8"
                                            data-bs-dismiss="modal">No</button>
                                        <button type="button" class="btn btn-primary w-25 mx-8"
                                            onclick="anularEvento()">Sí</button>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </div>

    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('js/cancelarEvento.js') }}" defer></script>
@endsection
