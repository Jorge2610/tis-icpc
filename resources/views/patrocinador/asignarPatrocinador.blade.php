@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-2">
            <h4>Asignar patrocinador a un evento</h4>
        </div>
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
            <div class="col-sm-12 col-md-4">
                <div
                    class="container d-flex flex-column justify-content-center align-items-center border p-3 container-image">
                    <div class="col-12 d-flex justify-content-center align-items-center">
                        <h4>Asignar patrocinador</h4>
                    </div>
                    <h5 id="nombreEvento" class="text-center fw-bold"></h5>
                    <div class="d-flex justify-content-center">

                        <img src="{{ asset('/image/uploading.png') }}" alt="image" id = "imagePreview"
                            class="rounded mx-auto d-block img-thumbnail" style="max-height: 270px; max-width: 270px">
                        <input type="file" id="imageUpload" class="d-none" accept="image/jpeg, image/png, image/jpg"
                            onchange="previsualizarImagen(event)">
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        <button type="button" class="btn btn-light text-primary" id="botonSubirLogoPatrocinador"
                            onclick="document.getElementById('imageUpload').click()">Subir logo</button>
                    </div>
                    <form class="needs-validation" novalidate id="formularioAgregarPatrocinador">
                        <div class="col-md-12 mt-2">
                            <label for="nombrePatricinador" class="form-label">Nombre
                                del patrocinador *</label>
                            <input name="id_evento" type="hidden" id="id_evento">
                            <input name="nombre" type="text" class="form-control custom-input" id="nombrePatricinador"
                                value="" placeholder="Ingrese un nombre" required>
                            <div class="invalid-feedback">
                                El nombre no puede estar vacio.
                            </div>
                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="urlPatrocinador" class="form-label">Enlace
                                a la página web del patrocinador</label>
                            <input name="enlace_web" type="url" class="form-control custom-input" id="urlPatrocinador"
                                value="" placeholder="https://www.ejemplo.com">
                        </div>
                    </form>
                    <div class="d-flex justify-content-center mt-3">
                        <button type="button" class="btn btn-light" onclick="resetInputs()"
                            id="asignarPatrocinadorCancelar">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="validarDatos()"
                            id="asignarPatrocinadorAsignar">Asignar</button>
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
    <script src="{{ asset('js/Patrocinador/patrocinador.js') }}" defer></script>
@endsection
