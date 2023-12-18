@component('mail::message')
# Codigo de acceso

Hola <strong> {{ $participante->apellidos }} {{ $participante->nombres }} </strong>,

Parece que usted quiere inscribirse al equipo <strong> {{ $equipo->nombre }} </strong> en el evento <strong> {{ $evento->nombre }} </strong>, copie el siguiente código de
acceso:

<strong> {{ $participante->codigo }} </strong>


Si usted no ha solicitado esta inscripción, ignore este correo.

Gracias,<br>
ICPC UMSS
@endcomponent
