<template>
    <div>
        <div class="text-area-counter-container">
                <textarea :id="name"
                          :name="name"
                          class="textarea"
                          :required="required"
                          :disabled="disabled"
                          :maxlength="maxLength"
                          :placeholder="placeholder"
                          v-on:input="onInput"
                >{{ text }}</textarea>
            <p class="text-area-counter-value is-size-7 is-pulled-right" :style="{color:color}">
                {{ text.length }}/ {{ maxLength}}
            </p>
        </div>

        <div v-if="vuelidate" v-show="vuelidate?.$error">
            <p class="help is-danger" v-show="!vuelidate?.minLength">
                Le contenu doit faire au minimum
                {{vuelidate.$params.minLength.min}} caractères.
            </p>
            <p class="help is-danger" v-if="!vuelidate?.maxLength">
                Vous avez dépassé la limite de
                {{vuelidate.$params.maxLength.max}} caractères.
            </p>
            <p class="help is-danger" v-show="typeof vuelidate.required !== 'undefined' && !vuelidate.required">
                Ce champ est requis.
            </p>
        </div>
    </div>
</template>

<style lang="scss">
    .text-area-counter-container {
        position: relative;

        .text-area-counter-value {
            opacity: 0.8;
        }
    }
</style>

<script>
    export default {
        props: {
            name: String,
            maxLength: Number,
            disabled: Boolean,
            required : false,
            value: {
                type: String,
                default: ''
            },
            vuelidate: {
                type: Object
            }
        },
        data() {
            return {
                text : this.value
            };
        },
        computed: {
            remainingCount() {
                return this.maxLength - this.value.length;
            },
            placeholder() {
                return 'Saisissez votre texte(maximum ' + this.maxLength + ' caractères)...';
            },
            color() {
                if (this.remainingCount <= 30) {
                    return 'orange';
                }

                return 'rgba(0,0,0,1);'
            }
        },
        methods: {
            onInput(event) {
                if(this.vuelidate) {
                    this.vuelidate.$touch();
                }
                const text = event.target.value;
                this.text = text;
                this.$emit("input", text);
            }
        }
    }
</script>
