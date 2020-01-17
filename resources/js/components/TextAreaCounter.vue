<template>
    <div>
        <textarea :id="name"
                  :name="name"
                  class="textarea"
                  :disabled="disabled"
                  v-on:keyup="countdown()"
                  v-model="value"
                  :maxlength="maxCount"
                 ></textarea>
        <p class="is-size-6 has-text-grey"> {{ remainingCount }}/ {{ maxLength}}</p>
        <p class="help is-danger" v-show="!$v.value.minLength">Le contenu doit faire au minimum
            {{$v.value.$params.minLength.min}} caractères.</p>
        <p class="help is-danger" v-if="!$v.value.maxLength">Vous avez dépassé la limite de
            {{$v.value.$params.maxLength.max}} caractères.</p>
        <p class="help is-danger" v-show="!$v.value.required">Ce champs est requis.</p>
    </div>

</template>

<script>

    import {required, minLength, between, maxLength, requiredIf} from 'vuelidate/lib/validators'
    import FormValidationMixin from "../pages/ads/components/mixins/form-new-ad-validation-mixin";

    export default {
        mixins: [FormValidationMixin],
        props: {
            name: String,
            old: String,
            maxLength: Number,
            disabled: Boolean,
            inputRequired : Boolean
        },
        data() {
            return {
                maxCount: this.maxLength,
                value: this.old,
                remainingCount: this.maxLength,
            }
        },
        methods: {
            countdown: function () {
                this.remainingCount = this.maxCount - this.value.length;
            },
        },
        validations : {
            value : {
                minLength: minLength(5),
                maxLength: maxLength(1000),
                required : requiredIf(function () {
                    return this.inputRequired
                })
            }
        }


    }
</script>
