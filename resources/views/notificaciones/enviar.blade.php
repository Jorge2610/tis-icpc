@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-2">
            <h2>Enviar notificación</h2>
        </div>
        <div class="row g-5">
            <div class="col-sm-12 col-md-12 col-lg-8">
                <table class="table table-responsive table-striped text-secondary" id="tablaEvento">
                    <caption>Eventos</caption>
                    <thead>
                        <tr>
                            <th scope="col" class="col-sm-3 col-md-3">Nombre del evento</th>
                            <th scope="col" class="col-sm-4 col-md-4 text-center">Tipo de evento</th>
                            <th scope="col" class="col-sm-3 col-md-3 text-center">Ultima modificación</th>
                            <th scope="col" class="col-sm-3 col-md-3 text-center">Inscritos</th>
                        </tr>
                    </thead>
                    <tbody id="datosTabla">
                        @foreach ($eventos as $evento)
                            <tr onclick="seleccionarEvento({{ $evento->id }}, '{{ $evento->nombre }}', event)"
                                id="{{ $evento->id }}">
                                <td>{{ $evento->nombre }}</td>
                                <td class="text-center">{{ $evento->tipoEvento->nombre }}</td>
                                <td class="text-center">{{ date('d-m-Y', strtotime($evento->updated_at)) }}</td>
                                <td class="text-center" id="contadorActividades{{ $evento->id }}">
                                    {{ $evento->cantidad_inscritos }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            <div class="col-sm-12 col-md-12 col-lg-4">
                <div
                    class="container d-flex flex-column justify-content-center align-items-center border p-3 container-image">
                    <div class="col-12 d-flex justify-content-center align-items-center">
                        <h4>Enviar notificación</h4>
                    </div>
                    <h5 id="nombreEvento" class="text-center fw-bold"></h5>
                    <div class="container g-5">
                        <form class="needs-validation" novalidate id="formNotificacion">
                            <label for="asunto" class="form-label mt-3">Asunto *</label>
                            <input type="text" class="form-control custom-input" name="asunto"
                                placeholder="Ingrese el asunto" id="asunto" maxlength="64" required>
                            <div class="invalid-feedback">
                                El asunto no puede estar vacío
                            </div>


                            <label for="mensaje" class="form-label mt-3">Mensaje</label>
                            <textarea name="mensaje" id="mensaje" cols="30" rows="5" class="form-control custom-input"
                                style="resize: none" placeholder="Ingrese el mensaje..."></textarea>

                            <label for="archivo" class="mt-3 form-label">Archivo adjunto</label>
                            <input type="file" name="archivo" id="archivo" class="form-control custom-input"
                                onchange="onchangeArchivo()">
                            <p class="text-muted mt-1" style="font-size: 14px">
                                El archivo no puede exceder los 5 MB
                            </p>


                        </form>
                        <div class="d-flex justify-content-center mt-4">
                            <button class="btn btn-primary" onclick="validarForm()" id="botonEnviar">Enviar</button>
                        </div>
                        <p class="text-muted mt-5">
                            Esta notificación se enviará a los participantes inscritos en el evento.
                        </p>
                        @component('components.modal')
                            @slot('modalId', 'modalEnviarNotificacion')
                            @slot('modalTitle', 'Confirmación')
                            @slot('modalContent')
                                <p>¿Está seguro de enviar la notificación?</p @endslot @slot('modalButton') <button type="button"
                                    class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetInputs()">
                                No</button>
                                <button type="button" class="btn btn-danger" onclick="enviar()">Sí</button>
                            @endslot
                        @endcomponent

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
    <script src="{{ asset('js/Notificacion/enviar.js') }}" defer></script>
@endsection
