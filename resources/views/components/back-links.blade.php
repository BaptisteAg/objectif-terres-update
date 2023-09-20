@php
    $roles = [
        1 => ['route' => 'moderator.index', 'text' => 'Retour à l\'espace modérateur'],
        2 => ['route' => 'advisor.index', 'text' => 'Retour à l\'espace primo-accueillant'],
        3 => ['route' => 'supervisor.index', 'text' => 'Retour au tableau de bord'],
    ];
    $userRole = auth()->user()->role;
@endphp

@if(array_key_exists($userRole, $roles))
    <a href="{{route($roles[$userRole]['route'])}}">
        <span class="icon-text">
            <span class="icon is-medium is-align-items-baseline">
                <i class="mdi mdi-24px mdi-arrow-left"></i>
            </span>
            <span>{{$roles[$userRole]['text']}}</span>
        </span>
    </a>
@endif
