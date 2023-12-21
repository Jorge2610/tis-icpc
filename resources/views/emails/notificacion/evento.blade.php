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

Hola <strong> {{ ucwords(strtolower($notifiable->apellidos))}}  {{ ucwords(strtolower($notifiable->nombres))}}  {{ucwords(strtolower($notifiable->nombre))}}</strong>,




<p style="text-align: justify;">
{!! nl2br($data[1]) !!}
</p>
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
Este es un mensaje de notificación del evento: <strong> {{  $data[0]}} </strong>
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
