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
                    <p class="has-text-grey">Pour nous permettre de vous valider votre annonce, veuillez nous en dire en
                        peu plus…</p>
                </div>
                <div class="section">

                    <div id="form-new-ad">
                        {!! Form::open(['files' => true]) !!}
                        <div class="field">
                            {!! Form::label('ad_type', 'Type d\'annonce', ['class' => 'label']); !!}
                            <div class="select">
                                {{ Form::select('ad_type',
									['land_seek' => 'Recherche de foncier',
									 'land_offer'=>'Offre de foncier',
									 'job_offer'=>'Opportunité professionnelle'],
									 old('ad_type'),
									 ['v-model'=>'ad_type_selected',
									  'placeholder' => 'Choisir un type d\'annonce...',
									  'required']) }}
                            </div>
                        </div>
                        <div v-show="ad_type_selected === 'land_seek'">
                            @include('pages.ads.land_seek_new_ad')
                        </div>
                        <div v-show="ad_type_selected === 'land_offer'">
                            @include('pages.ads.land_offer_new_ad')
                        </div>
                        <div v-show="ad_type_selected === 'job_offer'">
                            @include('pages.ads.job_ad_new_add')
                        </div>
                        <div class="field is-grouped" v-show="ad_type_selected != ''">
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
        window.addEventListener("beforeunload", function (e) {
            var confirmationMessage = "\o/";

            e.returnValue = confirmationMessage;     // Gecko, Trident, Chrome 34+
            return confirmationMessage;              // Gecko, WebKit, Chrome <34
        });
    </script>

@endsection

