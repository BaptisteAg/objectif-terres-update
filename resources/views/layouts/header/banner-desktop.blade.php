<div id="top-bar__1__desktop">
    <header-page id="header-page" inline-template
                 :old-search-values="{{json_encode(old())}}">
        {!! Form::open(['route' => 'researches.index', 'method' => 'get']) !!}
        <div class="container-custom bg-trame_champs_dark mb-5">
            <div class="columns is-mobile is-vcentered is-multiline">
                <div class="column is-full-tablet is-paddingless is-5-widescreen">
                    <div class="columns is-vcentered is-centered">
                        <div class="column is-2-desktop is-3-widescreen is-one-fifth-tablet">
                            <figure class="image is-square">
                                <a class=" logo logo_TdL"
                                   href="{{route ('home')}}">
                                    <img class="is-rounded"
                                         src="/images/logo/logo_TdL_cartouche_blanc-rouge_500.png"
                                         alt="objectif-terres-logo">
                                </a>
                            </figure>
                        </div>
                        <div class="column is-narrow-tablet is-narrow-widescreen">
                            <h1 class="title is-1 mb-0">
                                <a class="text_charcoal" href="{{route ('home')}}">
                                    Objectif Terres
                                </a>
                            </h1>

                            <h4 class=" text_success mt-5">Réalisez votre projet
                                agricole.</h4>
                            <p>Une initiative Terre de Liens</p>
                        </div>
                    </div>
                </div>
                <div class="column is-7-widescreen">
                    <div class="columns is-vcentered">
                        <div class="column has-text-right">
                            <div style="display:inline-block;&">
                                <p class="pr-10">Je</p>
                            </div>
                            <div class="select form-field">
                                <label for="select"></label>
                                {{ Form::select('offer_type',
                                    ['OfferAd' => 'Cherche ', 'SeekAd' => 'Propose'],
                                    null,
                                    ['v-model' => 'offerTypeSelected', "class"=> 'form-field'  ]
                                ) }}
                            </div>

                            <div class="select form-field">
                                <label for="select form-field"></label>
                                {{ Form::select('ad_category',
                                    ['land' => 'une terre ', 'job' => 'un emploi'],
                                    null,
                                    ['v-model' => 'adCategorySelected',
                                    "class"=> 'form-field'
                                   ]
                                ) }}
                            </div>

                            <div style="display:inline-block; padding-top: 2px;">
                                <p>ici : </p>
                            </div>
                            <div style="display:inline-block">
                                <multi-select
                                        :options="{{ $regionsWithAll }}"
                                        v-model="selectedRegions"
                                        :multiple="true"
                                        name="regions_location_researches_ids[]"
                                        selected-count-text="région(s) sélectionnée(s)"
                                        placeholder="Choississez une/des région(s)">
                                </multi-select>
                            </div>
                        </div>
                        <div class="column is-narrow-tablet has-text-centered"
                             style="padding-top: 38px;">
                            <button class="button basic primary">Rechercher</button>
                            <br>
                            <a class="has-text-left" href="#" @click="more_criteria()">Plus de critères</a>
                        </div>
                    </div>
                </div>
                {{--<div class="column is-3-desktop is-one-third-tablet has-text-centered pt-40">
                    <div style="display:inline-block; padding-top: 7px;">
                        <p class="pr-10">Je</p>
                    </div>
                    <div class="select form-field">
                        <label for="select"></label>
                        {{ Form::select('offer_type',
                            ['OfferAd' => 'Cherche ', 'SeekAd' => 'Propose'],
                            null,
                            ['v-model' => 'offerTypeSelected', "class"=> 'form-field'  ]
                        ) }}
                    </div>

                    <div class="select form-field">
                        <label for="select form-field"></label>
                        {{ Form::select('ad_category',
                            ['land' => 'une terre ', 'job' => 'un emploi'],
                            null,
                            ['v-model' => 'adCategorySelected',
                            "class"=> 'form-field'
                           ]
                        ) }}
                    </div>
                </div>
                <div class="column is-2-desktop is-one-third-tablet pt-40">
                    <div style="display:inline-block; padding-top: 2px;">
                        <p>ici : </p>
                    </div>
                    <div style="display:inline-block">
                        <multi-select
                                :options="{{ $regionsWithAll }}"
                                v-model="selectedRegions"
                                :multiple="true"
                                name="regions_location_researches_ids[]"
                                selected-count-text="région(s) sélectionnée(s)"
                                placeholder="Choississez une/des région(s)">
                        </multi-select>
                    </div>
                </div>
                <div class="column is-2-desktop is-one-third-tablet has-text-centered pt-40"
                     style="padding-top: 38px;">
                    {!! Form::submit('Rechercher', ['class' => ' button basic primary']) !!}
                    <br>
                    <a class="has-text-left" href="#" @click="more_criteria()">Plus de critères</a>
                </div>--}}

            </div>
        </div>
        <div v-show="isFormOpen" class="has-ba" style="display:none">
            <div class="container-custom bg-l-pearl"
                 v-if="adCategorySelected === 'job'">
                @include('layouts.partials.headerJobResearch')
            </div>
            <div class="container-custom bg-l-pearl"
                 v-if="adCategorySelected === 'land'">
                @include('layouts.partials.headerLandResearch')
            </div>
        </div>
        {!! Form::close() !!}
    </header-page>
</div>
