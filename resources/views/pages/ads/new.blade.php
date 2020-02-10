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
                        peu plus…<br>
                        Les champ marqués d'un astérisque (*) sont obligatoires
                    </p>
                </div>
                <div class="section">
                    <div id="vue-render">

                        <new-ad id="new-ad"
                                inline-template
                                :old-ad-type-selected="'{{old('ad_type')}}'">

                            <form
                                method="post"
                                enctype="multipart/form-data"
                                @submit="submit"
                                ref="form">

                                {{ csrf_field() }}

                                <ad-type-select
                                    v-model="adTypeSelected"
                                    name="ad_type">
                                </ad-type-select>

                                <new-land-seek-ad inline-template
                                                  v-show="adTypeSelected === 'land_seek'"
                                                  :is-input-disabled="adTypeSelected !== 'land_seek'"
                                                  :old-values="{{json_encode(old('land_seek', new stdClass))}}"
                                                  @input-enabled="setEnabledForm"
                                                  @form-complete="onFormComplete">
                                    @include('pages.ads.partials.landSeek.landSeekNewAd')
                                </new-land-seek-ad>

<!--                                <new-land-offer-ad inline-template
                                                   v-show="adTypeSelected === 'land_offer'"
                                                   :is-input-disabled="adTypeSelected !== 'land_offer'"
                                                   :old-values="{{json_encode(old('land_offer', new stdClass))}}"
                                                   @input-enabled="setEnabledForm">
                                    @include('pages.ads.partials.landOffer.landOfferNewAd')
                                </new-land-offer-ad>

                                <new-job-offer-ad inline-template
                                                  v-show="adTypeSelected === 'job_offer'"
                                                  :is-input-disabled="adTypeSelected !== 'job_offer'"
                                                  :old-values="{{json_encode(old('job_offer', new stdClass))}}"
                                                  @input-enabled="setEnabledForm">
                                    @include('pages.ads.partials.jobAd.jobAdNewAd')
                                </new-job-offer-ad>-->
                            </form>
                        </new-ad>
                    </div>
                    <div class="column"></div>
                </div>
            </div>
            <div class="column"></div>
        </div>
        @include('components.partnering')
        @include('components.supportTerreLiens')
    </section>
@endsection

@section('script')
    <script>
        const vuePage = new Vue({
            el: '#vue-render',
            name: 'content'
        });
    </script>
@endsection

