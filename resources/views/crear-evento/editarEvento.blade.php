@extends('layouts.app')

@section('content')
<table class="table table-striped table-hover">
<thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombre</th>
      <th scope="col">Fecha De Inicio</th>
      <th scope="col">Accion</th>
    </tr>
  </thead>
  <tbody>

  @foreach ($eventos as $key => $evento)
    <tr>
        <th scope="row"> {{$key +1}}</th>
        <td>{{$evento->nombre}}</th>
        <td>{{$evento->inicio_evento}}</th>
        <td><a href="{{ route('evento.editar', ['id' => $evento->id]) }}">editar</a></th>
    </tr>
  @endforeach
    
  </tbody>
</table>
@endsection