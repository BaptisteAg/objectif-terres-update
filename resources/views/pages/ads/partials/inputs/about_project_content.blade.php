<?php
if (!isset($title)) {
    $title = "Et si vous nous en disiez un peu plus sur votre projet ?";
}
?>
<b-tooltip class="w-100 mb-6"
           label="{{$tooltip}}.">
    <label class="label is-inline-block"
           for="about_project_content">
        {{$title}}{{ ($required ?? true) ? ' *' : '' }}
        <i class="fas fa-info-circle has-text-info"></i>
    </label>

    <text-area-counter
            name="about_project_content"
            :max-length="1500"
            :disabled="isInputDisabled"
            ref="aboutProject"
            v-model="formInput.aboutProject"
            :vuelidate="$v.formInput.aboutProject">
    </text-area-counter>
</b-tooltip>
