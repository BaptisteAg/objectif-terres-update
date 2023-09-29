@extends('default')


@if(!empty($isSupportRequest))
    @section('title', isset($old["id"]) ? 'Modifier votre accompagnement':'Demander un accompagnement')
@else
    @section('title',isset($old["id"]) ? 'Modifier votre annonce':'Publier une nouvelle annonce')
@endif

@section('main-content')
    <section class="container is-flex is-flex-direction-column is-align-items-center">
        <div id="vue-render" class="column is-four-fifths">
            @include('components.loader', ['text' => 'Chargement du formulaire'])
            <new-ad id="new-ad"
                    inline-template
                    :old-ad-type-selected="'{{$old['ad_type'] ?? ''}}'"
                    :is-support-request="{{empty($isSupportRequest)?'false':'true'}}"
                    style="display:none"
                    :style="{display:loading ? 'none': 'block'}">

                <form
                        method="post"
                        enctype="multipart/form-data"
                        @submit="submit"
                        :action="formAction"
                        ref="form">

                    {{ csrf_field() }}


                    <input type="hidden" name="is_support_request" value="{{empty($isSupportRequest)? 0 : 1}}">

                    @if(session('support-request.territory_id'))
                        <input type="hidden" name="support_request_territory_id"
                               value="{{ session('support-request.territory_id') }}">
                    @endif

                    @if(!empty($old["id"]))
                        <input type="hidden" name="id" value="{{ $old["id"] }}">
                    @endif

                    <ad-type-select v-model="adTypeSelected"
                                    name="ad_type"
                                    :is-support-request="{{empty($isSupportRequest)?'false':'true'}}">
                    </ad-type-select>

                    @if(empty($old["id"]))
                        @if(empty($isSupportRequest) && !empty($supportRequests) && count($supportRequests))
                            <section class="has-text-centered" v-if="!adTypeSelected">
                                Vous pouvez également remplir votre annonce à partir des champs de votre demande
                                d'accompagnement :<br>
                                <select class="select" v-model="createFromSupportRequest">
                                    <option></option>
                                    @foreach($supportRequests as $supportRequest)
                                        <option value="{{$supportRequest->id}}">{{$supportRequest->title}}</option>
                                    @endforeach
                                </select>
                            </section>
                        @endif
                        @if(!empty($isSupportRequest) && !empty($ads) && count($ads))
                            <section class="has-text-centered" v-if="!adTypeSelected">
                                Vous pouvez également remplir votre demande d'accompagnement à partir des champs de
                                votre annonce :<br>
                                <select class="select" v-model="createFromAd">
                                    <option></option>
                                    @foreach($ads as $ad)
                                        <option value="{{$ad->id}}">{{$ad->title}}</option>
                                    @endforeach
                                </select>
                            </section>
                        @endif
                    @endif

                    <new-land-seek-ad inline-template
                                      v-show="adTypeSelected === 'land_seek'"
                                      :is-input-disabled="adTypeSelected !== 'land_seek'"
                                      :old-values="{{json_encode(count($old) ? $old : new stdClass)}}"
                                      :is-support-request="{{empty($isSupportRequest)?'false':'true'}}"
                                      :text-content-territories="{{!empty($isSupportRequest) && isset($old["id"]) ? json_encode($pageContent): json_encode(new stdClass)}}"
                                      @input-enabled="setEnabledForm"
                                      @form-complete="submitProxy"
                                      @submit-save-button="submitProxy"
                                      @click-save-button="onSaveClick"
                                      @click-publish-button="onPublishClick"
                                      ref="land_seek">
                        @include('pages.ads.partials.landSeek.landSeekNewAd')
                    </new-land-seek-ad>


                </form>
            </new-ad>
        </div>
    </section>


    <section style="padding-top:50px;padding-bottom:100px;" v-if="false">
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
                    :old-ad-type-selected="'{{$old['ad_type'] ?? ''}}'"
                    :is-support-request="{{empty($isSupportRequest)?'false':'true'}}"
                    style="display:none"
                    :style="{display:loading ? 'none': 'block'}">

                <form
                        method="post"
                        enctype="multipart/form-data"
                        @submit="submit"
                        :action="formAction"
                        ref="form">

                    {{ csrf_field() }}


                    <input type="hidden" name="is_support_request" value="{{empty($isSupportRequest)? 0 : 1}}">

                    @if(session('support-request.territory_id'))
                        <input type="hidden" name="support_request_territory_id"
                               value="{{ session('support-request.territory_id') }}">
                    @endif

                    @if(!empty($old["id"]))
                        <input type="hidden" name="id" value="{{ $old["id"] }}">
                    @endif

                    <old-ad-type-select v-model="adTypeSelected"
                                        name="ad_type"
                                        :is-support-request="{{empty($isSupportRequest)?'false':'true'}}"
                                        :is-new="{{ empty($old["id"]) ? 'true' : 'false'}}">
                    </old-ad-type-select>

                    @if(empty($old["id"]))
                        @if(empty($isSupportRequest) && !empty($supportRequests) && count($supportRequests))
                            <section class="has-text-centered" v-if="!adTypeSelected">
                                Vous pouvez également remplir votre annonce à partir des champs de votre demande
                                d'accompagnement :<br>
                                <select class="select" v-model="createFromSupportRequest">
                                    <option></option>
                                    @foreach($supportRequests as $supportRequest)
                                        <option value="{{$supportRequest->id}}">{{$supportRequest->title}}</option>
                                    @endforeach
                                </select>
                            </section>
                        @endif
                        @if(!empty($isSupportRequest) && !empty($ads) && count($ads))
                            <section class="has-text-centered" v-if="!adTypeSelected">
                                Vous pouvez également remplir votre demande d'accompagnement à partir des champs de
                                votre annonce :<br>
                                <select class="select" v-model="createFromAd">
                                    <option></option>
                                    @foreach($ads as $ad)
                                        <option value="{{$ad->id}}">{{$ad->title}}</option>
                                    @endforeach
                                </select>
                            </section>
                        @endif
                    @endif


                    <new-land-seek-ad inline-template
                                      v-show="adTypeSelected === 'land_seek'"
                                      :is-input-disabled="adTypeSelected !== 'land_seek'"
                                      :old-values="{{json_encode(count($old) ? $old : new stdClass)}}"
                                      :is-support-request="{{empty($isSupportRequest)?'false':'true'}}"
                                      :text-content-territories="{{!empty($isSupportRequest) && isset($old["id"]) ? json_encode($pageContent): json_encode(new stdClass)}}"
                                      @input-enabled="setEnabledForm"
                                      @form-complete="submitProxy"
                                      @submit-save-button="submitProxy"
                                      @click-save-button="onSaveClick"
                                      @click-publish-button="onPublishClick"
                                      ref="land_seek">
                        @include('pages.ads.partials.landSeek.landSeekNewAdv1')
                    </new-land-seek-ad>

                    <new-land-offer-ad inline-template
                                       v-show="adTypeSelected === 'land_offer'"
                                       :is-input-disabled="adTypeSelected !== 'land_offer'"
                                       :old-values="{{json_encode(count($old) ? $old : new stdClass)}}"
                                       :is-support-request="{{empty($isSupportRequest)?'false':'true'}}"
                                       :text-content-territories="{{!empty($isSupportRequest) && isset($old["id"]) ? json_encode($pageContent):json_encode(new stdClass)}}"
                                       @input-enabled="setEnabledForm"
                                       @form-complete="submitProxy"
                                       @submit-save-button="submitProxy"
                                       @click-save-button="onSaveClick"
                                       @click-publish-button="onPublishClick"
                                       ref="land_offer">
                        @include('pages.ads.partials.landOffer.landOfferNewAd')
                    </new-land-offer-ad>

                    @if(empty($isSupportRequest))
                        <new-job-seek-ad inline-template
                                         v-show="adTypeSelected === 'job_seek'"
                                         :is-input-disabled="adTypeSelected !== 'job_seek'"
                                         :old-values="{{json_encode(count($old) ? $old : new stdClass)}}"
                                         @input-enabled="setEnabledForm"
                                         @form-complete="submitProxy"
                                         @submit-save-button="submitProxy"
                                         @click-save-button="onSaveClick"
                                         @click-publish-button="onPublishClick"
                                         ref="job_seek">
                            @include('pages.ads.partials.jobSeek.jobSeekNewAd')
                        </new-job-seek-ad>

                        <new-job-offer-ad inline-template
                                          v-show="adTypeSelected === 'job_offer'"
                                          :is-input-disabled="adTypeSelected !== 'job_offer'"
                                          :old-values="{{json_encode(count($old) ? $old : new stdClass)}}"
                                          @input-enabled="setEnabledForm"
                                          @form-complete="submitProxy"
                                          @submit-save-button="submitProxy"
                                          @click-save-button="onSaveClick"
                                          @click-publish-button="onPublishClick"
                                          ref="job_offer">
                            @include('pages.ads.partials.jobOffer.jobOfferNewAd')
                        </new-job-offer-ad>
                    @endif

                </form>
            </new-ad>
        </div>
    </section>

    @if(config('debugbar.enabled'))
        <pre>{{var_export($old, true)}}</pre>
    @endif
@endsection
