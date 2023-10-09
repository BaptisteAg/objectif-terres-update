<b-tooltip class="w-100 mb-6"
           label="Conseil : faites apparaître les points forts de votre projet.">
    <label class="label is-inline-block"
           for="title"
           >
        @if($isSupportRequest)
            Titre du projet *
        @else
            Titre de l'annonce *
            <i class="fas fa-info-circle has-text-info"></i>
        @endif
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
</b-tooltip>
