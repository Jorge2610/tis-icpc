@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex align-items-center" style="min-height: 60vh">
            <div class="col-md-12">
                @if ($verificado->error)
                    <span class="fa-solid fa-triangle-exclamation fa-5x text-warning text-center"
                        style="display: block"></span>
                @else
                    <span class="fa-solid fa-envelope-circle-check fa-5x text-success text-center"
                        style="display: block"></span>
                @endif
                <h3 class="text-center mt-2"><i>{{ $verificado->mensaje }}</i></h3>
            </div>
        </div>
    </div>
@endsection
