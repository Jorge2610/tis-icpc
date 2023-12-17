@component('mail::message')
Hola,

Parece que usted quiere inscribir a su equipo <strong> {{ $equipo->nombre }} </strong> en el evento <strong> {{ $evento->nombre }} </strong>, confirme su participación pulsando el siguiente botón:

@component('mail::button', ['url' => url('confirmar/equipo/' . $equipo->codigo)])
Confirmar participación
@endcomponent

Si usted no ha solicitado esta inscripción, ignore este correo electrónico.

Gracias.

{{ config('app.name') }}

@endcomponent
