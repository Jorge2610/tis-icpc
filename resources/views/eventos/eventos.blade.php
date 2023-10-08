@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex" style="height: 625px;">
            <div class="col-2 border-end">
                <div class="row justify-content-start">
                    <div class="col-8">
                        <a class="text-decoration-none text-dark" href="{{ url('/eventos/crear-evento') }}">
                            <h5>Crear evento</h5>
                        </a>
                    </div>
                    <div class="col-3"></div>
                </div>

                <div id="alertsContainer" class="customAlertContainer"></div>
                <div class="row align-items-end">
                    <div class="col-8 ">
                        <h5>Tipo de evento</h5>
                    </div>
                    <div class="col-4">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-light btn-lg" data-bs-toggle="modal"
                            data-bs-target="#modalCrearTipoEvento">
                            +
                        </button>
                        <x-ModalCrearTipoEvento/>
                    </div>
                </div>
                <div class="col-12 mt-1 text-center">
                    <h6>Tipo de evento 1</h6>
                </div>
            </div>
            <div class="col-10"></div>
        </div>
    </div>

    <script src="{{ asset('js/crearTipoDeEvento.js') }}" defer></script>
@endsection
