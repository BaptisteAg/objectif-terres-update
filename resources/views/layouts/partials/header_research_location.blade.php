<div class="column">
    <div class="section">
        {!! Form::label('departments', 'Choisissez un département', ['class' => 'label']); !!}
        <multi-select
            :data="{{ json_encode($departments) }}"
            :multiple="true"
            name="departments_location_researches[]"
            selected-count-text="département(s) sélectionné(s)"
            placeholder="Choississez un/des département(s)">
        </multi-select>
    </div>
    <p class="has-text-centered">ou</p>
    <div class="section">
        {!! Form::label('cities', 'Choisissez une ville', ['class' => 'label']); !!}
        <ajax-multi-select
            :multiple="true"
            selected-count-text="ville sélectionnée"
            placeholder="Choississez un département"
            name-option-label="villes"
            src="/json/cities">
        </ajax-multi-select>
        <div class="section">
            <p class="label">Dans un rayon de </p>
            <vue-slider
                name="research_radius[locationable_radius]"
                :data="['0km','5km','10km','20km','50km']"
            ></vue-slider>
        </div>
    </div>
</div>
