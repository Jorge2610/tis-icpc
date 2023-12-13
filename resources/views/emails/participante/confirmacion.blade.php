@component('mail::message')
Hola {{$participante->apellidos}},

Para poder confirmar su participación en el evento, por favor haga click en el siguiente botón:


@component('mail::button', ['url' => ''])
    Confirmar participación
@endcomponent
Gracias,<br>
{{ config('app.name') }}
@component('mail::footer')
    <div class="footer" style="display: flex; justify-content: start; padding-x: 20px; ">
        <img src="{{ asset('image/logo-umss.png') }}" alt="Logo de la empresa" style="height: 75px; width: auto;">
        {{-- <img src="{{ asset('image/logo-departamento.png') }}" alt="Logo de la empresa" style="height: 65px; width: auto;"> --}}
    {{-- </div> --}}
@endcomponent
@endcomponent
