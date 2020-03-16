<div class="columns ">
    @include('layouts.partials.headerResearchLocation')
    <div class="column ">
        <div class="field">
            <label class="checkbox">
                <input type="checkbox" name="offer_genres[]" value="rental">
                location
            </label>
            <label class="checkbox">
                <input type="checkbox" name="offer_genres[]" value="sale">
                vente
            </label>
        </div>
            <div class="field">
                <p class="label">Surface (ha)</p>
                <vue-slider
                    name="surfaces_research"
                    :data="{
                        0: '0 ha',
                        5: '5 ha',
                        10: '10 ha',
                        20: '20 ha',
                        50: '50 ha',
                        100 : '100 ha',
                    }"
                    :values="['0', '>100']"></vue-slider>
                <br>
            </div>
                <div v-if="adTypeSelected === 'OfferAd'" class="field">
                    {{ form::label('price_min', 'Prix minimum', ['class' => 'label']) }}
                    {{ form::number('price_min', '', ['min' => '0', 'pattern' => "([0-9]{1,3}).([0-9]{1,3})", 'class'=>'input']) }}
                    {{ form::label('price_max', 'Prix maximum', ['class' => 'label']) }}
                    {{ form::number('price_max', '', ['min' => '0', 'class' => 'input',]) }}
                </div>

    </div>

    <div v-if="adTypeSelected === 'OfferAd'" class="column">
        <div class="column">
            <div class="field">
                <label class="checkbox">
                    <input type="checkbox" name="has_pics" value="1">
                    Avec photos
                </label>
                <label class="checkbox">
                    <input type="checkbox" name="has_buildings" value="1">
                    Habitation
                </label>
            </div>

            <div class="field">
                {!! Form::label('production_genres', 'Choisissez des types de production', ['class' => 'label']); !!}
                <multi-select
                    :options="{{ json_encode($productionGenres) }}"
                    v-model="productionsSelected"
                    name="production_genres[]"
                    selected-count-text="production(s) sélectionné(s)"
                    placeholder="Choississez">
                </multi-select>
            </div>
            <div class="field">
                {!! Form::label('bio_certification', 'Choisissez des systèmes de production bio ou aucun', ['class' => 'label']); !!}
                <multi-select
                    :options="{{ json_encode($bioCertifications) }}"
                    :multiple="true"
                    v-model="bioProductionsSelected"
                    name="bio_certifications[]"
                    selected-count-text="production(s) bio sélectionné(s)"
                    placeholder="Choississez">
                </multi-select>
            </div>
        </div>
    </div>
</div>

