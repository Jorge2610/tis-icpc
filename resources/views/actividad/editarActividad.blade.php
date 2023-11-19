@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row g-5">
            <div class="col-sm-12 col-md-11">
                <table class="table table-responsive table-striped text-secondary" id="tablaEvento">
                    <caption>actividades</caption>
                    <thead>
                        <tr>
                            <th scope="col" class="col-sm-2 col-md-1">#</th>
                            <th scope="col" class="col-sm-4 col-md-4">Nombre del evento</th>
                            <th scope="col" class="col-sm-0 col-md-3 text-center">Tipo de evento</th>
                            <th scope="col" class="col-sm-3 col-md-2 text-center">Fecha de creación</th>
                            <th scope="col" class="col-sm-3 col-md-2 text-center font-sm">Cantidad de actividades</th>
                        </tr>
                    </thead>
                    <tbody id="datosTabla">
                        @php $contador = 1 @endphp
                        @foreach ($actividades as $actividad)
                            <tr>
                                <th scope="row">{{ $contador++ }}</th>
                                <td>{{ $actividad->nombre }}</td>
                                <td class="text-center">{{ $actividad->tipoEvento->nombre }}</td>
                                <td class="text-center">{{ date('d-m-Y', strtotime($actividad->created_at)) }}</td>
                                <td class="text-center" id="contadorRecursos{{ $actividad->id }}">
                                    {{ $actividad->actividades->count() }}</td>
                            </tr>
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
    <script src="{{ asset('js/Actividad/editarActividad.js') }}" defer></script>
@endsection
