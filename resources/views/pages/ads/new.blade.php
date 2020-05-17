@extends('default')

@if(!empty($isSupportRequest))
    @section('title', 'Demander un accompagnement')
@else
    @section('title', 'Publier une nouvelle annonce')
@endif

@section('main-content')
    <section style="padding-top:50px;padding-bottom:100px;">
{{--        <div class="columns">--}}
{{--            <div class="column"></div>--}}
{{--            <div class="column is-half">--}}
{{--                <div>--}}
{{--                    <h2 class="title is-1">Publiez votre annonce</h2>--}}
{{--                    <p>Vous avez un projet agricole ? Vous avez besoin d’aide ou d’un suivi sur mesure ?--}}
{{--                        Vous avez une idée de projet mais il n’est pas encore finalisé ? Eget risus varius--}}
{{--                        blandit sit amet non magna. Sed posuere consectetur est at lobortis.</p>--}}
{{--                </div>--}}
{{--                <br>--}}
{{--                <div>--}}
{{--                    <p class="has-text-grey">Pour nous permettre de vous valider votre annonce, veuillez nous en dire en--}}
{{--                        peu plus…<br>--}}
{{--                        Les champ marqués d'un astérisque (*) sont obligatoires--}}
{{--                    </p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="column"></div>--}}
{{--        </div>--}}
        <div id="vue-render">
            @include('components.loader', ['text' => 'Chargement du formulaire'])

            <new-ad id="new-ad"
                    inline-template
                    :old-ad-type-selected="'{{old('ad_type')}}'"
                    :is-support-request="{{empty($isSupportRequest)?'false':'true'}}"
                    style="display:none"
                    :style="{display:loading ? 'none': 'block'}">

                <form
                    method="post"
                    enctype="multipart/form-data"
                    @submit="submit"
                    ref="form">

                    {{ csrf_field() }}

                    @if(!empty($isSupportRequest))
                        <input type="hidden" name="is_support_request" value="1">
                        <input type="hidden" name="support_request_text" value="{{ session('support_request.text') }}">
                    @endif

                    <ad-type-select v-model="adTypeSelected"
                                    name="ad_type"
                                    :is-support-request="{{empty($isSupportRequest)?'false':'true'}}">
                    </ad-type-select>

                    <new-land-seek-ad inline-template
                                      v-show="adTypeSelected === 'land_seek'"
                                      :is-input-disabled="adTypeSelected !== 'land_seek'"
                                      :old-values="{{json_encode(count(old()) ? old() : new stdClass)}}"
                                      :is-support-request="{{empty($isSupportRequest)?'false':'true'}}"
                                      @input-enabled="setEnabledForm"
                                      @form-complete="onFormComplete"
                                      ref="land_seek">
                        @include('pages.ads.partials.landSeek.landSeekNewAd')
                    </new-land-seek-ad>

                    <new-land-offer-ad inline-template
                                       v-show="adTypeSelected === 'land_offer'"
                                       :is-input-disabled="adTypeSelected !== 'land_offer'"
                                       :old-values="{{json_encode(count(old()) ? old() : new stdClass)}}"
                                       :is-support-request="{{empty($isSupportRequest)?'false':'true'}}"
                                       @input-enabled="setEnabledForm"
                                       @form-complete="onFormComplete"
                                       ref="land_offer">
                        @include('pages.ads.partials.landOffer.landOfferNewAd')
                    </new-land-offer-ad>

                    @if(empty($isSupportRequest))
                        <new-job-seek-ad inline-template
                                          v-show="adTypeSelected === 'job_seek'"
                                          :is-input-disabled="adTypeSelected !== 'job_seek'"
                                          :old-values="{{json_encode(count(old()) ? old() : new stdClass)}}"
                                          @input-enabled="setEnabledForm"
                                          @form-complete="onFormComplete"
                                          ref="job_seek">
                            @include('pages.ads.partials.jobSeek.jobSeekNewAd')
                        </new-job-seek-ad>

                        <new-job-offer-ad inline-template
                                          v-show="adTypeSelected === 'job_offer'"
                                          :is-input-disabled="adTypeSelected !== 'job_offer'"
                                          :old-values="{{json_encode(count(old()) ? old() : new stdClass)}}"
                                          @input-enabled="setEnabledForm"
                                          @form-complete="onFormComplete"
                                          ref="job_offer">
                            @include('pages.ads.partials.jobOffer.jobOfferNewAd')
                        </new-job-offer-ad>
                    @endif


                </form>
            </new-ad>
        </div>
    </section>
@endsection

@section('script')
    <script>
        const vuePage = new Vue({
            el: '#vue-render',
            name: 'content',
            data() {
                return {
                    loading: false
                }
            }
        });
    </script>
@endsection

