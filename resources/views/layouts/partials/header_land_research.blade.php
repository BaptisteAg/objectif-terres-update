<div class="columns">
    <div class="column">
        <div>
            {!! Form::label('departments', 'Choisissez un département', ['class' => 'label']); !!}
            <multi-select
                :data="{{ json_encode($departments) }}"
                :multiple="true"
                name="research_location_department[]"
                selected-count-text="département(s) sélectionné(s)"
                placeholder="Choississez un/des département(s)">
            </multi-select>
        </div>
    </div>
    <div class="column">
        <div>
            {!! Form::label('departments', 'Choisissez une ville', ['class' => 'label']); !!}
{{--            <multi-select--}}
{{--                :data="test"--}}
{{--                :multiple="false"--}}
{{--                name="research_city"--}}
{{--                selected-count-text="ville sélectionnée"--}}
{{--                placeholder="Choississez un département">--}}
{{--            </multi-select>--}}
            <div class="section">
                <p class="label">Dans un rayon de </p>
                <vue-slider
                    name="land_seek[locationable_radius]"
                    :data="['0km','5km','10km','20km','50km']"
                ></vue-slider>
            </div>
        </div>
    </div>
    <div class="column">
        <div class="control">
            <label class="radio is-block" for="land">
                <input id="land" type="radio" name="offer_genre_ad" value="rental" checked v-model="adCategorySelected">
                location
            </label>
            <label class="radio is-block is-marginless" for="job">
                <input id="job" type="radio" name="offer_genre_ad" value="sale" v-model="adCategorySelected">
                vente
            </label>
        </div>
        <div class="section">
            <p class="label">Dans un rayon de </p>
            <vue-slider
                name="land_seek[locationable_radius]"
                :data="{{ json_encode($surfaces->pluck('name')) }}"
            ></vue-slider>
        </div>
    </div>
    <div class="column"></div>
    <div class="column"></div>
</div>
