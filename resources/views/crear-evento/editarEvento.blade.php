@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-2">
            <h4>Editar Evento</h4>
        </div>
        <div class="row g-5">
            <div class="col-sm-12">
                <table class="table table-responsive table-striped text-secondary  cursor" id="tablaEvento">
                    <caption>Eventos</caption>
                    <thead>
                        <tr>
                            <th scope="col" class="col-sm-3 col-md-3">Nombre del evento</th>
                            <th scope="col" class="col-sm-2 col-md-2 text-center">Tipo de evento</th>
                            <th scope="col" class="col-sm-3 col-md-3 text-center">Fecha de inicio del evento</th>
                            <th scope="col" class="col-sm-3 col-md-3 text-center">Fecha de fin del evento</th>
                            <th scope="col" class="col-sm-1 col-md-1 text-center font-sm">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="datosTabla">
                        @foreach ($eventos as $evento)
                            @if (strtotime($evento->fin_evento) >= time())
                                <tr id="{{ $evento->id }}">
                                    <td>{{ $evento->nombre }}</td>
                                    <td class="text-center">{{ $evento->tipoEvento->nombre }}</td>
                                    <td class="text-center">{{ date('d-m-Y', strtotime($evento->inicio_evento)) }}</td>
                                    <td class="text-center">{{ date('d-m-Y', strtotime($evento->fin_evento)) }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-primary btn-sm"
                                            onclick="redireccionarEditar('{{ route('evento.editar', ['id' => $evento->id]) }}')">
                                            <i class="fa-solid fa-pencil"></i>
                                        </button>

                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script src="{{ asset('js/Evento/tablaEditarEvento.js') }}" defer></script>
@endsection
