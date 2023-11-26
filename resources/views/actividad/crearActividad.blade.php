@extends('layouts.app')

@section('content')
    <div class="container">
      <div class="row mb-2">
            <h2>Crear actividad</h2>
        </div>
        <div class="row g-5">
            <div class="col-sm-12 col-md-12">
                <table class="table table-responsive table-striped text-secondary" id="tablaEvento">
                    <caption>Eventos</caption>
                    <thead>
                        <tr>
                            <th scope="col" class="col-sm-3 col-md-3">Nombre del evento</th>
                            <th scope="col" class="col-sm-0 col-md-3 text-center">Tipo de evento</th>
                            <th scope="col" class="col-sm-3 col-md-2 text-center">Fecha de inicio del evento</th>
                            <th scope="col" class="col-sm-3 col-md-2 text-center">Fecha de fin del evento</th>
                            <th scope="col" class="col-sm-3 col-md-3 text-center font-sm">Cantidad de actividades</th>
                            <th scope="col" class="col-sm-3 col-md-2 text-center font-sm">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="datosTabla">
                        @foreach ($actividades as $actividad)
                            @if (strtotime($actividad->fin_evento) >= time())
                                <tr>
                                    <td>{{ $actividad->nombre }}</td>
                                    <td class="text-center">{{ $actividad->tipoEvento->nombre }}</td>
                                    <td class="text-center">{{ date('d-m-Y H:i', strtotime($actividad->inicio_evento)) }}</td>
                                    <td class="text-center">{{ date('d-m-Y H:i', strtotime($actividad->fin_evento)) }}</td>
                                    <td class="text-center" id="contadorRecursos{{ $actividad->id }}">
                                        {{ $actividad->actividades->count() }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-primary btn-sm"
                                                onclick="window.location.href='/admin/actividad/crear-actividad/{{ $actividad->id }}'"
                                        >
                                                <i class="bi bi-plus"></i>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script src="{{ asset('js/Actividad/verActividad.js') }}" defer></script>
@endsection
