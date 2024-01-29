<?php
if (!isset($title)) {
    $title = "Et si vous nous en disiez un peu plus sur votre projet ?";
}
if (!isset($tooltip)) {
    $tooltip = "";
}
?>
@if(!empty($tooltip))
    <b-tooltip class="w-100"
               label="{{$tooltip}}">
        @endif
        <label class="label is-inline-block"
               for="about_project_content">
            {{$title}}{{ ($required ?? true) ? ' *' : '' }}
            @if(!empty($tooltip))
                <i class="fas fa-info-circle has-text-info"></i>
            @endif
        </label>

        <text-area-counter
                name="about_project_content"
                :max-length="1500"
                v-model="formInput.aboutProject"
                :vuelidate="$v.formInput.aboutProject">
        </text-area-counter>
        @if(!empty($tooltip))
    </b-tooltip>
@endif
