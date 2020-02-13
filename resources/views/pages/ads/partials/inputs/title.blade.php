<div class="field">
    <label class="label is-inline-block has-tooltip-multiline has-tooltip-right"
           for="title"
           data-tooltip="Le titre de l’annonce est primordial ! Il
                                    s’agit de votre carte de visite sur la
                                    plateforme. Un titre clair et bien
                                    formulé augmentera vos chances de
                                    contacts.">
        Titre de votre annonce*
        <i class="fas fa-info-circle has-text-info"></i>
    </label>

    {!! Form::text('title',
             null,
             ['class' => 'input',
              'placeholder'=> 'Saisissez votre titre...',
              ':disabled' => 'isInputDisabled',
              'v-model.trim' => 'formInput.title',
              'ref' => 'title',
              'aria-describedby'=>'titleError']) !!}
    <p class="help is-danger" id="titleError" v-if="$v.formInput.title.$error">Ce champ est requis.</p>
    <p class="help is-danger" v-show="!$v.formInput.title.minLength">Le titre de votre annonce doit faire au
        minimum
        @{{$v.formInput.title.$params.minLength.min}} caractères .</p>
</div>