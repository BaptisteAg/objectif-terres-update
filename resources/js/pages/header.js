import MultiSelect from "../components/MultiSelect";
import AjaxMultiSelect from "../components/AjaxMultiSelect";
import VueSlider from "../components/VueSlider";
import Vue from 'vue'


Vue.component('header-page',{
    components : {
        MultiSelect,
        VueSlider,
        AjaxMultiSelect,
    },
    data() {
        return {
            adTypeSelected: 'offer_ads',
            adCategorySelected: 'land',
            isFormOpen : false,
            isDisplay : 'none'
        }
    },
    methods: {
        more_criteria() {
            this.isFormOpen = (this.isFormOpen === true) ? false : true;
            this.isDisplay = (this.isFormOpen === true) ? 'visible' : 'none';

        }

    }
});

