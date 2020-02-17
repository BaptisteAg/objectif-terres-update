<template>
    <div>
        <vue-slider
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
    export default  {
        components: {
            VueSlider
        },
        props:{
            data : Object,
            name: String,
            value: {
                type: Number,
                required: false
            }
        },
        data: function () {
            return {
                sliderTextValue: this.value || "",
                sliderValue: ""
            }
        },
        computed: {
            dataArray() {
                return Object.values(this.data);
            },
        },
        watch: {
            sliderTextValue(v) {
                this.sliderValue = _.findKey(this.data, d => d === v);
                this.$emit('input', this.sliderValue)
            }
        }
    }
</script>
