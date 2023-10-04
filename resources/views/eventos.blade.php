@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex" style="height: 625px;">
        <div class="col-2">
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
                                    <h5 class="modal-title" id="modalCrearTipoEventoLabel">Crear tipo de evento</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="needs-validation" novalidate>
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="validationCustom01" class="form-label">Nombre del tipo de evento*</label>
                                                    <input type="text" class="form-control" id="validationCustom01" value="" required>
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="validationCustom02" class="form-label">Descripcion del evento</label>
                                                    <input type="text" class="form-control double-height" id="validationCustom02" value="" required>
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="validationCustom04" class="form-label">Color de referencia</label>
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <div id="color-display" class="circle" style="background-color: #FF6347;"></div>
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <div class="row">
                                                                        <li>
                                                                            <a class="dropdown-item" onclick="changeColor('#FF6347')">
                                                                                <div class="circle" style="background-color: #FF6347;"></div>
                                                                            </a>
                                                                        </li>
                                                                    </div>
                                                                    <div class="row">
                                                                        <li>
                                                                            <a class="dropdown-item" onclick="changeColor('#FF6347')">
                                                                                <div class="circle" style="background-color: #FF6347;"></div>
                                                                            </a>
                                                                        </li>
                                                                    </div>
                                                                    <div class="row">
                                                                        <li>
                                                                            <a class="dropdown-item" onclick="changeColor('#FF6347')">
                                                                                <div class="circle" style="background-color: #FF6347;"></div>
                                                                            </a>
                                                                        </li>
                                                                    </div>
                                                                    <div class="row">
                                                                        <li>
                                                                            <a class="dropdown-item" onclick="changeColor('#FF6347')">
                                                                                <div class="circle" style="background-color: #FF6347;"></div>
                                                                            </a>
                                                                        </li>
                                                                    </div>
                                                                    <div class="row">
                                                                        <li>
                                                                            <a class="dropdown-item" onclick="changeColor('#FF6347')">
                                                                                <div class="circle" style="background-color: #FF6347;"></div>
                                                                            </a>
                                                                        </li>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="row">
                                                                        <li>
                                                                            <a class="dropdown-item" onclick="changeColor('#FF6347')">
                                                                                <div class="circle" style="background-color: #FF6347;"></div>
                                                                            </a>
                                                                        </li>
                                                                    </div>
                                                                    <div class="row">
                                                                        <li>
                                                                            <a class="dropdown-item" onclick="changeColor('#FF6347')">
                                                                                <div class="circle" style="background-color: #FF6347;"></div>
                                                                            </a>
                                                                        </li>
                                                                    </div>
                                                                    <div class="row">
                                                                        <li>
                                                                            <a class="dropdown-item" onclick="changeColor('#FF6347')">
                                                                                <div class="circle" style="background-color: #FF6347;"></div>
                                                                            </a>
                                                                        </li>
                                                                    </div>
                                                                    <div class="row">
                                                                        <li>
                                                                            <a class="dropdown-item" onclick="changeColor('#FF6347')">
                                                                                <div class="circle" style="background-color: #FF6347;"></div>
                                                                            </a>
                                                                        </li>
                                                                    </div>
                                                                    <div class="row">
                                                                        <li>
                                                                            <a class="dropdown-item" onclick="changeColor('#FF6347')">
                                                                                <div class="circle" style="background-color: #FF6347;"></div>
                                                                            </a>
                                                                        </li>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-primary">Confirmar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-1 vr"></div>
        <div class="col-9"></div>
    </div>
</div>
@endsection