@extends ('default')

@section ('title', 'Mon espace modérateur')

@section('header')
    @include('components.moderator-tabs')
@endsection

@section('main-content')
    <div class="section pt-0">
        <h1 class="title is-2 has-text-link">Bienvenue sur votre espace modérateur <span
                    class="is-italic">{{ Auth::user()->first_name }} {{ Auth::user()->name }}</span></h1>

        @if(! auth()->user()->notifications->isEmpty())
            @if($numberOfAdsToModerate !== 0 || $numberOfUnreadMessages !==0)
                <div id="notification-moderator" class="notification has-background-info">
                    <button id="close-notification-moderator" class="delete"></button>
                    @if($numberOfAdsToModerate === 0)
                    @elseif($numberOfAdsToModerate >1)
                        <p class="has-text-white-ter">
                            <i class="far fa-bell has-text-white-ter"></i>
                            Vous avez<a style="text-decoration: none"
                                        href="{{route('moderator.show', ['citySelect=[]&radius_research=&ad_statuses[]=4'])}}">
                                <strong>{{$numberOfAdsToModerate}}
                                    annonces</strong></a> à modérer !</p>
                    @else
                        <p class="has-text-white-ter">
                            <i class="far fa-bell has-text-white-ter"></i>
                            Vous avez<a style="text-decoration: none"
                                        href="{{route('moderator.show', ['citySelect=[]&radius_research=&ad_statuses[]=4'])}}">
                                <strong>{{$numberOfAdsToModerate}} annonce</strong>
                            </a>à modérer !</p>
                    @endif

                    @if($numberOfUnreadMessages === 0)
                    @elseif($numberOfUnreadMessages > 1 )
                        <a style="text-decoration: none" href="{{route('threads.index')}}"><p class="has-text-white"><i
                                        class="fas fa-envelope "></i> Vous
                                avez <strong>{{$numberOfUnreadMessages}}
                                    nouveaux messages
                                    !</strong></p></a>

                    @else
                        <a style="text-decoration: none" href="{{route('threads.index')}}">
                            <p class="has-text-white"><i class="fas fa-envelope"></i> Vous avez
                                <strong>{{$numberOfUnreadMessages}} nouveau message !</strong>
                            </p>
                        </a>
                    @endif
                </div>
            @endif
        @endif
        {{Form::open(['route'=>'moderator.show', 'method'=>'get'])}}
        <div id="vue-form-moderator">
            @include('components.dashboard-filters')
        </div>
        {{Form::close()}}


        <div class="section">
            <h1 class="title is-1 has-text-centered">Liste des annonces attribuées</h1>
            @if (count($attributionAds) == 0)
                <p class="has-text-centered">Aucun résultat</p>
            @else
                <div class="table-container">
                    <table id="moderator-list-ads" class="table is-striped is-hoverable is-fullwidth ">
                        <thead>
                        <tr>
                            <th>
                                @if(request()->input('sort') !== 'date')
                                    <a href="{{ route('moderator.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'date'])) }}">
                                        <span>Date de soumission</span>
                                    </a>
                                @elseif(request()->input('sort') === 'date' && request()->input('order') === 'desc')
                                    <a href="{{ route('moderator.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'date'])) }}">
                                        <i class="fas fa-arrow-down"></i>
                                        <span>Date de soumission</span>
                                    </a>
                                @else
                                    <a href="{{ route('moderator.show', array_diff_key(Request::all(), ['order'=>'', 'sort'=>''])) }}">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>Date de soumission</span>
                                    </a>
                                @endif
                            </th>
                            <th>
                                @if(request()->input('sort') !== 'title')
                                    <a href="{{ route('moderator.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'title'])) }}">
                                        <span>Titre de l'annonce</span>
                                    </a>
                                @elseif(request()->input('sort') === 'title' && request()->input('order') === 'asc')
                                    <a href="{{ route('moderator.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'title'])) }}">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>Titre de l'annonce</span>
                                    </a>
                                @else
                                    <a href="{{ route('moderator.show', array_diff_key(Request::all(), ['order'=>'', 'sort'=>''])) }}">
                                        <i class="fas fa-arrow-down"></i>
                                        <span>Titre de l'annonce</span>
                                    </a>
                                @endif
                            </th>
                            <th>Type d'annonce</th>
                            <th>
                                @if(request()->input('sort') !== 'name')
                                    <a href="{{ route('moderator.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'name'])) }}">
                                        <span>Nom du porteur de projet</span>
                                    </a>
                                @elseif(request()->input('sort') === 'name' && request()->input('order') === 'asc')
                                    <a href="{{ route('moderator.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'name'])) }}">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>Nom du porteur de projet</span>
                                    </a>
                                @else
                                    <a href="{{ route('moderator.show', array_diff_key(Request::all(), ['order'=>'', 'sort'=>''])) }}">
                                        <i class="fas fa-arrow-down"></i>
                                        <span>Nom du porteur de projet</span>
                                    </a>
                                @endif
                            </th>
                            <th>Nom du modérateur</th>
                            <th>Adresse mail</th>
                            <th>Localisation(s)</th>
                            <th>
                                @if(request()->input('sort') !== 'ad_statuses.name')
                                    <a href="{{ route('moderator.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'ad_statuses.name'])) }}">
                                        <span>Statut de l'annonce</span>
                                    </a>
                                @elseif(request()->input('sort') === 'ad_statuses.name' && request()->input('order') === 'asc')
                                    <a href="{{ route('moderator.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'ad_statuses.name'])) }}">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>Statut de l'annonce</span>
                                    </a>
                                @else
                                    <a href="{{ route('moderator.show', array_diff_key(Request::all(), ['order'=>'', 'sort'=>''])) }}">
                                        <i class="fas fa-arrow-down"></i>
                                        <span>Statut de l'annonce</span>
                                    </a>
                                @endif
                            </th>
                            {{--							<th>--}}
                            {{--								@if(request()->input('sort') !== 'project_statuses.name')--}}
                            {{--									<a href="{{ route('moderator.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'project_statuses.name'])) }}">--}}
                            {{--										<span>Statut du projet</span>--}}
                            {{--									</a>--}}
                            {{--								@elseif(request()->input('sort') === 'project_statuses.name' && request()->input('order') === 'asc')--}}
                            {{--									<a href="{{ route('moderator.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'project_statuses.name'])) }}">--}}
                            {{--										<i class="fas fa-arrow-up"></i>--}}
                            {{--										<span>Statut du projet</span>--}}
                            {{--									</a>--}}
                            {{--								@else--}}
                            {{--									<a href="{{ route('moderator.show', array_merge(Request::all(), ['order'=>'', 'sort'=>''])) }}">--}}
                            {{--										<i class="fas fa-arrow-down"></i>--}}
                            {{--										<span>Statut du projet</span>--}}
                            {{--									</a>--}}
                            {{--								@endif--}}
                            {{--							</th>--}}
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($attributionAds as $attributionAd)
                            @if($attributionAd->adStatus->id === \App\Models\AdStatus::PENDING_MODERATION_STATUS_ID and $attributionAd->userModerator->id === auth()->id())
                                <tr style="background-color: mistyrose">
                            @else
                                <tr>
                                    @endif

                                    <td>{{$attributionAd->created_at->format('d/m/Y')}}</td>
                                    <td>
                                        <a href="{{route('ads.show', $attributionAd->ad->id)}}">{{$attributionAd->ad->title}}</a>
                                    </td>
                                    <td>{{$attributionAd->ad->ad_type_full_name}}</td>
                                    <td>
                                        <a href="{{route('user.show', $attributionAd->ad->userPp->id)}}">{{$attributionAd->ad->userPp->first_name}} {{$attributionAd->ad->userPp->name}}</a>
                                    </td>
                                    <td>
                                        @if(isset($attributionAd->userModerator))
                                            {{$attributionAd->userModerator->first_name}} {{$attributionAd->userModerator->name}}
                                        @else
                                            Modérateur non attribué
                                        @endif
                                    </td>
                                    <td>{{$attributionAd->ad->userPp->email}}</td>
                                    <td>
                                        @if(! is_null($attributionAd->ad->regionsList))
                                            <p>Region(s) : {{$attributionAd->ad->regionsList}}</p>
                                        @endif
                                        @if(! is_null($attributionAd->ad->departmentsList))
                                            <p>Département(s) : {{$attributionAd->ad->departmentsList}}</p>
                                        @endif
                                        @if(! is_null($attributionAd->ad->citiesList))
                                            <p>Communes(s) : {{$attributionAd->ad->citiesList}}</p>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!is_null($attributionAd->adStatus))
                                            @if($attributionAd->adStatus->id === \App\Models\AdStatus::APPROVE_ID)
                                                <span class="custom-tag success has-tooltip-bottom"
                                                      data-tooltip="{{\App\Models\AdStatus::TOOLTIPS[$attributionAd->adStatus->id]}}">{{$attributionAd->adStatus->name}}</span>
                                            @elseif($attributionAd->adStatus->id ===\App\Models\AdStatus::PENDING_ID)
                                                <span class="custom-tag primary has-tooltip-bottom"
                                                      data-tooltip="{{\App\Models\AdStatus::TOOLTIPS[$attributionAd->adStatus->id]}}">{{$attributionAd->adStatus->name}}</span>
                                            @elseif($attributionAd->adStatus->id === \App\Models\AdStatus::REFUSE_ID)
                                                <span class="custom-tag info  has-tooltip-bottom"
                                                      data-tooltip="{{\App\Models\AdStatus::TOOLTIPS[$attributionAd->adStatus->id]}}">{{$attributionAd->adStatus->name}}</span>
                                            @elseif($attributionAd->adStatus->id === \App\Models\AdStatus::PENDING_MODERATION_STATUS_ID)
                                                <span class="custom-tag danger has-tooltip-bottom"
                                                      data-tooltip="{{\App\Models\AdStatus::TOOLTIPS[$attributionAd->adStatus->id]}}">{{$attributionAd->adStatus->name}}</span>
                                            @else
                                                <span class="custom-tag has-tooltip-bottom"
                                                      data-tooltip="{{\App\Models\AdStatus::TOOLTIPS[$attributionAd->adStatus->id]}}">{{$attributionAd->adStatus->name}}</span>
                                            @endif
                                        @else
                                            Non définis
                                        @endif
                                    </td>
                                    <td><a href="{{route('ads.show', $attributionAd->ad->id)}}"><span>
                                            @if($attributionAd->adStatus->id === \App\Models\AdStatus::PENDING_MODERATION_STATUS_ID and $attributionAd->userModerator->id === auth()->id())
                                                    <i class="fas fa-ruler"></i>
                                                    <span>Modérer l'annonce</span>
                                                @else
                                                    <i class="fas fa-search"></i></span>
                                            <span>Voir le détail</span>
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
        const vueModerator = new Vue({
            el: '#vue-form-moderator',
            name: 'content'
        });

        let buttons = document.querySelectorAll('.form-research-buttons');
        let icons = document.querySelectorAll('.form-research-buttons-icons')

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
