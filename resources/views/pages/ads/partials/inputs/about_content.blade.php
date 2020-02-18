<?php
    if(!isset($title)) {
        $title = "Et si vous nous en disiez un peu plus sur vous ?";
    }
    if(!isset($tooltip)) {
        $tooltip = "Présentez-vous brièvement pour faciliter la mise en relation avec les personnes qui consulteront votre annonce.";
    }
?>
<div class="field">
    <label class="label is-inline-block has-tooltip-multiline has-tooltip-left"
           data-tooltip="{{$tooltip}}"
           for="about_content">
        {{$title}}*
        <i class="fas fa-info-circle has-text-info"></i>
    </label>

    <text-area-counter
            name="about_content"
            :max-length="1000"
            :disabled="isInputDisabled"
            ref="aboutContent"
            v-model="formInput.aboutContent"
            :vuelidate="$v.formInput.aboutContent">
    </text-area-counter>
</div>
