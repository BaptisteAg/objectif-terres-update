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
            isFormOpen : false
        }
    },
    methods: {
        more_criteria() {
            this.isFormOpen = (this.isFormOpen === true) ? false : true;

        }

    }
});
