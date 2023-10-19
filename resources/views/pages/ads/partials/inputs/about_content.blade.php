<?php
if (!isset($title)) {
    $title = "Et si vous nous en disiez un peu plus sur vous ? (expérience agricole, expérience professionnelle)";
}
if (!isset($tooltip)) {
    if (empty($isSupportRequest)) {
        $tooltip = "Présentez vous brièvement pour faciliter la mise en relation avec les personnes intéressées par votre annonce";
    } else {
        $tooltip = "Présentez-vous en quelque lignes.";
    }
}
?>
<b-tooltip class="w-100"
           label="{{$tooltip}}.">
    <label class="label is-inline-block"
           for="about_content">
        {{$title}}{{ (empty($isSupportRequest) ?? true) ? '' : '*' }}
        <i class="fas fa-info-circle has-text-info"></i>
    </label>

    <text-area-counter
            name="about_content"
            :max-length="1000"
            :disabled="isInputDisabled"
            ref="aboutContent"
            v-model="formInput.aboutContent">
    </text-area-counter>
</b-tooltip>
