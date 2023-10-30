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
                        @php $contador = 1 @endphp
                        @foreach ($afiches as $afiche)
                            <tr onclick="seleccionarEvento({{ $afiche->id }}, '{{ $afiche->nombre }}', event)" id="{{ $afiche->id }}">
                                <th scope="row">{{ $contador++ }}</th>
                                <td>{{ $afiche->nombre }}</td>
                                <td class="text-center">{{ $afiche->tipoEvento->nombre }}</td>
                                <td class="text-center">{{ date('d-m-Y', strtotime($afiche->created_at)) }}</td>
                                <td class="text-center" id="contadorAfiches{{$afiche->id}}">{{ $afiche->afiches->count() }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-sm-12 col-md-4">
                <div
                    class="container d-flex flex-column justify-content-center align-items-center border p-3 container-image">
                    <h5 id="nombreEvento"></h5>
                    <div class="d-flex justify-content-center">

                        <img src="{{ asset('/image/uploading.png') }}" alt="image" id = "imagePreview"
                            class="rounded mx-auto d-block img-thumbnail">
                        <input type="file" id="imageUpload" class="d-none" accept="image/jpeg, image/png, image/jpg"
                            onchange="previsualizarImagen(event)">
                    </div>
                    <div class="d-flex justify-content-center mt-5">

                        <button type="button" class="btn btn-primary btn-lg hover-button" id="botonSubirAfiche"
                            onclick="document.getElementById('imageUpload').click()">Subir</button>
                        
                    </div>
                    <div id="contenedorAsignar" style="display: none">
                        <button type="button" class="btn btn-light btn-lg hover-button" onclick="document.getElementById('imageUpload').click()">Cambiar</button>
                        <button type="button" class="btn btn-primary btn-lg hover-button" onclick="asignarAfiche()">Asignar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('js/afiche.js') }}" defer></script>
@endsection