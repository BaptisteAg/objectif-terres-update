<template>
    <div>
        <textarea class="textarea"
                  :id = "textAreaId"
                  :disabled="disabled"
                  v-on:keyup="countdown()"
                  v-model="message"
                  :maxlength="maxCount"
                  placeholder="Saisissez votre texte(maximum 1000 caractères)..."
                 ></textarea>
        <p class="is-size-6 has-text-grey"> {{ remainingCount }}/ {{ maxLength}}</p>
        <p class="help is-danger" v-show="!$v.message.minLength">Le contenu doit faire au minimum
            {{$v.message.$params.minLength.min}} caractères.</p>
        <p class="help is-danger" v-if="!$v.message.maxLength">Vous avez dépassé la limite de
            {{$v.message.$params.maxLength.max}} caractères.</p>
        <p class="help is-danger" v-show="!$v.message.required">Ce champs est requis.</p>
    </div>

</template>

<script>

    import {required, minLength, between, maxLength, requiredIf} from 'vuelidate/lib/validators'
    import FormValidationMixin from "../pages/ads/components/mixins/form-new-ad-validation-mixin";

    export default {
        mixins: [FormValidationMixin],
        props: {
            maxLength: Number,
            disabled: Boolean,
            inputRequired : Boolean,
            inputId :'',
            errorInputId : '',
        },
        data() {
            return {
                maxCount: this.maxLength,
                message: '',
                hasError: false,
                remainingCount: this.maxLength,
                textAreaId : this.inputId,
                describedbyId : this.errorInputId,
            }
        },
        methods: {
            countdown: function () {
                this.remainingCount = this.maxCount - this.message.length;
                this.hasError = this.remainingCount < 0;
            },
        },
        validations : {
            message : {
                minLength: minLength(5),
                maxLength: maxLength(1000),
                required : requiredIf(function () {
                    return this.inputRequired
                })
            }
        }


    }
</script>
