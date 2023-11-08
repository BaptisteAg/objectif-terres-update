<section class="field mb-6">
    <b-tooltip class="w-100"
               label="Il est nécessaire que nous ayons les informations sur votre bien, à l'échelle de la commune mais l'annonce ne l'affichera pas si vous souhaitez rester plus général sur l'emplacement du foncier. Seul le département apparaitra.">
        <div class="label">
            {!! Form::label($name, 'Confidentialité'); !!}
            <i class="fas fa-info-circle has-text-info"></i>
        </div>
        <b-checkbox true-value="0" false-value="1" native-value="" v-model="{{ $vModel }}"
                    class="is-size-6">
            Je ne souhaite pas que la localisation soit publique.
        </b-checkbox>
        <input type="hidden" name="{{$name}}" :value="{{ $vModel }}">
    </b-tooltip>
</section>
