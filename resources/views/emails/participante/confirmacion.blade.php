@component('mail::message')
Hola {{ $participante->apellidos }},

Parece que usted quiere inscribirse en el evento <strong> {{ $evento->nombre }} </strong>, copie el
siguiente código de acceso:
{{ $participante->codigo }}.
o presione el siguiente botón:

@component('mail::button', ['url' => ''])
Confirmar participación
@endcomponent

Si usted no ha solicitado esta inscripción, ignore este correo electrónico.
Gracias,<br>
{{ config('app.name') }}
@component('mail::footer')
@endcomponent
@endcomponent
