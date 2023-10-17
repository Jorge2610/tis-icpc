@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row g-5" id="tarjetasRow">
            <div class="col-md-auto">
                <div class="tarjeta card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title fw-bold" id="nombreEvento">Evento 1</h5>
                                <h6 id="tipoDeEvento">Tipo del evento</h6>
                                <hr>
                                </hr>
                                <p class="cart-text">
                                    <span>Inscripciones:</span>
                                    <span id="fechaInicioIns" class="mx-2 fst-italic">16/10/2023</span>
                                    <span id="fechaFinIns" class="fst-italic">16/10/2023</span>
                                </p>
                                <p class="cart-text">
                                    <span>Fecha del evento:</span>
                                    <span id="fechaInicioEvento" class="mx-2 fst-italic">16/10/2023</span>
                                    <span id="fechaFinEvento" class="fst-italic">16/10/2023</span>
                                </p>
                                <div class="row text-end">
                                    <a href="#" id="linkEvento" class="text-decoration-none stretched-link">Saber
                                        más...</a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex p-3 align-self-center col-md-4">
                            <img src="{{ URL::asset('/image/icpc.png') }}" class="img-fluid rounded-start" alt="...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-auto">
                <div class="tarjeta card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title fw-bold" id="nombreEvento">Evento 1</h5>
                                <h6 id="tipoDeEvento">Tipo del evento</h6>
                                <hr>
                                </hr>
                                <p class="cart-text">
                                    <span>Inscripciones:</span>
                                    <span id="fechaInicioIns" class="mx-2 fst-italic">16/10/2023</span>
                                    <span id="fechaFinIns" class="fst-italic">16/10/2023</span>
                                </p>
                                <p class="cart-text">
                                    <span>Fecha del evento:</span>
                                    <span id="fechaInicioEvento" class="mx-2 fst-italic">16/10/2023</span>
                                    <span id="fechaFinEvento" class="fst-italic">16/10/2023</span>
                                </p>
                                <div class="row text-end">
                                    <a href="#" id="linkEvento" class="text-decoration-none stretched-link">Saber
                                        más...</a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex p-3 align-self-center col-md-4">
                            <img src="{{ URL::asset('/image/icpc.png') }}" class="img-fluid rounded-start" alt="...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-auto">
                <div class="tarjeta card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title fw-bold" id="nombreEvento">Evento 1</h5>
                                <h6 id="tipoDeEvento">Tipo del evento</h6>
                                <hr>
                                </hr>
                                <p class="cart-text">
                                    <span>Inscripciones:</span>
                                    <span id="fechaInicioIns" class="mx-2 fst-italic">16/10/2023</span>
                                    <span id="fechaFinIns" class="fst-italic">16/10/2023</span>
                                </p>
                                <p class="cart-text">
                                    <span>Fecha del evento:</span>
                                    <span id="fechaInicioEvento" class="mx-2 fst-italic">16/10/2023</span>
                                    <span id="fechaFinEvento" class="fst-italic">16/10/2023</span>
                                </p>
                                <div class="row text-end">
                                    <a href="#" id="linkEvento" class="text-decoration-none stretched-link">Saber
                                        más...</a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex p-3 align-self-center col-md-4">
                            <img src="{{ URL::asset('/image/icpc.png') }}" class="img-fluid rounded-start" alt="...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-auto">
                <div class="tarjeta card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title fw-bold" id="nombreEvento">Evento 1</h5>
                                <h6 id="tipoDeEvento">Tipo del evento</h6>
                                <hr>
                                </hr>
                                <p class="cart-text">
                                    <span>Inscripciones:</span>
                                    <span id="fechaInicioIns" class="mx-2 fst-italic">16/10/2023</span>
                                    <span id="fechaFinIns" class="fst-italic">16/10/2023</span>
                                </p>
                                <p class="cart-text">
                                    <span>Fecha del evento:</span>
                                    <span id="fechaInicioEvento" class="mx-2 fst-italic">16/10/2023</span>
                                    <span id="fechaFinEvento" class="fst-italic">16/10/2023</span>
                                </p>
                                <div class="row text-end">
                                    <a href="#" id="linkEvento" class="text-decoration-none stretched-link">Saber
                                        más...</a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex p-3 align-self-center col-md-4">
                            <img src="{{ URL::asset('/image/icpc.png') }}" class="img-fluid rounded-start" alt="...">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
