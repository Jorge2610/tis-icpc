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
                        <th scope="col" class="col-md-3" data-visible="false">Ordenador</th>
                        <th scope="col" class="col-md-3">Nombre del tipo de evento</th>
                        <th scope="col" class="col-md-2">Descripción</th>
                        <th scope="col" class="col-md-2 text-center">Color de referencia</th>
                        <th scope="col" class="col-md-2 text-center">Autor</th>
                        <th scope="col" class="col-md-3 text-center">Fecha de creación</th>
                    </tr>
                </thead>
                <tbody id="datosTabla">
                    @foreach ($tiposDeEventos as $tipoDeEvento)
                        @php
                            $fechaFormateada = date('d-m-Y', strtotime($tipoDeEvento->created_at));
                        @endphp
                        <tr>
                            <td>{{ $tipoDeEvento->created_at }}</td>
                            <td>{{ $tipoDeEvento->nombre }}</td>
                            <td title="{{ $tipoDeEvento->descripcion }}">
                                <span class="d-inline-block text-truncate" style="max-width: 150px;">
                                    {{ $tipoDeEvento->descripcion }}
                                </span>
                            </td>
                            <td class="container-color">
                                <div class="color-cell" style="background-color:{{ $tipoDeEvento->color }};"></div>
                            </td>
                            <td class="text-center">Yo</td>
                            <td class="text-center ">{{ $fechaFormateada }}</td>

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
    <script src="{{ asset('js/TipoDeEvento/tipoDeEvento.js') }}" defer></script>
@endsection
