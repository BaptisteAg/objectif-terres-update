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
            <multi-select
                :data="{{ json_encode($cities) }}"
                :multiple="false"
                name="research_city"
                selected-count-text="ville sélectionnée"
                placeholder="Choississez un département">
            </multi-select>
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
        {{ Form::label('jobStatus', 'Choisissez un statut', ['class' => 'label']) }}
        <div class="select">
            {{ Form::select('jobStatus', $jobStatuses->pluck('name'), null, ['placeholder' => 'statut de job']) }}
        </div>
    </div>
</div>

