@component('mail::message')
Hola <strong> {{ $participante->apellidos }} {{ $participante->nombres }} </strong>,

Parece que usted quiere inscribirse en el evento <strong> {{ $evento->nombre }} </strong>, confirme su participación pulsando el siguiente botón:

@component('mail::button', ['url' => url('confirmar/participante/'.$evento->id . '/' . $participante->codigo)])
Confirmar participación
@endcomponent

Si usted no ha solicitado esta inscripción, ignore este correo electrónico.

Gracias.

{{ config('app.name') }}

@endcomponent