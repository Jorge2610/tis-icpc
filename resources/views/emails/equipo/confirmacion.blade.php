@component('mail::message')
Hola,

Parece que usted quiere unirse al equipo <strong> {{ $equipo->nombre }} </strong> en el evento <strong> {{ $evento->nombre }} </strong>, confirme su participación pulsando el siguiente botón:

@component('mail::button', ['url' => url('confirmar/participante/' . $participante->codigo)])
Confirmar participación
@endcomponent

Si usted no ha solicitado esta inscripción, ignore este correo electrónico.

Gracias.

{{ config('app.name') }}

@endcomponent
