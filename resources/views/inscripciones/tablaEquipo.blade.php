@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-2">
            <h2>Registar participante al equipo</h2>
        </div>
        <div class="row g-5">
            <h3>{{$equipo->nombre}}</h3>
            <p>Rango de participantes por equipo: 
                @if ($evento->equipo_minimo)
                    desde los 2
                @else
                    desde {{ $evento->equipo_minimo }}
                @endif
                hasta los {{ $evento->equipo_maximo }}
            </p>
            <div class="col-sm-12">
                <table class="table table-responsive table-striped text-secondary  cursor" id="tablaEvento">
                    <caption>Participantes</caption>
                    <thead>
                        <tr>
                            <th scope="col" class="col-sm-3 col-md-3">Nombres de participante</th>
                            <th scope="col" class="col-sm-3 col-md-3">Apellidos de participante</th>
                            <th scope="col" class="col-sm-2 col-md-2 text-center">Correo</th>
                            <th scope="col" class="col-sm-3 col-md-3 text-center">Teléfono</th>
                            
                        </tr>
                    </thead>
                    <tbody id="datosTabla">
                        @foreach ($equipo->integrantes as $integrante)
                                @if($integrante->participante)
                                <tr >
                                    <td>{{ $integrante->participantes->nombres }}</td>
                                    <td class="text-center">{{ $integrante->participantes->apellidos }}</td>
                                    <td class="text-center">{{ $integrante->participantes->correo }}</td>
                                    <td class="text-center">{{$integrante->participantes->telefono }}</td>
                                </tr>
                                @endif
                        @endforeach
                    </tbody>       
                </table>
                <button type="button" class="btn btn-primary btn-sm" 
                data-bs-toggle="modal" data-bs-target="#modal-inscribir"
                {{$equipo->integrantes->count() < $evento->equipo_maximo ? "" : "disabled"}}>
                    inscribir participante al equipo
                </button>
                
                @component('components.modal-inscribir-participante-equipo')
                    @slot('evento', $evento)
                    @slot('equipo', $equipo)
                @endcomponent
            </div>
        </div>
    </div>

    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script src="{{ asset('js/inscripciones/tablaEquipo.js') }}" defer></script>
@endsection