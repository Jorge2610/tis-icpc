@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row align-items-end">
            <div class="col-md-2">
                <h4>Tipo de evento</h4>
            </div>
            <div class="col-md-1">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-light btn-lg" data-bs-toggle="modal"
                    data-bs-target="#modalCrearTipoEvento">
                    +
                </button>
                <x-ModalCrearTipoEvento />
            </div>
            <div class="col-md-9">

            </div>
        </div>
        <div class="row mt-3">
            <table class="table table-striped text-secondary" id="tablaTipoDeEvento">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre del tipo de evento</th>
                        <th scope="col">Color de referencia</th>
                        <th scope="col">Creador</th>
                        <th scope="col">Fecha de creación</th>
                    </tr>
                </thead>
                <tbody id="datosTabla">
                </tbody>
            </table>
        </div>
    </div>

    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('js/tipoDeEvento.js') }}" defer></script>
@endsection
