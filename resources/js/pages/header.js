import MultiSelect from "../components/MultiSelect";
import AjaxMultiSelect from "../components/AjaxMultiSelect";
import VueSlider from "../components/VueSlider";

new Vue({
    name: "HeaderPage",
    components : {
        MultiSelect,
        VueSlider,
        AjaxMultiSelect,
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
