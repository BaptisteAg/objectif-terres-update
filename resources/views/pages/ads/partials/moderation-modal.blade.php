@php
    $roleData = [
        'search' => [
            'route' => 'search.index',
            'title' => 'Retour à la recherche de terrain',
            'description' => 'Description de la recherche de terrain',
            'project' => 'Description du projet',
            'experience' => 'Expérience du porteur de projet',
            'info' => 'Informations sur le porteur de projet',
        ],
        'offer' => [
            'route' => 'offer.index',
            'title' => 'Retour à l\'offre de terrain',
            'description' => 'Description de l\'offre de terrain',
            'project' => 'Description du projet',
            'experience' => 'Expérience requise pour le poste',
            'info' => 'Informations sur l\'annonceur',
        ],
        'support' => [
            'route' => 'support.index',
            'title' => 'Retour à la demande de support',
            'description' => 'Description de la demande de support',
            'project' => 'Résumé du projet',
            'experience' => 'Expérience du demandeur de support',
            'info' => 'Informations sur le demandeur de support',
        ],
    ];
    $roleKeys = [
        1 => 'search',
        2 => 'offer',
        3 => 'support',
    ];
    $userRoleKey = $roleKeys[auth()->user()->role];
    $data = $roleData[$userRoleKey];
@endphp

<a href="{{route($data['route'])}}">
    <span class="icon-text">
        <span class="icon is-medium is-align-items-baseline">
            <i class="mdi mdi-24px mdi-arrow-left"></i>
        </span>
        <span>{{$data['title']}}</span>
    </span>
</a>

<div class="card-content">
    <div class="content">
        <p>{{$data['description']}}</p>
        <p>{{$data['project']}}</p>
        <p>{{$data['experience']}}</p>
        <p>{{$data['info']}}</p>
    </div>
</div>
