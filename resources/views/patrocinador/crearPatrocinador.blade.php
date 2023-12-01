@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-2">
            <h2>Crear patrocinador</h2>
        </div>
        <div class="row g-5">
            <div class="col-sm-12 col-md-8">
                <table class="table table-responsive table-striped text-secondary" id="tablaEvento">
                    <caption>Patrocinadores</caption>
                    <thead>
                        <tr>
                            <th scope="col" class="col-sm-3 col-md-3">Nombre del patrocinador</th>
                            <th scope="col" class="col-sm-4 col-md-4">Enlace web</th>
                            <th scope="col" class="col-sm-3 col-md-3">Imagen</th>
                            <th scope="col" class="col-sm-2 col-md-2">Fecha de creación</th>
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="col-sm-12 col-md-4">
                <div class="container d-flex flex-column align-items-center border p-3 container-image">
                    <h5 class="text-start">Imagen patrocinador</h5>
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset('/image/uploading.png') }}" alt="image" id = "imagePreview"
                            class="rounded mx-auto d-block img-thumbnail" style="max-height: 270px; max-width: 270px">
                        <input type="file" id="imageUpload" class="d-none" accept="image/jpeg, image/png, image/jpg"
                            onchange="previsualizarImagen(event)">
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        <button type="button" class="btn btn-light text-primary" id="botonSubirLogoPatrocinador"
                            onclick="document.getElementById('imageUpload').click()">Subir imagen</button>
                    </div>
                    <form class="needs-validation" novalidate id="formularioAgregarPatrocinador">
                        <div class="col-md-12 mt-2">
                            <label for="nombrePatricinador" class="form-label">Nombre
                                del patrocinador *</label>
                            <input name="nombre" type="text" class="form-control custom-input" id="nombrePatricinador"
                                value="" placeholder="Ingrese un nombre" required>
                            <div class="invalid-feedback">
                                El nombre no puede estar vacío.
                            </div>
                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="urlPatrocinador" class="form-label">Enlace
                                a la página web del patrocinador</label>
                            <input name="enlace_web" type="url" class="form-control custom-input" id="urlPatrocinador"
                                value="" pattern="https?://.+" placeholder="https://www.ejemplo.com">
                        </div>
                    </form>
                    <div class="d-flex justify-content-center mt-3">
                        <button type="button" class="btn btn-light" onclick="resetInputs()"
                            id="crearPatrocinadorCancelar">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="validarDatos()"
                            id="crearPatrocinadorCrear">Crear</button>
                        @component('components.modal')
                            @slot('modalId', 'modalPatrocinadroExistente')
                            @slot('modalTitle', 'Patrocinador ya existente')
                            @slot('modalContent')
                                <p>
                                    <b>El patrocinador que intentó crear ya existe,</b>
                                    ¿Desea habilitarlo nuevamente?
                                </p>
                            @endslot
                            @slot('modalButton')
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetInputs()">
                                    No</button>
                                <button type="button" class="btn btn-danger" onclick="restaurarPatrocinador()">Sí</button>
                            @endslot
                        @endcomponent

                        <div class="modal fade" id="modalActualizarPatrocinador" tabindex="-1"
                            aria-labelledby="modalAnularLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            Actualizar datos del patrocinador
                                        </h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row container px-5">
                                            Datos del patrocinador restaurado:
                                            <div class="col-md-7 mt-3" id="datosPatrocinadorRestaurado">

                                            </div>
                                            <div class="d-flex align-items-center col-md-5 mt-3">
                                                <img class="img-fluid rounded object-fit-scale"
                                                    src="/image/aficheDefecto.png" alt="Imagen patrocinador"
                                                    style="max-height: 100%" id="imagenPatrocinadorRestaurado">
                                            </div>
                                            <div class="col-md-12 mt-2 text-start">
                                                ¿Desea actualizar los datos del patrocinador?
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                            onclick="actualizarDatosPatrocinador(false)">
                                            No</button>
                                        <button type="button" class="btn btn-danger"
                                            onclick="actualizarDatosPatrocinador(true)">Sí</button>
                                    </div>
                                </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script src="{{ asset('js/Patrocinador/crearPatrocinador.js') }}" defer></script>
@endsection
