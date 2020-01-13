@extends('default')

@section('title', 'Déposer une annonce')

@section('main-content')
    <section class="section is-medium">
        <div class="columns">
            <div class="column"></div>
            <div class="column is-half">
                <div>
                    <h2 class="title is-1">Publiez votre annonce</h2>
                    <p>Vous avez un projet agricole ? Vous avez besoin d’aide ou d’un suivi sur mesure ?
                        Vous avez une idée de projet mais il n’est pas encore finalisé ? Eget risus varius
                        blandit sit amet non magna. Sed posuere consectetur est at lobortis.</p>
                </div>
                <br>
                <div>
                    <p class="has-text-grey">Pour nous permettre de vous valider votre annonce, veuillez nous en dire en peu plus…</p>
                </div>
                <div class="section">
                    <div id="vue-render">
                        <new-ad inline-template
                                :old-ad-type-selected="'{{old('ad_type')}}'">
                            {!! Form::open(['files' => true]) !!}
                            <div class="field">
                                {!! Form::label('ad_type', 'Type d\'annonce', ['class' => 'label']); !!}
                                <div class="select">
                                    {{ Form::select('ad_type',
                                        ['land_seek' => 'Recherche de foncier',
                                         'land_offer'=>'Offre de foncier',
                                         'job_offer'=>'Opportunité professionnelle'],
                                         null,
                                         ['v-model'=>'adTypeSelected',
                                          'placeholder' => 'Choisir un type d\'annonce...',
                                          'required']) }}
                                </div>
                            </div>

                            <new-land-seek-ad inline-template
                                              v-if="adTypeSelected === 'land_seek'"
                                              :is-input-disabled="adTypeSelected !== 'land_seek'"
                                              :old-values="{{json_encode(old('land_seek', new stdClass))}}">
                                @include('pages.ads.partials.land_seek_new_ad')
                            </new-land-seek-ad>

                            <new-land-offer-ad inline-template
                                               v-if="adTypeSelected === 'land_offer'"
                                               :is-input-disabled="adTypeSelected !== 'land_offer'"
                                               :old-values="{{json_encode(old('land_offer', new stdClass))}}">
                                @include('pages.ads.partials.land_offer_new_ad')
                            </new-land-offer-ad>

                            <new-job-offer-ad inline-template
                                              v-if="adTypeSelected === 'job_offer'"
                                              :is-input-disabled="adTypeSelected !== 'job_offer'"
                                              :old-values="{{json_encode(old('job_offer', new stdClass))}}">
                                @include('pages.ads.partials.job_ad_new_ad')
                            </new-job-offer-ad>

                            <div class="field is-grouped" v-show="adTypeSelected != ''">
                                <div class="control">
                                    {!! Form::submit('Envoyer',['class'=>'button is-link']) !!}
                                </div>
                                <div class="control">
                                    <button class="button is-light">Sauvergder</button>
                                </div>
                                <div class="control">
                                    <button class="button is-link is-light">Annuler</button>
                                </div>
                            </div>
                        </new-ad>
                    </div>
                    <div class="column"></div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="column"></div>
        </div>
        @include('components.partnering')
        @include('components.support_terre_liens')
    </section>
@endsection

@section('script')
    <script>
        const vuePage = new Vue({
            el: '#vue-render'
        });

        window.addEventListener("beforeunload", function (e) {
            var confirmationMessage = "\o/";

            e.returnValue = confirmationMessage;     // Gecko, Trident, Chrome 34+
            return confirmationMessage;              // Gecko, WebKit, Chrome <34
        });
    </script>


@endsection

