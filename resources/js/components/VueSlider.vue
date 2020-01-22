<template>
    <div>
        <vue-slider
                v-model="sliderValue"
                :adsorb="true"
                :data="ranges"
                :marks="true"
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
            data : Array,
            name: String,
            values: {
                type: Array,
                required: false
            }
        },
        data: function () {
            return {
                sliderValue: this.values,
                ranges: this.data
            }
        }
    }
</script>
