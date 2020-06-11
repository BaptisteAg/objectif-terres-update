@extends ('default')

@section ('title', 'Consulter la liste de vos recherches sauvegarder')

@section('main-content')
    <section class="section pt-0">
        <div class="container">
            <h1 class="page__title">Liste des recherches sauvegardées</h1>
            <br>
            @if(count($researches) <= 1)
                <h2 class="page__subtitle"> {{ count($researches) }} recherche sauvegardée</h2>
            @else
                <h2 class="page__subtitle"> {{ count($researches) }} recherches sauvegardées</h2>
            @endif

            @if($numberAlertActives == 0)

            @elseif($numberAlertActives == 1)
                <h2 class="page__subtitle"> {{ $numberAlertActives}} alerte active</h2>
            @else
                <h2 class="page__subtitle"> {{ $numberAlertActives}} alertes actives</h2>
            @endif
            <section class="section">
                @if($researches->count() >0)
                    @foreach ($researches as $research)
                        <div class="columns ">
                            <div class="column is-three-quarters ">
                                <a class="text_primary has-text-underline"
                                   href="{{route ('researches.index', [ltrim($research->url, '?')])}}">
                                    <h1 class="title text_primary">{{$research->name}} </h1></a>
                                <p><span class="has-text-grey-dark">Type d'annonces recherchés :</span>
                                    @if($research->ad_type === 'jobOffer')
                                        <span class="has-text-black">Offres d'emplois</span>
                                    @elseif($research->ad_type === 'jobSeekAd')
                                        <span class="has-text-black">Recherche d'emplois</span>
                                    @elseif($research->ad_type === 'landOfferAd')
                                        <span class="has-text-black">Offres de foncier</span>
                                    @elseif($research->ad_type === 'landSeekAd')
                                        <span class="has-text-black">Recherche de foncier</span>
                                    @endif
                                </p>
                                <p><span class="has-text-grey-dark">Localisations :</span>
                                   @if($research->regions->count() === 0 and $research->departments->count()=== 0 and $research->cities->count()=== 0)
                                       <span>Dans toute la France</span>
                                    @else
                                    <span class="has-text-black">{{ $research->regions->pluck('name')->implode(', ') }}</span>
                                    <span class="has-text-black">{{ $research->departments->pluck('name')->implode(', ') }}</span>
                                    <span class="has-text-black">{{ $research->cities->pluck('name')->implode(', ') }}</span>
                                       @endif
                                </p>
                                <p><span class="has-text-grey-dark">Recherche crée le :</span> <span
                                            class="has-text-black">{{ \Carbon\Carbon::parse($research->created_at)->format('d/m/Y')}}</span>
                                </p>

                                @isset($research->surface_min)
                                    <p><span class="has-text-grey-dark">Surface minimum : </span><span
                                                class="has-text-black">{{ $research->surface_min }}</span></p>
                                @endisset
                                @isset($research->surface_max)
                                    <p><span class="has-text-grey-dark">Surface maximum : </span><span
                                                class="has-text-black">{{ $research->surface_max }}</span></p>
                                @endisset
                                @isset($research->price_min)
                                    <p><span class="has-text-grey-dark">Prix minimum : </span><span
                                                class="has-text-black">{{ $research->price_min }}</span></p>
                                @endisset
                                @isset($research->price_max)
                                    <p><span class="has-text-grey-dark">Prix maximum : </span><span
                                                class="has-text-black">{{ $research->price_max }}</span></p>
                                @endisset
                                @if($research->has_pics === '1')
                                    <p><span class="has-text-grey-dark">Annonces avec photos </span></p>
                                @endif
                                @if($research->has_houses === '1')
                                    <p><span class="has-text-grey-dark">Uniquement des anonces avec habitation </span>
                                    </p>
                                @endif
                                @if($research->adStatuses->count()> 0)
                                    <p><span class="has-text-grey-dark">Statut(s) des annonces : </span><span
                                                class="has-text-black">{{ $research->adStatuses->pluck('name')->implode(', ') }}</span>
                                    </p>
                                @endif
                                @if($research->jobOfferTypes->count()> 0 )
                                    <p>
                                        <span class="has-text-grey-dark">Statut(s) des opportunités professionnels  : </span><span
                                                class="has-text-black">{{ $research->jobOfferTypes->pluck('name')->implode(', ') }}</span>
                                    </p>
                                @endif
                                @if($research->projectStatuses->count()> 0 )
                                    <p><span class="has-text-grey-dark">Statut(s) des projets  : </span><span
                                                class="has-text-black">{{ $research->jobOfferTypes->pluck('name')->implode(', ') }}</span>
                                    </p>
                                @endif
                                @if($research->offerGenres->count()> 0 )
                                    <p><span class="has-text-grey-dark">Type(s) d'offre(s)  : </span><span
                                                class="has-text-black">{{ $research->offerGenres->pluck('name')->implode(', ') }}</span>
                                    </p>
                                @endif
                                @if($research->bioCertifications->count()> 0 )
                                    <p><span class="has-text-grey-dark">Système(s) de production bio  : </span><span
                                                class="has-text-black">{{ $research->bioCertifications->pluck('name')->implode(', ') }}</span>
                                    </p>
                                @endif

                                @if($research->productionGenres->count()> 0 )
                                    <p>
                                        <span class="has-text-grey-dark">Type(s) de productions recherché(s)  : </span><span
                                                class="has-text-black">{{ $research->productionGenres->pluck('name')->implode(', ') }}</span>
                                    </p>
                                @endif
                            </div>
                            <div class="column ">
                                <div class="buttons">
                                    <a href="{{route ('researches.index', [ltrim($research->url, '?')])}}">
                                        <button class="button basic success ">
											<span class="icon is-small">
											 <i class="fas fa-eye"></i>
											</span>
                                            <span>Voir les annonces</span>
                                        </button>
                                    </a>
                                </div>
                                <div class="buttons">

                                    @if($research->has_alert === 0)
                                        {{Form::open(['route' => 'researches.notification', 'method' => 'get'])}}
                                        <input type="hidden" value="{{$research->id}}" name="research">
                                        <button type="submit" class="button basic warning"><span
                                                    class="icon is-small"><i
                                                        class="fas fa-bell"></i></span>
                                            <span>Créer une alerte</span>
                                        </button>
                                        {{Form::close()}}
                                    @else
                                        <a href="{{route ('researches.deleteAlert', $research->id)}}">
                                            <button class="button basic warning">
										<span class="icon is-small">
											<i class="fas fa-bell-slash"></i>
										</span>
                                                <span>Supprimer l'alerte</span>
                                            </button>
                                        </a>
                                    @endif
                                </div>
                                <a href="{{route ('researches.destroy', $research->id)}}">
                                    <div class="buttons">
                                        <button class="button basic danger">
												<span class="icon has-text-danger">
												 <i class="fas fa-ban has-text-white"></i>
												</span>
                                            <span>Supprimer la recherche</span>
                                        </button>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <hr class="navbar-divider">
                    @endforeach
                @else
                    <p>Aucune recherche sauvegardée</p>
                @endif
            </section>

            <section class="section">
                <pagination :per-page="10" :records="500" @paginate="myCallback"></pagination>
            </section>
            @include('components.section-orientation-terre-liens')
        </div>

    </section>

    @include('components.partnering')
    @include('components.support-terre-liens')
@endsection
