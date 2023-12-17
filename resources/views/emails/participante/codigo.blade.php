@component('mail::message')
# Codigo de participación

Hola <strong> {{ $participante->apellidos }} {{ $participante->nombres }} </strong>,

Parece que usted quiere inscribirse en el evento <strong> {{ $evento->nombre }} </strong>, copie el siguiente código de
acceso:

```<strong> hola </strong>```

o presione el siguiente botón:
@component('mail::button', ['url' => url('/eventos/inscripcion-evento/' . $evento->id . '/' . $participante->id)])
    Confirmar participación
@endcomponent

Si usted no ha solicitado esta inscripción, ignore este correo.

Gracias,<br>
ICPC UMSS
@endcomponent
