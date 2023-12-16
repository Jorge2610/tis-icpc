@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ config('app.name') }}
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
<a href=""> <img src={{ asset('image/logo-umss.png')}} style="height: 70px; width:auto;"> <br></a>
© {{ date('Y') }} {{ config('app.name') }}. @lang('Todos los derechos reservados.')
@endcomponent
@endslot
@endcomponent
