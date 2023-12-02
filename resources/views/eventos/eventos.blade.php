@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-5 d-flex justify-content-center">
            <div class="col-md-auto">
                <label for="select_ver" class="form-label">Ver</label>
                <select id="select_ver" class="form-select" aria-label="ver" onchange="filtrarVer()">
                    <option value="1" selected>Todos</option>
                    <option value="2">En curso</option>
                    <option value="3">Futuros</option>
                    <option value="4">Pasados</option>
                </select>
            </div>

            <div class="col-md-auto">
                <label for="select_tipo_evento" class="form-label">Tipo de evento</label>
                <select id="select_tipo_evento" class="form-select" aria-label="tipos" onchange="filtrarTipo()">
                    <option selected>Todos</option>
                </select>
            </div>

            <div class="col-md-auto">
                <label for="select_por" class="form-label">Ordenar por</label>
                <select id="select_por" class="form-select" aria-label="" onchange="mostrarEventos()">
                    <option value="1">A-Z</option>
                    <option value="2">Z-A</option>
                    <option value="3" selected>Más recientes</option>
                    <option value="4">Más antiguos</option>
                </select>
            </div>

            <div class="col-md" style="margin-left:100px;">
                <div class="input-group" style="margin-top: 33px;">
                    <span class="input-group-text">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input class="form-control" type="text" placeholder="Buscar evento..." onkeyup="buscarEvento()"
                        id="buscadorDeEvento" style="max-width: 475px;">
                </div>
            </div>           
        </div>

        <div class="col-xl-12 col-lg-12" style="width: 565px;">
            <input id="datoEventos" type="text" value={{ $eventos }} hidden>
        </div>
        <div class="row g-5" id="tarjetasRow">
            @foreach ($eventos as $evento)
                <div class="col-md-auto">
                    <div class="tarjeta card mb-3" style="width: 540px; min-height: 200px; ">
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
