@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hello!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

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

<p>Vous pouvez aussi soutenir notre initiative gratuite Objectif Terres en faisant un don*
    à Terre de Liens : <br>
</p>

<p style="text-align: center;">
    <a target="_blank" href="https://soutenir.terredeliens.org/objectifterre/~mon-don"
       class="button button-primary"
       style="font-family: 'Nunito', sans-serif; box-sizing: border-box; border-radius: 3px; box-shadow: 0 1px 4px rgb(0 0 0 / 16%); color: #BF0D0D; display: inline-block; text-decoration: none; -webkit-text-size-adjust: none; background-color: #ffffff; border-top: 10px solid #ffffff; border-right: 18px solid #ffffff; border-bottom: 10px solid #ffffff; border-left: 18px solid #ffffff;">
        Faire un don ou soutenir Objectif Terres
    </a>
</p>


{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Regards'),<br>
{{ config('app.name') }}
@endif


{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')

    <small>* Don déductible à 66% de l’impôt sur le revenu et à 75% de l’IFI</small><br><br>
@lang(
    "Si vous avez des problèmes pour cliquer le bouton \":actionText\", copiez-collez l'adresse ci-dessous \n".
    'dans un nouvel onglet:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endslot
@endisset
@endcomponent
