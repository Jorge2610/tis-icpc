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
                    <button type="button" class="btn btn-light btn-lg" data-bs-toggle="modal" data-bs-target="#modalCrearTipoEvento">
                        +
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="modalCrearTipoEvento" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCrearTipoEventoLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div class="contenedor-titulo">
                                        <h5 class="modal-title" id="modalCrearTipoEventoLabel">Crear tipo de evento</h5>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="formularioTipoEvento" class="needs-validation" action="{{ url('/eventos/crear-evento') }}" method="POST" novalidate>
                                        @csrf
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="validationCustom01" class="form-label">Nombre del tipo de evento*</label>
                                                    <input type="text" class="form-control custom-input" id="validationCustom01" value="" required>
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="validationCustom02" class="form-label">Descripcion del evento</label>
                                                    <textarea class="form-control" id="validationCustom02" rows="6" style="resize: none;" required></textarea>
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-5 mt-3">
                                                            <label for="validationCustom04" class="form-label">Color de referencia</label>
                                                        </div>
                                                        <div class="col-1 mt-3 custom-col">
                                                            <div class="dropdown">
                                                                <button class="btn btn-secondary dropdown-toggle d-flex align-items-center" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <div id="color-display" class="circle" style="background-color: #FF6347;"></div>
                                                                    <span class="caret ms-2"></span>
                                                                </button>
                                                                <ul class="dropdown-menu contenedor-color" aria-labelledby="dropdownMenuButton">
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <div class="row">
                                                                                <li>
                                                                                    <a class="dropdown-item" onclick="changeColor('#FF0000')">
                                                                                        <div class="circle" style="background-color: #FF0000;"></div>
                                                                                    </a>
                                                                                </li>
                                                                            </div>
                                                                            <div class="row">
                                                                                <li>
                                                                                    <a class="dropdown-item" onclick="changeColor('#00FF00')">
                                                                                        <div class="circle" style="background-color: #00FF00;"></div>
                                                                                    </a>
                                                                                </li>
                                                                            </div>
                                                                            <div class="row">
                                                                                <li>
                                                                                    <a class="dropdown-item" onclick="changeColor('#0000FF')">
                                                                                        <div class="circle" style="background-color: #0000FF;"></div>
                                                                                    </a>
                                                                                </li>
                                                                            </div>
                                                                            <div class="row">
                                                                                <li>
                                                                                    <a class="dropdown-item" onclick="changeColor('#FF00FF')">
                                                                                        <div class="circle" style="background-color: #FF00FF;"></div>
                                                                                    </a>
                                                                                </li>
                                                                            </div>
                                                                            <div class="row">
                                                                                <li>
                                                                                    <a class="dropdown-item" onclick="changeColor('#FFFF00')">
                                                                                        <div class="circle" style="background-color: #FFFF00;"></div>
                                                                                    </a>
                                                                                </li>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="row">
                                                                                <li>
                                                                                    <a class="dropdown-item" onclick="changeColor('#000000')">
                                                                                        <div class="circle" style="background-color: #000000;"></div>
                                                                                    </a>
                                                                                </li>
                                                                            </div>
                                                                            <div class="row">
                                                                                <li>
                                                                                    <a class="dropdown-item" onclick="changeColor('#800000')">
                                                                                        <div class="circle" style="background-color: #800000;"></div>
                                                                                    </a>
                                                                                </li>
                                                                            </div>
                                                                            <div class="row">
                                                                                <li>
                                                                                    <a class="dropdown-item" onclick="changeColor('#FF8000')">
                                                                                        <div class="circle" style="background-color: #FF8000;"></div>
                                                                                    </a>
                                                                                </li>
                                                                            </div>
                                                                            <div class="row">
                                                                                <li>
                                                                                    <a class="dropdown-item" onclick="changeColor('#BBBB20')">
                                                                                        <div class="circle" style="background-color: #BBBB20;"></div>
                                                                                    </a>
                                                                                </li>
                                                                            </div>
                                                                            <div class="row">
                                                                                <li>
                                                                                    <a class="dropdown-item" onclick="changeColor('#FF8080')">
                                                                                        <div class="circle" style="background-color: #FF8080;"></div>
                                                                                    </a>
                                                                                </li>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button id="confirmarBoton" type="submit" class="btn btn-primary" data-bs-dismiss="modal">Confirmar</button>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-1 text-center">
                <h6>Tipo de evento 1</h6>
            </div>
        </div>
        <div class="col-10"></div>
    </div>
</div>


@endsection