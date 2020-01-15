<template>
    <div>
        <vue-slider
                v-model="localisationRange"
                :adsorb="true"
                :data="ranges"
                :marks="true"
        ></vue-slider>
        <input id="land_seek[city_range]" name="prodId" type="hidden" :value="localisationRange">
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
            data : [],
        },
        data: function () {
            return {
                localisationRange: 0,
                ranges: this.data
            }
        }
    }
</script>