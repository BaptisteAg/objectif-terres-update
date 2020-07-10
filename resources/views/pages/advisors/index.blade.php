@extends ('default')

@section ('title', 'Mon espace primo-accueillant')

@section('header')
    @include('components.advisor-tabs')
@endsection

@section('main-content')
    <div class="section pt-0">
        <h1 class="title is-2 has-text-link">Bienvenue sur votre espace primo-accueillant <span
                    class="is-italic">{{ Auth::user()->first_name }} {{ Auth::user()->name }}</span></h1>

        @if(! auth()->user()->notifications->isEmpty())
            @if($numberOfProjectToHandle !== 0 || $numberOfUnreadMessages !== 0)
                <div id="notification-advisor" class="notification has-background-info">
                    <button id="close-notification-advisor" class="delete"></button>
                    @if($numberOfProjectToHandle> 1)
                        <p class="has-text-white-ter">
                            <i class="far fa-bell has-text-white-ter"></i>
                            Vous avez<a style="text-decoration: none"
                                        href="#dashboard-advisor">
                                <strong>{{$numberOfProjectToHandle}}
                                    demandes d'accompagnement à traiter ! </strong></a>
                        </p>
                    @elseif ($numberOfProjectToHandle === 1)
                        <p class="has-text-white-ter">
                            <i class="far fa-bell has-text-white-ter"></i>
                            Vous avez<a style="text-decoration: none"
                                        href="#dashboard-advisor">
                                <strong>{{$numberOfProjectToHandle}}
                                    demande d'accompagnement à traiter! </strong></a>
                        </p>
                    @else
                    @endif
                    @if($numberOfUnreadMessages > 1 )
                        <a style="text-decoration: none" href="{{route('threads.index')}}"><p class="has-text-white"><i
                                        class="fas fa-envelope "></i> Vous
                                avez <strong>{{$numberOfUnreadMessages}}
                                    nouveaux messages
                                    !</strong></p></a>
                    @elseif ($numberOfUnreadMessages === 1 )
                        <a style="text-decoration: none" href="{{route('threads.index')}}">
                            <p class="has-text-white"><i class="fas fa-envelope"></i> Vous avez
                                <strong>{{$numberOfUnreadMessages}} nouveau message !</strong>
                            </p>
                        </a>
                    @else
                    @endif
                </div>
            @endif
        @endif
        {{Form::open(['route'=>'advisor.show', 'method'=>'get'])}}
        <div id="vue-form-advisor">
            @include('components.dashboard-filters')
            <div class="columns  ">
                <div class="column is-half ">
                    <div class="buttons are-medium">
                        <a href="{{route('advisor.export')}}" class="button  is-link">
                            <span class="icon">
                                <i class="fas fa-table"></i>
                            </span>
                            <span>Exporter</span>
                        </a>

                        <a href="{{route('advisor.createNewPp')}}" class="button  is-light ">
                            <span class="icon">
                                <i class="fas fa-user-plus"></i>
                            </span>
                            <span>Ajouter un PP</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
        {{Form::close()}}
        <div class="section">
            <h1 class="title is-1 has-text-centered">Activités sur votre
                territoire</h1>
            @if (count($ads) ==0)
                <p class="has-text-centered">Aucun résultat</p>
            @else
                <div class="content">
                    @if(request()->input('toPaginate') == 'true')
                        <a href="{{ route('advisor.show', array_diff_key(Request::all(), ['toPaginate'=>''])) }}">
                            <span>Afficher l'intégralité de la liste</span>
                        </a>
                    @elseif(request()->has('projects_show') )
                        <a href="{{ route('advisor.show', array_merge(Request::all(), ['toPaginate'=>'true'])) }}">
                            <span>Paginer la liste</span>
                        </a>
                    @elseif(request()->has('ads_show') )
                        <a href="{{ route('advisor.show', array_merge(Request::all(), ['toPaginate'=>'true'])) }}">
                            <span>Paginer la liste</span>
                        </a>
                    @else
                        <a href="{{ route('advisor.show', array_merge(Request::all(), ['toPaginate'=>'true', 'projects_show'=>'true'])) }}">
                            <span>Paginer la liste</span>
                        </a>
                    @endif
                </div>
                <div id="dashboard-advisor" class="table-container">
                    <table class="table is-bordered  is-striped is-narrow is-hoverable is-fullwidth "
                           style="border :2px solid #dbdbdb">
                        <thead>
                        <tr>
                            <th colspan="5" class="has-text-centered  " style="border-right :2px solid #dbdbdb">Profil
                                et nature de la
                                demande
                            </th>
                            <th colspan="4" class="has-text-centered" style="border-right :2px solid #dbdbdb">Suivi de
                                l'accompagnement
                            </th>
                            <th style="border-bottom: none;"></th>
                        </tr>
                        <tr>
                            <th class="has-text-weight-semibold" style="border-bottom :3px solid #dbdbdb">Catégorie</th>
                            <th class="has-text-weight-semibold" style="border-bottom :3px solid #dbdbdb">
                                @if(request()->input('sort') !== 'name')
                                    <a href="{{ route('advisor.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'name'])) }}">
                                        <span>Nom du porteur de projet</span>
                                    </a>
                                @elseif(request()->input('sort') === 'name' && request()->input('order') === 'asc')
                                    <a href="{{ route('advisor.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'name'])) }}">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>Nom du porteur de projet</span>
                                    </a>
                                @else
                                    <a href="{{ route('advisor.show', array_diff_key(Request::all(), ['order'=>'', 'sort'=>''])) }}">
                                        <i class="fas fa-arrow-down"></i>
                                        <span>Nom du porteur de projet</span>
                                    </a>
                                @endif
                            </th>
                            <th class="has-text-weight-semibold" style="border-bottom :3px solid #dbdbdb">
                                @if(request()->input('sort') !== 'project_statuses.name')
                                    <a href="{{ route('advisor.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'project_statuses.name'])) }}">
                                        <span>Avancement du projet</span>
                                    </a>
                                @elseif(request()->input('sort') === 'project_statuses.name' && request()->input('order') === 'asc')
                                    <a href="{{ route('advisor.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'project_statuses.name'])) }}">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>Avancement du projet</span>
                                    </a>
                                @else
                                    <a href="{{ route('advisor.show', array_diff_key(Request::all(), ['order'=>'', 'sort'=>''])) }}) }}">
                                        <i class="fas fa-arrow-down"></i>
                                        <span>Avancement du projet</span>
                                    </a>
                                @endif
                            </th>

                            <th class="has-text-weight-semibold" style="border-bottom :3px solid #dbdbdb">
                                Localisation(s)
                            </th>
                            <th class="has-text-weight-semibold"
                                style="border-right :2px solid #dbdbdb; border-bottom :3px solid #dbdbdb">
                                @if(request()->input('sort') !== 'title')
                                    <a href="{{ route('advisor.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'title'])) }}">
                                        <span>Titre</span>
                                    </a>
                                @elseif(request()->input('sort') === 'title' && request()->input('order') === 'asc')
                                    <a href="{{ route('advisor.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'title'])) }}">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>Titre</span>
                                    </a>
                                @else
                                    <a href="{{ route('advisor.show', array_diff_key(Request::all(), ['order'=>'', 'sort'=>''])) }}">
                                        <i class="fas fa-arrow-down"></i>
                                        <span>Titre</span>
                                    </a>
                                @endif
                            </th>


                            <th class="has-text-weight-semibold" style="border-bottom :3px solid #dbdbdb">
                                @if(request()->input('sort') !== 'date')
                                    <a href="{{ route('advisor.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'date'])) }}">
                                        <span>Date</span>
                                    </a>
                                @elseif(request()->input('sort') === 'date' && request()->input('order') === 'desc')
                                    <a href="{{ route('advisor.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'date'])) }}">
                                        <i class="fas fa-arrow-down"></i>
                                        <span>Date</span>
                                    </a>
                                @else
                                    <a href="{{ route('advisor.show', array_diff_key(Request::all(), ['order'=>'', 'sort'=>''])) }}">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>Date</span>
                                    </a>
                                @endif
                            </th>

                            <th class="has-text-weight-semibold" style="border-bottom :3px solid #dbdbdb">Suivi par</th>
                            <th class="has-text-weight-semibold" style="border-bottom :3px solid #dbdbdb">Stade de
                                l'accompagnement
                            </th>
                            <th class="has-text-weight-semibold"
                                style="border-right :2px solid #dbdbdb;  border-bottom :3px solid #dbdbdb">Etat de la
                                demande
                            </th>

                            <th class="has-text-weight-semibold " colspan="4"
                                style="width: 142px; border-width: 0px;  border-bottom :3px solid #dbdbdb "></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ads as $ad)
                            @if(!is_null($ad->attributionAd->userAdvisor))
                                @if($ad->attributionAd->userAdvisor->id === auth()->user()->id)
                                    <tr style=" background-color: #e8e8e8">
                                @else
                                    <tr>
                                @endif
                            @else
                                <tr>
                                    @endif
                                    <td>
                                        @if(!is_null($ad->project))
                                            <span class="icon is-medium  has-text-link has-tooltip-right"
                                                  data-tooltip="C'est une demande d'accompagnement">
                                                <i class="fas fa-lg fa-hands-helping"></i>
                                            </span>
                                        @else
                                            <span class="icon is-medium  has-text-link has-tooltip-right"
                                                  data-tooltip="C'est une annonce">
                                                <i class="fas fa-lg fa-newspaper"></i>
                                            </span>
                                        @endif
                                        {{$ad->ad_type_full_name}}
                                        <br>
                                    </td>
                                    <td>
                                        @if(is_null($ad->project))
                                            <a href="{{route('user.show', $ad->userPp->id)}}">{{$ad->userPp->first_name}} {{$ad->userPp->name}}</a>
                                        @else
                                            <a href="{{route('advisor.showSupport', $ad->id)}}">{{$ad->userPp->first_name}} {{$ad->userPp->name}}</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if(is_null($ad->project))
                                            <span>-</span>
                                        @else
                                            @if(!is_null($ad->project->projectStatus))
                                                @if($ad->project->projectStatus->id === \App\Models\ProjectStatus::EMERGING_ID)
                                                    <span class="tag is-info has-tooltip-bottom "
                                                          data-tooltip="{{\App\Models\ProjectStatus::TOOLTIPS[$ad->project->projectStatus->id]}}">{{$ad->project->projectStatus->name}}</span>
                                                @elseif($ad->project->projectStatus->id ===\App\Models\ProjectStatus::IN_PROGRESSING_ID)
                                                    <span class="tag is-info has-tooltip-bottom "
                                                          data-tooltip="{{\App\Models\ProjectStatus::TOOLTIPS[$ad->project->projectStatus->id]}}">{{$ad->project->projectStatus->name}}</span>
                                                @elseif($ad->project->projectStatus->id === \App\Models\ProjectStatus::ABANDONED_ID)
                                                    <span class="tag is-danger is-light has-tooltip-bottom "
                                                          data-tooltip="{{\App\Models\ProjectStatus::TOOLTIPS[$ad->project->projectStatus->id]}}">{{$ad->project->projectStatus->name}}</span>
                                                @elseif($ad->project->projectStatus->id === \App\Models\ProjectStatus::ACCOMPLISHED_ID)
                                                    <span class="tag is-success has-tooltip-bottom "
                                                          data-tooltip="{{\App\Models\ProjectStatus::TOOLTIPS[$ad->project->projectStatus->id]}}">{{$ad->project->projectStatus->name}}</span>
                                                @endif
                                            @else
                                                <span class="tag is-warning">Non définis</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if(! is_null($ad->regionsList))
                                            <p>Region(s) : {{$ad->regionsList}}</p>
                                        @endif
                                        @if(! is_null($ad->departmentsList))
                                            <p>Département(s) : {{$ad->departmentsList}}</p>
                                        @endif
                                        @if(! is_null($ad->citiesList))
                                            <p>Communes(s) : {{$ad->citiesList}}</p>
                                        @endif
                                    </td>
                                    <td style="border-right:2px solid #dbdbdb">
                                        @if(is_null($ad->project))
                                            <a href="{{route('ads.show', $ad->id)}}">{{$ad->title}}</a>

                                        @else
                                            <a href="{{route('advisor.showSupport', $ad->id)}}">{{$ad->title}}</a>

                                        @endif
                                    </td>
                                    <td>
                                        {{$ad->attributionAd->created_at->format("d/m/Y")}}
                                    </td>
                                    <td>
                                        @if(!is_null($ad->project_id))
                                            @if(isset($ad->attributionAd->userAdvisor))
                                                @if($ad->attributionAd->userAdvisor->id === auth()->user()->id)
                                                    <strong>Vous êtes le primo-accueillant de cette demande</strong>
                                                @else
                                                    Attribué
                                                    à
                                                    <strong>{{$ad->attributionAd->userAdvisor->first_name}} {{$ad->attributionAd->userAdvisor->name}}</strong>
                                                @endif
                                            @else
                                                <span class="tag is-danger is-light">Non attribué</span>
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if(is_null($ad->project))
                                            <span>-</span>
                                        @else
                                            @if(!is_null($ad->project->supportStage))
                                                @if($ad->project->supportStage->id === \App\Models\SupportStage::FIRST_CONTACT_ID)
                                                    <span class="tag is-info has-tooltip-bottom"
                                                          data-tooltip="{{\App\Models\SupportStage::TOOLTIPS[$ad->project->supportStage->id]}}">{{$ad->project->supportStage->name}}</span>
                                                @elseif($ad->project->supportStage->id ===\App\Models\SupportStage::FIRST_RECEPTION_ID)
                                                    <span class="tag is-info is-light  has-tooltip-bottom"
                                                          data-tooltip="{{\App\Models\SupportStage::TOOLTIPS[$ad->project->supportStage->id]}}">{{$ad->project->supportStage->name}}</span>
                                                @elseif($ad->project->supportStage->id === \App\Models\SupportStage::ACCOMPANYING_ID)
                                                    <span class="tag is-success  has-tooltip-bottom"
                                                          data-tooltip="{{\App\Models\SupportStage::TOOLTIPS[$ad->project->supportStage->id]}}">{{$ad->project->supportStage->name}}</span>
                                                @endif
                                            @else
                                                <span class="tag is-warning">Non définis</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td style="border-right:2px solid #dbdbdb">
                                        @if(is_null($ad->project))
                                            <span>-</span>
                                        @else
                                            @if(!is_null($ad->project->supportState))
                                                @if($ad->project->supportState->id === \App\Models\SupportState::TO_HANDLE_ID)
                                                    <span class="tag is-warning has-tooltip-bottom"
                                                          data-tooltip="{{\App\Models\SupportState::TOOLTIPS[$ad->project->supportState->id]}}">{{$ad->project->supportState->name}}</span>
                                                @elseif($ad->project->supportState->id ===\App\Models\SupportState::HANDLE_ID)
                                                    <span class="tag is-success is-light has-tooltip-bottom"
                                                          data-tooltip="{{\App\Models\SupportState::TOOLTIPS[$ad->project->supportState->id]}}">{{$ad->project->supportState->name}}</span>
                                                @elseif($ad->project->supportState->id === \App\Models\SupportState::PENDING_ID)
                                                    <span class="tag is-info is-light has-tooltip-bottom"
                                                          data-tooltip="{{\App\Models\SupportState::TOOLTIPS[$ad->project->supportState->id]}}">{{$ad->project->supportState->name}}</span>
                                                @elseif($ad->project->supportState->id === \App\Models\SupportState::ARCHIVE_ID)
                                                    <span class="tag is-light has-tooltip-bottom"
                                                          data-tooltip="{{\App\Models\SupportState::TOOLTIPS[$ad->project->supportState->id]}}">{{$ad->project->supportState->name}}</span>
                                                @elseif($ad->project->supportState->id === \App\Models\SupportState::TO_ARCHIVE_ID)
                                                    <span class="tag is-link is-light has-tooltip-bottom"
                                                          data-tooltip="{{\App\Models\SupportState::TOOLTIPS[$ad->project->supportState->id]}}">{{$ad->project->supportState->name}}</span>
                                                @endif
                                            @else
                                                <span class="tag is-warning">Non définis</span>
                                            @endif
                                        @endif
                                    </td>

                                    <td>
                                        @if(! is_null($ad->project))
                                            @if(isset($ad->attributionAd->user_advisor_id))
                                                <a href="{{route('advisor.showSupport', $ad->id)}}">
                                                    <span><i class="fas fa-hands-helping"></i></span>
                                                    <span>Suivi de l'accompagnement</span>
                                                </a>
                                            @elseif(auth()->user()->role >= 3)
                                                <a href="{{route('ads.show', $ad->id)}}">
                                                    <span><i class="fas fa-hands-helping"></i></span>
                                                    <span>Attribuer un primo-accueillant</span>
                                                </a>
                                            @else
                                                <span>En attente d'attribution par un responsable territorial</span>
                                            @endif

                                        @else
                                            <a href="{{route('ads.show', $ad->id)}}">
                                                <span><i class="fas fa-search"></i></span>
                                                <span>Voir le détail</span>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
                @if($ads instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="columns is-mobile is-centered">
                        <div class="column is-half ">
                            {{ $ads->appends(Request::all())->links() }}
                        </div>
                    </div>
                @endif
            @endif
        </div>


    </div>

@endsection

@section('script')

    <script>
        const vueAdvisor = new Vue({
            el: '#vue-form-advisor',
            name: 'content'
        });

        let buttons = document.querySelectorAll('.form-research-buttons');
        let icons = document.querySelectorAll('.form-research-buttons-icons');

        let deleteButton = document.querySelector('#close-notification-advisor');
        deleteButton.addEventListener('click', function (e) {
            let notification = document.querySelector('#notification-advisor');
            notification.style.display = 'none';
        });
    </script>

@endsection
