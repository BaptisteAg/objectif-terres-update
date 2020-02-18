<?php
    if(!isset($title)) {
        $title = "Et si vous nous en disiez un peu plus sur votre projet ?";
    }
?>
<div class="field">
    <label class="label is-inline-block has-tooltip-multiline has-tooltip-left"
           data-tooltip="{{$tooltip}}"
           for="about_project_content">
        {{$title}}*
        <i class="fas fa-info-circle has-text-info"></i>
    </label>

    <text-area-counter
            name="about_project_content"
            :max-length="1000"
            :disabled="isInputDisabled"
            ref="aboutProject"
            v-model="formInput.aboutProject"
            :vuelidate="$v.formInput.aboutProject">
    </text-area-counter>
</div>
