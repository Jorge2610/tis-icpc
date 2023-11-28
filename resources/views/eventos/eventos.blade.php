@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-5 d-flex justify-content-center">
            <div class="col-offset-6 col-lg-6 col-md-12 col-sm-12">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input class="form-control" type="text" placeholder="Buscar evento..." onkeyup="buscarEvento()"
                        id="buscadorDeEvento">
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12" style="width: 565px;">
            <input id="datoEventos" type="text" value={{ $eventos }} hidden>
        </div>
        <div class="row g-5" id="tarjetasRow">
            @foreach ($eventos as $evento)
                <div class="col-md-auto">
                    <div class="tarjeta card mb-3" style="max-width: 540px; min-height: 200px; ">
                        <div class="row g-0">
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold" id="nombreEvento">{{ $evento->nombre }}</h5>
                                    <h6 id="tipoDeEvento">{{ $evento->tipoEvento->nombre }}</h6>
                                    <hr>
                                    </hr>
                                    <p class="cart-text">
                                        <span>Fecha del evento:</span>
                                        <span id="fechaInicioEvento"
                                            class="mx-2 fst-italic">{{ date('d-m-Y', strtotime($evento->inicio_evento)) }}</span>
                                        <span id="fechaFinEvento"
                                            class="fst-italic">{{ date('d-m-Y', strtotime($evento->fin_evento)) }}</span>
                                    </p>
                                    <div class="row text-end">
                                        <a href="{{ route('evento.cargarEvento', ['nombre' => $evento->nombre]) }}"
                                            id="linkEvento" class="text-decoration-none stretched-link">Saber
                                            más...</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex p-3 justify-content-center col-md-4" style="height: 195px">

                            <img src="{{ URL::asset($evento->afiches->count() > 0 ? $evento->afiches->first()->ruta_imagen : '../image/aficheDefecto.png') }}"
                                class="img-fluid rounded-start object-fit-scale" alt="...">
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script src="{{ asset('js/eventos.js') }}" defer></script>
@endsection
