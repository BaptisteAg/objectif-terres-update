<template>
    <div>
        <vue-slider
                v-model="value"
                :adsorb="true"
                :data="ranges"
                :marks="true"
        ></vue-slider>
        <input type="hidden" :id="name" :name="name" :value="value">
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
            name: String
        },
        data: function () {
            return {
                value: 0,
                ranges: this.data
            }
        }
    }
</script>