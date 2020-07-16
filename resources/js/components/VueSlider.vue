<template>
    <div>
        <vue-slider
                :disabled="disabled"
                v-model="sliderTextValue"
                :adsorb="true"
                :data="dataArray"
                :marks="true"
                :height="10"
        ></vue-slider>
        <input type="hidden" :id="name" :name="name" :value="sliderValue">
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
            disabled: Boolean,
            data: Object,
            oldData: {
                type: Object,
                required: false
            },
            name: String,
            value: {
                type: String,
                required: false
            }
        },
        data: function () {
            if(this.value) {
                return {
                    sliderTextValue: this.data[this.value],
                    sliderValue: this.value,
                }
            }

            const hasOld = this.oldData && Object.values(this.oldData).some(x => x);
            return {
                sliderTextValue: hasOld ? this.oldData.textValue : "",
                sliderValue: hasOld ? this.oldData.value : "",
            }
        },
        computed: {
            dataArray() {
                return Object.values(this.data);
            },
        },
        watch: {
            sliderTextValue(v) {
                this.sliderValue = Object.keys(this.data).find(key => this.data[key] === v);
                this.$emit('input', this.sliderValue)
            }
        }
    }
</script>
