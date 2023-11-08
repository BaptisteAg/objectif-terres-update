<section class="mb-6 is-flex gap-x-5 field is-flex-wrap-wrap" ref="{{$ref}}">
    {!! Form::label($name, $label, ['class' => 'label w-100']) !!}
    <div>
        {!! Form::radio($name, '1', null , array_filter(['id' => $name . '_1', 'v-model' => $vModel, ':vuelidate' => $vuelidate]) ) !!}
        {!! Form::label($name . '_1',  'Oui' ) !!}
    </div>
    <div>
        {!! Form::radio($name, '0', null , array_filter(['id' => $name . '_0', 'v-model' => $vModel, ':vuelidate' => $vuelidate])) !!}
        {!! Form::label($name . '_0',  'Non' ) !!}
    </div>
    @if(isset($maybe) && $maybe)
        <div>
            {!! Form::radio($name, '-1', null , array_filter(['id' => $name . '_maybe', 'v-model' => $vModel, ':vuelidate' => $vuelidate])) !!}
            {!! Form::label($name . '_maybe',  'Peut-être' ) !!}
        </div>
    @endif

    <p class="help is-danger w-100"
       v-if="{{ $vuelidate }}?.$error">
        Ce champ est requis.
    </p>
</section>
