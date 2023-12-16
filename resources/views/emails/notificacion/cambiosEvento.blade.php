@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hola! ')
@endif
@endif

{{-- Intro Lines --}}

Hola <strong> {{ ucwords(strtolower($notificable->apellidos))}}  {{ ucwords(strtolower($notificable->nombres))}} </strong>,

Se realizaron cambios en el evento: <strong> {{ $evento->nombre }} </strong> en el que estas inscrito,  la fecha de modificación fue: <strong> {{ date('d-m-Y', strtotime($evento->updated_at)) }} </strong> a las <strong>{{ date('H:i', strtotime($evento->updated_at)) }}</strong>.

Por favor vea los cambios presionando el siguiente botón:


{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
Gracias!<br>
ICPC UMSS

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
    "Si tienes problemas con el botón \":actionText\",  \n".
    'copia y pega la URL:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
<br>
@endslot
@endisset


@endcomponent
