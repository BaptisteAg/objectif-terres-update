<section class="field mb-6">
    <div class="label">
        {!! Form::label($name, 'Confidentialité'); !!}
        <i class="fas fa-info-circle has-text-info"></i>
    </div>
    <b-checkbox true-value="0" false-value="1" native-value="" v-model="{{ $vModel }}"
                class="is-size-6">
        Je ne souhaite pas que le code postal de mon bien soit rendu public. Dans ce cas, mon annonce sera
        référencée au niveau du département.
    </b-checkbox>
    <input type="hidden" name="{{$name}}" :value="{{ $vModel }} || 1">
</section>
