@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-2">
            <h2>Registar participante de equipo</h2>
        </div>
        <div class="row g-5">
            <h3>{{$equipo->nombre}}</h3>
            <div class="col-sm-12">
                <table class="table table-responsive table-striped text-secondary  cursor" id="tablaEvento">
                    <caption>Eventos</caption>
                    <thead>
                        <tr>
                            <th scope="col" class="col-sm-3 col-md-3">Nombres de participante</th>
                            <th scope="col" class="col-sm-3 col-md-3">Apellidos de participante</th>
                            <th scope="col" class="col-sm-2 col-md-2 text-center">Correo</th>
                            <th scope="col" class="col-sm-3 col-md-3 text-center">Teléfono</th>
                            
                        </tr>
                    </thead>
                    <<tbody id="datosTabla">
                        @foreach ($equipo->integrantes as $integrante)
                            
                                <tr id="{{ $integrante->participante->id }}">
                                    <td>{{ $integrante->participante->nombres }}</td>
                                    <td class="text-center">{{ $integrante->participante->apellidos }}</td>
                                    <td class="text-center">{{ $integrante->participante->correo }}</td>
                                    <td class="text-center">{{$integrante->participante->telefono }}</td>
                                </tr>
                        @endforeach
                    </tbody>       
                </table>
                <button type="button" class="btn btn-primary btn-sm" 
                data-bs-toggle="modal" data-bs-target="#modal-inscribir">
                    inscribir participante al equipo
                </button>
                
                @component('components.modal-inscribir-participante')
                    @slot('evento', $evento)
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