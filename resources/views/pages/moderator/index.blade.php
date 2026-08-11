@php use App\Models\AdStatus; @endphp
@extends ('default')

@if(auth()->user()->role >=3)
    @section ('title', 'Gestion des annonces')
@else
    @section ('title', 'Espace modérateur')
@endif


@section('header')
    @if(auth()->user()->role >= 3)
        @include('components.supervisor-tabs')
    @elseif (auth()->user()->role ===2)
        @include('components.advisor-tabs')
    @elseif(auth()->user()->role === 1 )
        @include('components.moderator-tabs')
    @endif
@endsection

@section('main-content')
    <div class="section pt-10">
        @if(auth()->user()->role >= 3 )
            <h1 class="title is-2 has-text-link">Bienvenue sur votre espace de gestion des annonces
                <span class="is-italic">{{ Auth::user()->first_name }} {{ Auth::user()->name }}</span>
            </h1>
        @else
            <h1 class="title is-2 has-text-link">Bienvenue sur votre espace modérateur
                <span class="is-italic">{{ Auth::user()->first_name }} {{ Auth::user()->name }}</span>
            </h1>
        @endif

        {{--        @if($numberOfAdsToModerate !== 0 || $numberOfUnreadMessages !==0)--}}
        {{--            <div id="notification-moderator" class="notification has-background-info">--}}
        {{--                <button id="close-notification-moderator" class="delete"></button>--}}
        {{--                @if($numberOfAdsToModerate === 0)--}}
        {{--                @elseif($numberOfAdsToModerate >1)--}}
        {{--                    <p class="has-text-white-ter">--}}
        {{--                        <i class="far fa-bell has-text-white-ter"></i>--}}
        {{--                        Vous avez<a style="text-decoration: none"--}}
        {{--                                    href="{{route('moderator.show', ['citySelect=[]&radius_research=&ad_statuses[]=4'])}}">--}}
        {{--                            <strong>{{$numberOfAdsToModerate}}--}}
        {{--                                annonces</strong></a> à modérer !</p>--}}
        {{--                @else--}}
        {{--                    <p class="has-text-white-ter">--}}
        {{--                        <i class="far fa-bell has-text-white-ter"></i>--}}
        {{--                        Vous avez<a style="text-decoration: none"--}}
        {{--                                    href="{{route('moderator.show', ['citySelect=[]&radius_research=&ad_statuses[]=4'])}}">--}}
        {{--                            <strong>{{$numberOfAdsToModerate}} annonce</strong>--}}
        {{--                        </a>à modérer !</p>--}}
        {{--                @endif--}}

        {{--                @if($numberOfUnreadMessages === 0)--}}
        {{--                @elseif($numberOfUnreadMessages > 1 )--}}
        {{--                    <a style="text-decoration: none" href="{{route('threads.index')}}"><p class="has-text-white"><i--}}
        {{--                                    class="fas fa-envelope "></i> Vous--}}
        {{--                            avez <strong>{{$numberOfUnreadMessages}}--}}
        {{--                                nouveaux messages--}}
        {{--                                !</strong></p></a>--}}

        {{--                @else--}}
        {{--                    <a style="text-decoration: none" href="{{route('threads.index')}}">--}}
        {{--                        <p class="has-text-white"><i class="fas fa-envelope"></i> Vous avez--}}
        {{--                            <strong>{{$numberOfUnreadMessages}} nouveau message !</strong>--}}
        {{--                        </p>--}}
        {{--                    </a>--}}
        {{--                @endif--}}
        {{--            </div>--}}
        {{--        @endif--}}

        {{Form::open(['route'=>'moderator.show', 'method'=>'get'])}}
        <div id="vue-form-moderator" class="mt-50">
            @include('components.dashboard-filters')
        </div>
        {{Form::close()}}


        <div class="section pt-20">
            @if (count($attributionAds) == 0)
                <p class="has-text-centered">Aucun résultat</p>
            @else
                <div class="mb-4">
                    <span class="tag is-large is-info">
                        {{$attributionAds->total()}} résultat{{ $attributionAds->count() > 1 ? 's' : '' }}
                    </span>
                </div>
                <div class="table-container">
                    <table id="moderator-list-ads" class="table is-striped is-hoverable is-fullwidth ">
                        <thead>
                        <tr>
                            <th>
                                @if(request()->input('sort') !== 'date')
                                    <a href="{{ route('moderator.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'date'])) }}">
                                        <span>Date</span>
                                    </a>
                                @elseif(request()->input('sort') === 'date' && request()->input('order') === 'desc')
                                    <a href="{{ route('moderator.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'date'])) }}">
                                        <i class="fas fa-arrow-down"></i>
                                        <span>Date</span>
                                    </a>
                                @else
                                    <a href="{{ route('moderator.show', array_diff_key(Request::all(), ['order'=>'', 'sort'=>''])) }}">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>Date</span>
                                    </a>
                                @endif
                            </th>
                            <th>
                                @if(request()->input('sort') !== 'id')
                                    <a href="{{ route('moderator.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'id'])) }}">
                                        <span>Référence</span>
                                    </a>
                                @elseif(request()->input('sort') === 'id' && request()->input('order') === 'asc')
                                    <a href="{{ route('moderator.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'id'])) }}">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>Référence</span>
                                    </a>
                                @else
                                    <a href="{{ route('moderator.show', array_diff_key(Request::all(), ['order'=>'', 'sort'=>''])) }}">
                                        <i class="fas fa-arrow-down"></i>
                                        <span>Référence</span>
                                    </a>
                                @endif
                            </th>
                            <th>
                                {{--                                @if(request()->input('sort') !== 'title')--}}
                                {{--                                    <a href="{{ route('moderator.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'title'])) }}">--}}
                                {{--                                        <span>Titre de l'annonce</span>--}}
                                {{--                                    </a>--}}
                                {{--                                @elseif(request()->input('sort') === 'title' && request()->input('order') === 'asc')--}}
                                {{--                                    <a href="{{ route('moderator.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'title'])) }}">--}}
                                {{--                                        <i class="fas fa-arrow-up"></i>--}}
                                {{--                                        <span>Titre de l'annonce</span>--}}
                                {{--                                    </a>--}}
                                {{--                                @else--}}
                                {{--                                    <a href="{{ route('moderator.show', array_diff_key(Request::all(), ['order'=>'', 'sort'=>''])) }}">--}}
                                {{--                                        <i class="fas fa-arrow-down"></i>--}}
                                {{--                                        <span>Titre de l'annonce</span>--}}
                                {{--                                    </a>--}}
                                {{--                                @endif--}}
                                <span>Titre de l'annonce</span>
                            </th>
                            <th>Type d'annonce</th>
                            {{--<th>Production(s)</th>--}}
                            <th>
                                @if(request()->input('sort') !== 'name')
                                    <a href="{{ route('moderator.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'name'])) }}">
                                        <span>Annonceur</span>
                                    </a>
                                @elseif(request()->input('sort') === 'name' && request()->input('order') === 'asc')
                                    <a href="{{ route('moderator.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'name'])) }}">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>Annonceur</span>
                                    </a>
                                @else
                                    <a href="{{ route('moderator.show', array_diff_key(Request::all(), ['order'=>'', 'sort'=>''])) }}">
                                        <i class="fas fa-arrow-down"></i>
                                        <span>Annonceur</span>
                                    </a>
                                @endif
                            </th>
                            <th>Modérateur</th>
                            {{--                            <th>Adresse mail</th>--}}
                            <th>Localisation</th>
                            <th>
                                @php
                                    $order = request()->input('sort') === 'ad_statuses.name' && request()->input('order') === 'asc' ? 'desc' : 'asc';
                                    $sort = request()->input('sort') !== 'ad_statuses.name' ? 'ad_statuses.name' : '';
                                    $icon = request()->input('sort') === 'ad_statuses.name' ? (request()->input('order') === 'asc' ? 'fa-arrow-up' : 'fa-arrow-down') : '';
                                @endphp

                                <a href="{{ route('moderator.show', array_merge(Request::all(), ['order'=>$order, 'sort'=>$sort])) }}">
                                    @if($icon)
                                        <i class="fas {{$icon}}"></i>
                                    @endif
                                    <span>Statut de l'annonce</span>
                                </a>
                            </th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php /** @var \App\Models\AttributionAd[] $attributionAds */ ?>
                        @foreach($attributionAds as $attributionAd)
                            @if($attributionAd->adStatus && $attributionAd->adStatus->id === \App\Models\AdStatus::PENDING_MODERATION_STATUS_ID and $attributionAd->userModerator && $attributionAd->userModerator->id === auth()->id())
                                <tr style="background-color: mistyrose">
                            @else
                                <tr>
                                    @endif

                                    <td>{{$attributionAd->updated_at->format('d/m/Y')}}</td>
                                    <td>
                                        <span class="tag">
                                          {{$attributionAd->ad->id}}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{route('ads.show', $attributionAd->ad->id)}}" class="bold"
                                           style="font-family: TitleFont, 'Source Sans Pro', sans-serif;">
                                            @if($attributionAd->ad->sub_ad->productionGenres->count())
                                                <b-tooltip position="is-top" multilined>
                                                    <p>{{ $attributionAd->ad->title }}</p>
                                                    <template v-slot:content>
                                                        {{ $attributionAd->ad->sub_ad->productionGenres->pluck('name')->join(', ') }}
                                                    </template>
                                                </b-tooltip>
                                            @else
                                                {{$attributionAd->ad->title}}
                                            @endif
                                        </a>
                                    </td>
                                    <td>{{$attributionAd->ad->ad_type_full_name}}</td>
                                    <td>
                                        @if(!empty($attributionAd->ad->userPp))
                                            <a href="{{route('user.show', $attributionAd->ad->userPp->id)}}">{{$attributionAd->ad->userPp->first_name}} {{$attributionAd->ad->userPp->name}}</a>
                                        @else
                                            [Porteur de projet supprimé]
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($attributionAd->userModerator))
                                            @if($attributionAd->user_moderator_id === auth()->id())
                                                <strong>{{$attributionAd->userModerator->first_name}} {{$attributionAd->userModerator->name}}</strong>

                                            @else
                                                {{$attributionAd->userModerator->first_name}} {{$attributionAd->userModerator->name}}
                                            @endif
                                        @else
                                            Modérateur non attribué
                                        @endif
                                    </td>
                                    {{--                                    <td>{{$attributionAd->ad->userPp->email ?? "[Supprimé]"}}</td>--}}
                                    <td>
                                        <b-tooltip position="is-top" multilined>
                                            <p><b>{{ $attributionAd->ad->main_department->name }}</b></p>
                                            <template v-slot:content>
                                                <div class="has-text-left">
                                                    @if(!empty($attributionAd->ad->main_department->territory))
                                                        <p><b>Territoire</b>
                                                            : {{$attributionAd->ad->main_department->territory->name}}
                                                        </p>
                                                    @endif
                                                    @if($attributionAd->ad->secondaryDepartmentsList->count() > 0)
                                                        <p><b>Départment(s) secondaire(s)</b> :
                                                            <br>{{$attributionAd->ad->secondaryDepartmentsList->join(',')}}
                                                        </p>
                                                    @endif
                                                    @if(! is_null($attributionAd->ad->citiesList))
                                                        <p><b>Communes(s)</b> : {{$attributionAd->ad->citiesList}}</p>
                                                    @endif
                                                </div>
                                            </template>
                                        </b-tooltip>
                                    </td>
                                    <td>
                                        @if(!is_null($attributionAd->adStatus))
                                            @php
                                                $statusId = $attributionAd->adStatus->id ?? null;
                                                $statusName = $attributionAd->adStatus->name ?? 'Non défini';
                                                $tooltip = AdStatus::TOOLTIPS[$statusId] ?? '';
                                                $statusClasses = [
                                                    \App\Models\AdStatus::APPROVE_ID => 'is-success',
                                                    \App\Models\AdStatus::PENDING_ID => 'is-warning',
                                                    \App\Models\AdStatus::REFUSE_ID => 'is-info',
                                                    \App\Models\AdStatus::PENDING_MODERATION_STATUS_ID => 'is-danger',
                                                ];
                                                $class = $statusClasses[$statusId] ?? '';
                                            @endphp
                                            <b-tooltip label="{{ $tooltip }}">
                                                <span class="tag {{ $class }} is-bottom">
                                                    {{ $statusName }}
                                                </span>
                                            </b-tooltip>
                                        @endif
                                        @if($attributionAd->pending_update_since)
                                            <b-tooltip label="L'annonce est restée en ligne mais a été modifiée par son auteur·e le {{ $attributionAd->pending_update_since->format('d/m/Y') }} : elle doit être revue.">
                                                <span class="tag is-warning is-bottom">
                                                    Modifiée à revoir
                                                </span>
                                            </b-tooltip>
                                        @endif
                                    </td>
                                    <td><a href="{{route('ads.show', $attributionAd->ad->id)}}">
                                            @if($attributionAd->pending_update_since)
                                                <i class="fas fa-ruler"></i>
                                                <span>Revoir l'annonce</span>
                                            @elseif($attributionAd->adStatus && $attributionAd->adStatus->id === \App\Models\AdStatus::PENDING_MODERATION_STATUS_ID and $attributionAd->userModerator && $attributionAd->userModerator->id === auth()->id())
                                                <i class="fas fa-ruler"></i>
                                                <span>Modérer l'annonce</span>
                                            @else
                                                <i class="fas fa-search"></i>
                                                <span>Voir</span>
                                            @endif
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="columns is-mobile is-centered">
                    <div class="column is-half ">
                        {{ $attributionAds->appends(Request::all())->links() }}
                    </div>
                </div>
            @endif
        </div>


    </div>

@endsection

@section('script')

    <script>

        let buttons = document.querySelectorAll('.form-research-buttons');
        let icons = document.querySelectorAll('.form-research-buttons-icons');

        buttons.forEach(function (btn) {
            btn.addEventListener('click', () => {
                buttons.forEach(function (b) {
                    b.classList.add('is-light');
                    b.firstElementChild.classList.add('is-hidden')
                });
                btn.classList.remove('is-light');
                btn.firstElementChild.classList.remove('is-hidden')
            });

        });

        let deleteButton = document.querySelector('#close-notification-moderator');
        deleteButton.addEventListener('click', function (e) {
            let notification = document.querySelector('#notification-moderator');
            notification.style.display = 'none';
        })
    </script>

@endsection
