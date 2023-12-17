@component('mail::message')
# Codigo de acceso

Hola,

Parece que usted quiere inscribir a su equipo <strong> {{ $equipo->nombre }} </strong> en el evento <strong> {{ $evento->nombre }} </strong>, copie el siguiente código de
acceso:

<strong> {{ $equipo->codigo }} </strong>

o presione el siguiente botón:
@component('mail::button', ['url' => url('/eventos/inscripcion-evento/' . $evento->id . '/' . $equipo->codigo)])
    Confirmar participación
@endcomponent

Si usted no ha solicitado esta inscripción, ignore este correo.

Gracias,<br>
ICPC UMSS
@endcomponent
