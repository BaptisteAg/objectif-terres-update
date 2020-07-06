<template>
    <div>
        <vue-slider
                v-model="selectedMinMaxLabels"
                :adsorb="true"
                :data="Object.values(data)"
                :marks="true"
                :height="10"
                :enable-cross="false"
        ></vue-slider>
        <input type="hidden" :name="nameMin" :value="selectedMinMaxValues[0]" :disabled="disabled">
        <input type="hidden" :name="nameMax" :value="selectedMinMaxValues[1]" :disabled="disabled">
    </div>
</template>

<script>
    import VueSlider from 'vue-slider-component'
    import 'vue-slider-component/theme/default.css'

    export default {
        components: {
            VueSlider
        },
        props: {
            data: Object,
            nameMin: String,
            nameMax: String,
            value: {
                type: Array,
                required: false
            },
            disabled: Boolean
        },
        data: function () {
            if (Array.isArray(this.value) && this.value.length) {
                return {
                    selectedMinMaxLabels: [
                        this.data[this.value[0]],
                        this.data[this.value[1]]
                    ],
                    selectedMinMaxValues: this.value,
                }
            }

            const values = Object.values(this.data);
            const keys = Object.keys(this.data);

            return {
                selectedMinMaxLabels: [values[0], values[0]],
                selectedMinMaxValues: [keys[0], keys[0]],
            }
        },
        watch: {
            selectedMinMaxLabels(textValues) {
                this.selectedMinMaxValues = textValues.map(v => {
                    return _.findKey(this.data, d => d === v);
                });

                this.$emit('input', this.selectedMinMaxValues)
            }
        }
    }
</script>
