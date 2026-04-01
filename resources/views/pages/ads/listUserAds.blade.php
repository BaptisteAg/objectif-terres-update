@extends ('default')

@section ('title', 'Consulter la liste de vos annonces')

@section('main-content')
    <section class="container mt-6" id="user-ads-list">
        <h1 class="title mb-3 mx-3-mobile">Liste de mes annonces</h1>
        <p class="mb-6 mx-3-mobile">{{ count($ads) }} annonce{{ count($ads) > 1 ? 's' : '' }}
            créée{{ count($ads) > 1 ? 's' : '' }}</p>
        @foreach($ads as $ad)
            <div class="unset-color columns is-flex fd-c-mobile">
                <div class="column is-two-fifths">
                    <figure class="image is-3by2">
                        @if($ad->hasImages && $ad->images[0]?->path)
                            <img class="objT-border vignette__image"
                                 src="{{app('url')->assetFrom('https://objectif-terres.org', $ad->images[0]->path)}}"
                                 alt="{{$ad->images[0]->name}}">
                        @else
                            <img class="objT-border vignette__image"
                                 src="https://images.unsplash.com/photo-1557234195-bd9f290f0e4d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                                 alt="placeholder">
                        @endif
                    </figure>
                </div>
                <div class="column is-flex is-flex-direction-column">
                    @if(isset($ad->attributionAd->adStatus))
                        @if($ad->attributionAd->adStatus->id === \App\Models\AdStatus::APPROVE_ID)
                            <span class="tile__date">Publié {{$ad->published_on_diff}}</span>
                        @else
                            <span class="tile__date">Crée  {{$ad->created_at_diff}}</span>
                        @endif
                    @else
                        <span class="tile__date">Crée  {{$ad->created_at_diff}}</span>
                    @endif
                    @if(isset($ad->is_partner) && $ad->is_partner === 1 )
                        <ul class="custom-tags">
                            <li class="custom-tag warning">Annonce certifiée</li>
                        </ul>
                    @endif
                    <h3 class="title is-4">{{$ad->title ?? "Titre de l'annonce non renseigné"}}</h3>
                    <p class="mb-4">
                        @if(isset($ad->about_project_content))
                            {{ Illuminate\Support\Str::limit($ad->about_project_content, 200)}}
                        @else
                            Pas de description renseignée pour cette annonce
                        @endif
                    </p>
                    @if(count($ad->threads) === 0)
                        <b-message>
                            Vous n'avez pas reçu de messages concernant
                            cette annonce
                        </b-message>
                    @endif
                    @if(count($ad->threads) === 1 )
                        <b-message>Vous avez
                            <a class="text_charcoal has-text-weight-bold"
                               href="{{route("threads.index")}}"> {{count($ad->threads)}}
                                fil de discussion
                            </a> concernant cette annonce !
                        </b-message>
                    @elseif(count($ad->threads) > 1)
                        <b-message>Vous avez <a class="has-text-weight-bold"
                                                href="{{route("threads.index")}}"> {{count($ad->threads)}}
                                fils de discussion
                            </a>
                            concernant cette annonce !
                        </b-message>
                    @endif
                    @if(!$ad->attributionAd || $ad->is_draft === 1)
                        <b-message type="is-warning">
                            Votre annonce est en mode brouillon, elle n'a pas été encore soumise à
                            modération !
                        </b-message>
                    @else
                        @if(isset($ad->attributionAd->adStatus))
                            @if($ad->attributionAd->adStatus->id === \App\Models\AdStatus::APPROVE_ID)
                                <b-message type="is-success">
                                    Votre annonce a été validée et est en ligne depuis
                                    le {{$ad->published_on}} !
                                </b-message>
                            @elseif($ad->attributionAd->adStatus->id === \App\Models\AdStatus::PENDING_ID)
                                <b-message type="is-warning">
                                    Votre annonce nécessite quelques modifications,
                                    <a href="{{route('threads.index')}}">consulter votre
                                        messagerie
                                    </a>
                                    pour
                                    plus d'informations !
                                </b-message>
                            @elseif($ad->attributionAd->adStatus->id === \App\Models\AdStatus::REFUSE_ID)
                                <b-message type="is-danger">
                                    Votre annonce a été réfusée,
                                    <a href="{{route('threads.index')}}">consulter
                                        votre
                                        messagerie
                                    </a>
                                    pour plus d'informations !
                                </b-message>
                            @elseif($ad->attributionAd->adStatus->id === \App\Models\AdStatus::ARCHIVED_ID)
                                <b-message>
                                    Votre annonce a été archivée !
                                </b-message>
                            @else
                                <b-message>
                                    Votre annonce n'as pas été encore approuvée et publiée !
                                </b-message>
                            @endif
                        @endif
                    @endif

                    <div class="buttons has-addons is-right">
                        @if($ad->is_draft === 0 && !isset($ad->attributionAd))
                            <b-button
                                    href="{{ route('ads.request-publishing', ["id" => $ad->id]) }}"
                                    tag="a" icon-left="check"
                                    rounded>Soumettre
                            </b-button>
                        @endif
                        <b-button
                                href="{{route("ads.show", $ad->id)}}"
                                tag="a" icon-left="eye" rounded>Voir
                        </b-button>
                        <b-button tag="a"
                                  href="{{route("ads.edit", $ad->id)}}" icon-left="pencil"
                                  rounded>
                            Modifier
                        </b-button>
                        @if(!$ad->isArchived())
                            <b-button
                                      @click="openSurveyModal({{$ad->id}}, 'archive')"
                                      icon-left="archive-arrow-down"
                                      rounded>
                                Archiver
                            </b-button>
                        @else
                            <b-button
                                      href="{{route('ads.republish', $ad->id)}}"
                                      tag="a"
                                      icon-left="publish"
                                      rounded>
                                Republier
                            </b-button>
                        @endif
                        <b-button
                                  @click="openSurveyModal({{$ad->id}}, 'delete')"
                                  icon-left="delete"
                                  rounded>
                            Supprimer
                        </b-button>
                    </div>
                </div>
            </div>
        @endforeach
        <section class="section">
            <pagination :per-page="10" :records="500"></pagination>
        </section>

        <survey-modal
            v-if="surveyModalOpen"
            :ad="selectedAd"
            :action="surveyAction"
            @close="closeSurveyModal"
        ></survey-modal>
    </section>
@endsection

@section('script')
    <script>
        // Initialize survey modal data for this page
        window.app.surveyModalOpen = false;
        window.app.selectedAd = null;
        window.app.surveyAction = null;
        window.app.ads = @json($ads);

        window.app.openSurveyModal = function(adId, action) {
            this.selectedAd = this.ads.find(ad => ad.id === adId);
            this.surveyAction = action;
            this.surveyModalOpen = true;
        };

        window.app.closeSurveyModal = function() {
            this.surveyModalOpen = false;
            this.selectedAd = null;
            this.surveyAction = null;
        };
    </script>
@endsection
