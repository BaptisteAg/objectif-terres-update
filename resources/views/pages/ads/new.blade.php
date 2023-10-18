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

                    {{--                    TODO : remove v-if after presentation --}}
                    <new-land-offer-ad inline-template
                                       v-if="false"
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
                        {{--                    TODO : remove v-if after presentation --}}
                        <new-job-seek-ad inline-template
                                         v-if="false"
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
                    @endif

                </form>
            </new-ad>
        </div>
    </section>

    @if(config('debugbar.enabled'))
        <pre>{{var_export($old, true)}}</pre>
    @endif
@endsection
