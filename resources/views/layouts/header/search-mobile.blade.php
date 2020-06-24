<section id="above-top-bar-mobile">
    <div class="columns is-mobile is-centered mt-10 mt-sm-30">
        <div class="column is-half">
            <p class="menu-search__title has-text-centered">Recherche</p>
        </div>
    </div>
    <header-page id="header-page" inline-template
                 :old-search-values="{{json_encode(old())}}">
        {!! Form::open(['route' => 'researches.index', 'method' => 'get']) !!}

        <div class="columns is-mobile is-centred is-multiline">
            <div class="column is-full-mobile has-text-centered pt-40">
                {{--											<div style="display:inline-block; padding-top: 7px;">--}}
                {{--												<p class="pr-10 text_white">Je</p>--}}
                {{--											</div>--}}
                <div class="select form-field">
                    <label for="select"></label>
                    {{ Form::select('offer_type',
                        ['OfferAd' => 'Je cherche ', 'SeekAd' => 'Je propose'],
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
            <div class="column is-full-mobile  has-text-centered">
                <div style="display:inline-block; padding-top: 2px;">
                    <p class="text_white">ici : </p>
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
            <div class="column is-half is-offset-3-mobile">
                <div class="has-text-centered">
                    {!! Form::submit('Rechercher', ['class' => ' button basic primary']) !!}
                    <br>
                    <a class="is-block mt-5" href="#" @click="more_criteria()"
                       onclick="extendHeaderMobileContainer()">Plus de critères</a>
                </div>

            </div>
        </div>

        <div v-show="isFormOpen" class="has-ba mb-15" style="display : none">
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
</section>

