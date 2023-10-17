@extends('layouts.app')

@section('content')
    <div class="container" style="height: 625px;">
        <ul id="lista-eventos">
            <!-- Aquí se mostrarán los eventos -->
        </ul>
    </div>
    <script src="{{ asset('js/getEvento.js') }}" defer></script>
@endsection
