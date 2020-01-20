import MultiSelect from "../components/MultiSelect";
import VueSlider from "../components/VueSlider";
import Autocomplete from "../components/Autocomplete";

const headerPage = new Vue({
    components : {
        MultiSelect,
        VueSlider,
        Autocomplete,
    },
    el: '#vue-header',
    data() {
        return {
            adTypeSelected: 'offer_ads',
            adCategorySelected: 'land',
            adTypeChosen: ''
        }
    },
    methods: {
        more_criteria() {
            this.adTypeChosen = (this.adCategorySelected === 'land') ? 'land' : 'job';
        }
    }
});
