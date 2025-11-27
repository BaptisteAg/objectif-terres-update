@extends('default')

@section ('title', 'Mon tableau de bord')

@section('header')
    @include('components.supervisor-tabs')
@endsection

@section('main-content')
    <div class="section">
        <h1 class="title is-2 has-text-link">Bienvenue sur votre tableau de bord <span
                    class="is-italic">{{ Auth::user()->first_name }} {{ Auth::user()->name }}</span></h1>

        @if(! auth()->user()->notifications->isEmpty())
            @if($numberOfNotAssignProject !== 0 || $numberOfUnreadMessages !==0)
                <div id="notification-supervisor" class="notification has-background-info">
                    <button id="close-notification-supervisor" class="delete"></button>
                    @if($numberOfNotAssignProject>1)
                        <p class="has-text-white-ter">
                            <i class="far fa-bell has-text-white-ter"></i>
                            Vous avez<a style="text-decoration: none"
                                        href="/">
                                <strong>{{$numberOfNotAssignProject}}
                                    demandes d'accompagnement non assignées</strong></a> dans votre territoire !
                        </p>
                    @elseif ($numberOfNotAssignProject === 1)
                        <p class="has-text-white-ter">
                            <i class="far fa-bell has-text-white-ter"></i>
                            Vous avez<a style="text-decoration: none"
                                        href="/">
                                <strong>{{$numberOfNotAssignProject}}
                                    demande d'accompagnement non assignée</strong></a> dans votre territoire !
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
        {{Form::open(['route'=>'supervisor.show', 'method'=>'get', 'class' => 'exportable-form'])}}
            <div id="vue-form-supervisor">
                @include('components.dashboard-filters')
            </div>

            <div class="section pt-20">
                @if (count($ads) ==0)
                    <p class="has-text-centered">Aucun résultat</p>
                @else
                    <div class="content" style="float:left">
                        @if(request()->input('toPaginate') === 'true' || request()->input('toPaginate') === null)
                            @if($ads->count() <=1)
                                <p class="has-text-weight-bold">{{$ads->total()}} résultat</p>
                            @else
                                <p class="has-text-weight-bold">{{$ads->total()}} résultats</p>
                            @endif
                        @else
                            @if($ads->count() <=1)
                                <p class="has-text-weight-bold">{{$ads->count()}} résultat</p>
                            @else
                                <p class="has-text-weight-bold">{{$ads->count()}} résultats</p>
                            @endif
                        @endif

                        @if(request()->input('toPaginate') === 'true' || request()->input('toPaginate') === null)
                            @if(url()->current() == route('supervisor.index'))
                                <a href="{{ route('supervisor.index', array_merge(Request::all(), ['toPaginate'=>'false'])) }}">
                                    <span>Voir tous les résultats</span>
                                </a>
                            @else
                                <a href="{{ route('supervisor.show', array_merge(Request::all(), ['toPaginate'=>'false'])) }}">
                                    <span>Voir tous les résultats</span>
                                </a>
                            @endif
                        @else
                            @if(url()->current() == route('supervisor.index'))
                                <a href="{{ route('supervisor.index', array_merge(Request::all(), ['toPaginate'=>'true'])) }}">
                                    <span>Voir 15 résultats par page</span>
                                </a>
                            @else
                                <a href="{{ route('supervisor.show', array_merge(Request::all(), ['toPaginate'=>'true'])) }}">
                                    <span>Voir 15 résultats par page</span>
                                </a>
                            @endif
                        @endif
                    </div>

                    <div class="" style="float:right">
                        <div class="buttons are-medium">
                            <a href="javascript:exportPage()" class="button is-light is-link" id="exportButton">
                            <span class="icon">
                                <i class="fas fa-table"></i>
                            </span>
                                <span>Exporter cette page</span>
                            </a>

                        </div>
                        <div id="exportLoader"></div>
                    </div>

                    <div style="clear:both;height: 20px;"></div>


                    @if($ads instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="columns is-mobile is-centered mb-40">
                            <div class="column is-one-third ">
                                {{ $ads->appends(Request::all())->links() }}
                            </div>
                        </div>
                    @endif
                    <div class="table-container">
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

                            </tr>
                            <tr>
                                <th class="has-text-weight-semibold" style="border-bottom :3px solid #dbdbdb">Catégorie</th>
                                <th class="has-text-weight-semibold" style="border-bottom :3px solid #dbdbdb">
                                    @if(request()->input('sort') !== 'name')
                                        <a href="{{ route('supervisor.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'name'])) }}">
                                            <span>Nom du porteur de projet</span>
                                        </a>
                                    @elseif(request()->input('sort') === 'name' && request()->input('order') === 'asc')
                                        <a href="{{ route('supervisor.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'name'])) }}">
                                            <i class="fas fa-arrow-up"></i>
                                            <span>Nom du porteur de projet</span>
                                        </a>
                                    @else
                                        <a href="{{ route('supervisor.show', array_diff_key(Request::all(), ['order'=>'', 'sort'=>''])) }}">
                                            <i class="fas fa-arrow-down"></i>
                                            <span>Nom du porteur de projet</span>
                                        </a>
                                    @endif
                                </th>
                                <th class="has-text-weight-semibold" style="border-bottom :3px solid #dbdbdb">
                                    @if(request()->input('sort') !== 'project_statuses.name')
                                        <a href="{{ route('supervisor.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'project_statuses.name'])) }}">
                                            <span>Avancement du projet</span>
                                        </a>
                                    @elseif(request()->input('sort') === 'project_statuses.name' && request()->input('order') === 'asc')
                                        <a href="{{ route('supervisor.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'project_statuses.name'])) }}">
                                            <i class="fas fa-arrow-up"></i>
                                            <span>Avancement du projet</span>
                                        </a>
                                    @else
                                        <a href="{{ route('supervisor.show', array_diff_key(Request::all(), ['order'=>'', 'sort'=>''])) }})
                            }}">
                                            <i class="fas fa-arrow-down"></i>
                                            <span>Avancement du projet</span>
                                        </a>
                                    @endif
                                </th>
                                {{--                            <th class="has-text-weight-semibold" style="border-bottom :3px solid #dbdbdb">--}}
                                {{--                                Localisation(s)--}}
                                {{--                            </th>--}}
                                <th class="has-text-weight-semibold"
                                    style="border-right :2px solid #dbdbdb; border-bottom :3px solid #dbdbdb">
                                    @if(request()->input('sort') !== 'title')
                                        <a href="{{ route('supervisor.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'title'])) }}">
                                            <span>Titre</span>
                                        </a>
                                    @elseif(request()->input('sort') === 'title' && request()->input('order') === 'asc')
                                        <a href="{{ route('supervisor.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'title'])) }}">
                                            <i class="fas fa-arrow-up"></i>
                                            <span>Titre</span>
                                        </a>
                                    @else
                                        <a href="{{ route('supervisor.show', array_diff_key(Request::all(), ['order'=>'', 'sort'=>''])) }}">
                                            <i class="fas fa-arrow-down"></i>
                                            <span>Titre</span>
                                        </a>
                                    @endif
                                </th>


                                <th class="has-text-weight-semibold" style="border-bottom :3px solid #dbdbdb">
                                    @if(request()->input('sort') !== 'date')
                                        <a href="{{ route('supervisor.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'date'])) }}">
                                            <span>Date</span>
                                        </a>
                                    @elseif(request()->input('sort') === 'date' && request()->input('order') === 'desc')
                                        <a href="{{ route('supervisor.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'date'])) }}">
                                            <i class="fas fa-arrow-down"></i>
                                            <span>Date</span>
                                        </a>
                                    @else
                                        <a href="{{ route('supervisor.show', array_diff_key(Request::all(), ['order'=>'', 'sort'=>''])) }}">
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

                                <th class="has-text-weight-semibold"
                                    style="width: 142px; border-width: 0px;  border-bottom :3px solid #dbdbdb "></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ads as $ad)
                                @if(!is_null($ad->project))
                                    @if(!$ad->attributionAd->hasAttributedAdvisors())
                                        <tr style="background-color: mistyrose">
                                    @else
                                        @if($ad->attributionAd->isCurrentUserAdvisorOfAd() )
                                            <tr style=" background-color: #e8e8e8">
                                        @endif
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
                                            @if($ad->isProjectAttributedToAdvisor)
                                                <a href="{{route('advisor.showSupport', $ad->id)}}">{{$ad->pp_display_name}}</a>
                                            @else
                                                <a href="{{route('user.show', $ad->userPp->id)}}">{{$ad->pp_display_name}}</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if(is_null($ad->project))
                                                <span>-</span>
                                            @else
                                                @if(!is_null($ad->project->projectStatus))
                                                    @if($ad->project->projectStatus->id === \App\Models\ProjectStatus::EMERGING_ID)
                                                        <span class="tag is-info has-tooltip-bottom"
                                                              data-tooltip="{{\App\Models\ProjectStatus::TOOLTIPS[$ad->project->projectStatus->id]}}">{{$ad->project->projectStatus->name}}</span>
                                                    @elseif($ad->project->projectStatus->id ===\App\Models\ProjectStatus::IN_PROGRESSING_ID)
                                                        <span class="tag is-info is-light has-tooltip-bottom"
                                                              data-tooltip="{{\App\Models\ProjectStatus::TOOLTIPS[$ad->project->projectStatus->id]}}">{{$ad->project->projectStatus->name}}</span>
                                                    @elseif($ad->project->projectStatus->id === \App\Models\ProjectStatus::ABANDONED_ID)
                                                        <span class="tag is-danger has-tooltip-bottom"
                                                              data-tooltip="{{\App\Models\ProjectStatus::TOOLTIPS[$ad->project->projectStatus->id]}}">{{$ad->project->projectStatus->name}}</span>
                                                    @elseif($ad->project->projectStatus->id === \App\Models\ProjectStatus::ACCOMPLISHED_ID)
                                                        <span class="tag is-success has-tooltip-bottom"
                                                              data-tooltip="{{\App\Models\ProjectStatus::TOOLTIPS[$ad->project->projectStatus->id]}}">{{$ad->project->projectStatus->name}}</span>
                                                    @endif
                                                @else
                                                    <span class="tag is-warning">Non défini</span>
                                                @endif
                                            @endif
                                        </td>
                                        {{--                                    <td>--}}
                                        {{--                                        @if(! is_null($ad->regionsList))--}}
                                        {{--                                            <p>Region(s) : {{$ad->regionsList}}</p>--}}
                                        {{--                                        @endif--}}
                                        {{--                                        @if(! is_null($ad->departmentsList))--}}
                                        {{--                                            <p>Département(s) : {{$ad->departmentsList}}</p>--}}
                                        {{--                                        @endif--}}
                                        {{--                                        @if(! is_null($ad->citiesList))--}}
                                        {{--                                            <p>Communes(s) : {{$ad->citiesList}}</p>--}}
                                        {{--                                        @endif--}}
                                        {{--                                    </td>--}}
                                        <td style="border-right:2px solid #dbdbdb">
                                            @if(! is_null($ad->project))
                                                @if(isset($ad->attributionAd->user_advisor_id))
                                                    <a href="{{route('advisor.showSupport', $ad->id)}}">{{$ad->title}}</a>
                                                @else
                                                    <a href="{{route('ads.show', $ad->id)}}">{{$ad->title}}</a>
                                                @endif
                                            @else
                                                <a href="{{route('ads.show', $ad->id)}}">{{$ad->title}}</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($ad->attributionAd))
                                                {{$ad->attributionAd->created_at->format("d/m/Y") }}
                                            @endif
                                        </td>
                                        <td>
                                            @if(!is_null($ad->project_id))
                                                @if($ad->attributionAd->hasAttributedAdvisors())

                                                    @foreach($ad->attributionAd->getAdvisors() as $i => $advisor)
                                                        @if($i)
                                                            et
                                                        @endif
                                                        <strong>
                                                            {{$advisor->first_name}} {{$advisor->name}}
                                                        </strong>
                                                    @endforeach
                                                @else
                                                    <span class="tag is-danger">Non attribué</span>
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
                                                        <span class="tag is-info is-light has-tooltip-bottom"
                                                              data-tooltip="{{\App\Models\SupportStage::TOOLTIPS[$ad->project->supportStage->id]}}">{{$ad->project->supportStage->name}}</span>
                                                    @elseif($ad->project->supportStage->id === \App\Models\SupportStage::ACCOMPANYING_ID)
                                                        <span class="tag is-success is-light has-tooltip-bottom"
                                                              data-tooltip="{{\App\Models\SupportStage::TOOLTIPS[$ad->project->supportStage->id]}}">{{$ad->project->supportStage->name}}</span>
                                                    @endif
                                                @else
                                                    <span class="tag is-warning">Non défini</span>
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
                                                        <span class="tag is-success has-tooltip-bottom"
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
                                                    <span class="tag is-warning">Non défini</span>
                                                @endif
                                            @endif
                                        </td>

                                        <td>
                                            @if(! is_null($ad->project))
                                                @if(! is_null($ad->attributionAd->user_advisor_id))
                                                    <a href="{{route('ads.show', $ad->id)}}">
                                                        <span><i class="fas fa-hands-helping"></i></span>
                                                        <span>Attribuer à un autre primo-accueillant</span>
                                                    </a>
                                                @else
                                                    <a href="{{route('ads.show', $ad->id)}}">
                                                        <span><i class="fas fa-hands-helping"></i></span>
                                                        <span>Attribuer un primo-accueillant</span>
                                                    </a>
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
                        <div class="columns is-mobile is-one-third is-centered">
                            <div class="column is-half ">
                                {{ $ads->appends(Request::all())->links() }}
                            </div>
                        </div>
                    @endif
                @endif
            </div>

        {{Form::close()}}

    </div>

@endsection

@section('script')
    <script>
        function exportPage() {
            let urlParts = location.href.split("?")
            let queryString = urlParts[1] || ''

            if(location.href.indexOf("recherche") !== -1) {
                queryString = "search=1" + (queryString ? '&' : '') + queryString
            }

            window.open("{{route('supervisor.export')}}" + (queryString ? '?' + queryString : ''))
            document.getElementById("exportLoader").innerText = "Veuillez patienter un instant pour l'export.."
        }

        let deleteButton = document.querySelector('#close-notification-supervisor');
        if (deleteButton != null) {
            deleteButton.addEventListener('click', function (e) {
                    let notification = document.querySelector('#notification-supervisor');
                    notification.style.display = 'none';
                }
            )
        }
    </script>
@endsection
