<template>
    <div>
        <div class="text-area-counter-container">
                <textarea :id="name"
                          :name="name"
                          class="textarea"
                          :disabled="disabled"
                          :maxlength="maxLength"
                          :placeholder="placeholder"
                          v-bind:value="value"
                          v-on:input="onInput"
                >{{ value }}</textarea>
            <p class="text-area-counter-value is-size-7" :style="{color:color}">
                {{ value.length }}/ {{ maxLength}}
            </p>
        </div>

        <div v-show="vuelidate.$error">
            <p class="help is-danger" v-show="!vuelidate.minLength">
                Le contenu doit faire au minimum
                {{vuelidate.$params.minLength.min}} caractères.
            </p>
            <p class="help is-danger" v-if="!vuelidate.maxLength">
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
            position: absolute;
            bottom: -17px;
            right: 0px;
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
            value: {
                type: String,
                default: ''
            },
            vuelidate: {
                type: Object,
                required: true
            },
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
                this.vuelidate.$touch();
                this.$emit("input", event.target.value);
            }
        }
    }
</script>
