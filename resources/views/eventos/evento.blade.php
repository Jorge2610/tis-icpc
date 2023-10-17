@extends('layouts.app')

@section('content')
    <div class="container">
        {{ $evento->tipoEvento->nombre }}
    </div>
@endsection
