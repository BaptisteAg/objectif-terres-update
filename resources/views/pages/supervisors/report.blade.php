@extends('default')

@section ('title', 'Rapports et indicateurs')


@section('header')
    @include('components.supervisor-tabs')
@endsection

@section('main-content')

    <div class="section">
        <h1 class="title is-2 has-text-link">Rapports et indicateurs</h1>
    </div>
    @if ($numberOfAds == 0 and $numberOfProjects == 0 )

        <div class="columns is-mobile is-centered">
            <div class="column is-half">
                <p class="has-text-centered">Il n'y a pas d'annonces ou de demande d'accompagnement sur votre
                    territoire.</p>
            </div>
        </div>
    @else
        @if ($numberOfAds >0)
            <section class="section pt-0">
                <h2 class="has-text-centered mt-0">Les annonces</h2>
                <div class="columns is-mobile is-centered">
                    <div class="column is-two-thirds">
                        <div class="box">
                            <h3 class="title  has-text-centered ">Répartition des annonces par statut</h3>
                            <nav class="level is-mobile">
                                <div class="level-item has-text-centered ">
                                    <div>
                                        <p class="title has-text-warning">{{$numberOfAdsByAdStatus[\App\Models\AdStatus::PENDING_MODERATION_STATUS_ID]}}</p>
                                        <p class="heading h">en attente de modération</p>
                                    </div>
                                </div>
                                <div class="level-item has-text-centered ">
                                    <div>
                                        <p class="title has-text-danger">{{$numberOfAdsByAdStatus[\App\Models\AdStatus::REFUSE_ID]}}</p>
                                        <p class="heading ">refusées</p>
                                    </div>
                                </div>
                                <div class="level-item has-text-centered ">
                                    <div>
                                        <p class="title has-text-info">{{$numberOfAdsByAdStatus[\App\Models\AdStatus::ARCHIVED_ID]}}</p>
                                        <p class="heading ">archivées</p>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="columns is-mobile is-centered">
                    <div class="column is-one-third">
                        <h3 class="title  has-text-centered ">Répartition des annonces validées sur les départements</h3>
                        <table class="table is-hoverable has-text-centered center-element ">
                            <thead>
                            <tr>
                                <th></th>
                                @foreach($publishedAdsInEachDepartmentsByYears as $year=>$adsInEachDepartment)
                                    @foreach($adsInEachDepartment as $department => $ads)
                                        <th>{{$department}}</th>
                                    @endforeach
                                    @break
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($publishedAdsInEachDepartmentsByYears as $year=>$adsInEachDepartment)
                                <tr>
                                    <td>En {{$year}}</td>
                                    @foreach($adsInEachDepartment as $department => $ads)
                                        <td>{{$ads->count()}}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="column is-one-third">
                        <h3 class="title  has-text-centered ">Répartition des annonces validées sur les régions</h3>
                        <table class="table is-hoverable center-element ">
                            <thead>
                            <tr>
                                <th></th>
                                @foreach($publishedAdsInEachRegionsByYears as $adsInEachRegions)
                                    @foreach($adsInEachRegions as $region => $ads)
                                        <th>{{$region}}</th>
                                    @endforeach
                                    @break
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($publishedAdsInEachRegionsByYears as $year=>$adsInEachRegions)
                                <tr>
                                    <td>En {{$year}}</td>
                                    @foreach($adsInEachRegions as $region => $ads)
                                        <td>{{$ads->count()}}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="columns is-mobile is-centered">
                    <div class="column is-two-thirds">
                        <h3 class="title  has-text-centered ">Répartition des annonces soumises par mois</h3>
                        <h4 class="subtitle  has-text-centered ">
                            En {{\Illuminate\Support\Carbon::now()->subYear()->year}}</h4>
                        <table class="table is-hoverable center-element ">
                            <thead>
                            <tr>
                                @foreach($validatedAdsInYearGroupByMonth as $month=>$ads)
                                    <th>{{$month}}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                @foreach($validatedAdsInYearGroupByMonth as $month=>$ads)
                                    <th>{{$ads->count()}}</th>
                                @endforeach
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

        @endif
        @if($numberOfProjects > 0)
            <section class="section">
                <h2 class="has-text-centered">Les demandes d'accompagnement</h2>
                <div class="columns is-mobile is-centered">
                    <div class="column is-half">
                        <h3 class="has-text-centered">Répartiton par stade dans l'accompagnement </h3>
                        <table class="table is-hoverable has-text-centered center-element">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Premier contact</th>
                                <th>Primo-accueil</th>
                                <th>Accompagnement</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>En {{\Carbon\Carbon::now()->subYear()->year}}</td>
                                <td>
                                    @if(isset($projectsBySupportStages[\Carbon\Carbon::now()->subYear()->year]))
                                        @if($projectsBySupportStages[\Carbon\Carbon::now()->subYear()->year]->has(\App\Models\SupportStage::FIRST_CONTACT_ID) )
                                            {{$projectsBySupportStages[\Carbon\Carbon::now()->subYear()->year][\App\Models\SupportStage::FIRST_CONTACT_ID]->count()}}
                                        @else
                                            0
                                        @endif
                                    @else
                                        0
                                    @endif
                                </td>
                                <td>
                                    @if(isset($projectsBySupportStages[\Carbon\Carbon::now()->subYear()->year]))
                                        @if($projectsBySupportStages[\Carbon\Carbon::now()->subYear()->year]->has(\App\Models\SupportStage::FIRST_RECEPTION_ID ) )
                                            {{$projectsBySupportStages[\Carbon\Carbon::now()->subYear()->year][\App\Models\SupportStage::FIRST_RECEPTION_ID]->count()}}
                                        @else
                                            0
                                        @endif
                                    @else
                                        0
                                    @endif
                                </td>
                                <td>
                                    @if(isset($projectsBySupportStages[\Carbon\Carbon::now()->subYear()->year]))
                                        @if($projectsBySupportStages[\Carbon\Carbon::now()->subYear()->year]->has(\App\Models\SupportStage::ACCOMPANYING_ID) )
                                            {{$projectsBySupportStages[\Carbon\Carbon::now()->subYear()->year][\App\Models\SupportStage::ACCOMPANYING_ID]->count()}}
                                        @else
                                            0
                                        @endif
                                    @else
                                        0
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>En {{\Carbon\Carbon::now()->year}}</td>
                                <td>
                                    @if(isset($projectsBySupportStages[\Carbon\Carbon::now()->year]))
                                        @if($projectsBySupportStages[\Carbon\Carbon::now()->year]->has(\App\Models\SupportStage::FIRST_CONTACT_ID) )
                                            {{$projectsBySupportStages[\Carbon\Carbon::now()->year][\App\Models\SupportStage::FIRST_CONTACT_ID]->count()}}
                                        @else
                                            0
                                        @endif
                                    @else
                                        0
                                    @endif
                                </td>
                                <td>
                                    @if(isset($projectsBySupportStages[\Carbon\Carbon::now()->year]))
                                        @if($projectsBySupportStages[\Carbon\Carbon::now()->year]->has(\App\Models\SupportStage::FIRST_RECEPTION_ID) )
                                            {{$projectsBySupportStages[\Carbon\Carbon::now()->year][\App\Models\SupportStage::FIRST_RECEPTION_ID]->count()}}
                                        @else
                                            0
                                        @endif
                                    @else
                                        0
                                    @endif
                                </td>
                                <td>
                                    @if(isset($projectsBySupportStages[\Carbon\Carbon::now()->year]))
                                        @if($projectsBySupportStages[\Carbon\Carbon::now()->year]->has(\App\Models\SupportStage::ACCOMPANYING_ID) )
                                            {{$projectsBySupportStages[\Carbon\Carbon::now()->year][\App\Models\SupportStage::ACCOMPANYING_ID]->count()}}
                                        @else
                                            0
                                        @endif
                                    @else
                                        0
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="columns is-mobile is-centered">
                    <div class="column is-two-thirds">
                        <div class="box">
                            <h3 class="title  has-text-centered ">Répartition des demandes d'accompagnement par
                                statut</h3>
                            <h4 class="subtitle has-text-centered ">en {{\Carbon\Carbon::now()->subYear()->year}}</h4>
                            <nav class="level is-mobile">
                                <div class="level-item has-text-centered ">
                                    <div>
                                        <p class="title has-text-warning">
                                            @if(isset($projectsByProjectStatus[\Carbon\Carbon::now()->subYear()->year]))
                                                @if($projectsByProjectStatus[\Carbon\Carbon::now()->subYear()->year]->has(\App\Models\ProjectStatus::EMERGING_ID) )
                                                    {{$projectsByProjectStatus[\Carbon\Carbon::now()->subYear()->year][\App\Models\ProjectStatus::EMERGING_ID]->count()}}
                                                @else
                                                    0
                                                @endif
                                            @else
                                                0
                                            @endif
                                        </p>
                                        <p class="heading h">en émergence</p>
                                    </div>
                                </div>
                                <div class="level-item has-text-centered ">
                                    <div>
                                        <p class="title has-text-primary">
                                            @if(isset($projectsByProjectStatus[\Carbon\Carbon::now()->subYear()->year]))
                                                @if($projectsByProjectStatus[\Carbon\Carbon::now()->subYear()->year]->has(\App\Models\ProjectStatus::IN_PROGRESSING_ID) )
                                                    {{$projectsByProjectStatus[\Carbon\Carbon::now()->subYear()->year][\App\Models\ProjectStatus::IN_PROGRESSING_ID]->count()}}
                                                @else
                                                    0
                                                @endif
                                            @else
                                                0
                                            @endif
                                        </p>
                                        <p class="heading ">en cours</p>
                                    </div>
                                </div>
                                <div class="level-item has-text-centered ">
                                    <div>
                                        <p class="title has-text-danger">
                                            @if(isset($projectsByProjectStatus[\Carbon\Carbon::now()->subYear()->year]))
                                                @if($projectsByProjectStatus[\Carbon\Carbon::now()->subYear()->year]->has(\App\Models\ProjectStatus::ABANDONED_ID) )
                                                    {{$projectsByProjectStatus[\Carbon\Carbon::now()->subYear()->year][\App\Models\ProjectStatus::ABANDONED_ID]->count()}}
                                                @else
                                                    0
                                                @endif
                                            @else
                                                0
                                            @endif

                                        </p>
                                        <p class="heading ">abandonnées</p>
                                    </div>
                                </div>
                                <div class="level-item has-text-centered ">
                                    <div>
                                        <p class="title has-text-success">
                                            @if(isset($projectsByProjectStatus[\Carbon\Carbon::now()->subYear()->year]))
                                                @if($projectsByProjectStatus[\Carbon\Carbon::now()->subYear()->year]->has(\App\Models\ProjectStatus::ACCOMPLISHED_ID) )
                                                    {{$projectsByProjectStatus[\Carbon\Carbon::now()->subYear()->year][\App\Models\ProjectStatus::ACCOMPLISHED_ID]->count()}}
                                                @else
                                                    0
                                                @endif
                                            @else
                                                0
                                            @endif

                                        </p>
                                        <p class="heading ">abouties</p>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="columns is-mobile is-centered">
                    <div class="column is-two-thirds">
                        <div class="box">
                            <h3 class="title  has-text-centered ">Répartition des demandes d'accompagnement par état de
                                la demande</h3>
                            <h4 class="subtitle has-text-centered ">sur l'année en cours</h4>
                            <nav class="level is-mobile">
                                <div class="level-item has-text-centered ">
                                    <div>
                                        <p class="title has-text-warning">
                                            @if(isset($projectsBySupportStates[\Carbon\Carbon::now()->year]))
                                                @if($projectsBySupportStates[\Carbon\Carbon::now()->year]->has(\App\Models\SupportState::TO_HANDLE_ID) )
                                                    {{$projectsBySupportStates[\Carbon\Carbon::now()->year][\App\Models\SupportState::TO_HANDLE_ID]->count()}}
                                                @else
                                                    0
                                                @endif
                                            @else
                                                0
                                            @endif
                                        </p>
                                        <p class="heading ">à traiter</p>
                                    </div>
                                </div>
                                <div class="level-item has-text-centered ">
                                    <div>
                                        <p class="title has-text-primary">
                                            @if(isset($projectsBySupportStates[\Carbon\Carbon::now()->year]))
                                                @if($projectsBySupportStates[\Carbon\Carbon::now()->year]->has(\App\Models\SupportState::PENDING_ID) )
                                                    {{$projectsBySupportStates[\Carbon\Carbon::now()->year][\App\Models\SupportState::PENDING_ID]->count()}}
                                                @else
                                                    0
                                                @endif
                                            @else
                                                0
                                            @endif
                                        </p>
                                        <p class="heading ">en attente</p>
                                    </div>
                                </div>
                                <div class="level-item has-text-centered ">
                                    <div>
                                        <p class="title text_warning_orange">
                                            @if(isset($projectsBySupportStates[\Carbon\Carbon::now()->year]))
                                                @if($projectsBySupportStates[\Carbon\Carbon::now()->year]->has(\App\Models\SupportState::TO_ARCHIVE_ID) )
                                                    {{$projectsBySupportStates[\Carbon\Carbon::now()->year][\App\Models\SupportState::TO_ARCHIVE_ID]->count()}}
                                                @else
                                                    0
                                                @endif
                                            @else
                                                0
                                            @endif
                                        </p>
                                        <p class="heading ">à archiver</p>
                                    </div>
                                </div>
                                <div class="level-item has-text-centered ">
                                    <div>
                                        <p class="title has-text-success">
                                            @if(isset($projectsBySupportStates[\Carbon\Carbon::now()->year]))
                                                @if($projectsBySupportStates[\Carbon\Carbon::now()->year]->has(\App\Models\SupportState::HANDLE_ID) )
                                                    {{$projectsBySupportStates[\Carbon\Carbon::now()->year][\App\Models\SupportState::HANDLE_ID]->count()}}
                                                @else
                                                    0
                                                @endif
                                            @else
                                                0
                                            @endif
                                        </p>
                                        <p class="heading ">abouties</p>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="columns is-mobile is-centered">
                    <div class="column is-two-thirds">
                        <h3 class="title  has-text-centered ">Nombre de demande d’accompagnement par mois</h3>
                        <h4 class="subtitle  has-text-centered ">
                            En {{\Illuminate\Support\Carbon::now()->subYear()->year}}</h4>
                        <table class="table is-hoverable center-element ">
                            <thead>
                            <tr>
                                @foreach($projectsInYearGroupByMonth as $month=>$project)
                                    <th>{{$month}}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                @foreach($projectsInYearGroupByMonth as $month=>$project)
                                    <th>{{$project->count()}}</th>
                                @endforeach
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        @endif
    @endif


@endsection