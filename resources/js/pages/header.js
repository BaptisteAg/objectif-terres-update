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
            adTypeSelected: 'OfferAd',
            adCategorySelected: 'land',
            isFormOpen : false,
            productionsSelected : [],
            bioProductionsSelected : [],
            regionsSelected :[],
            departmentsSelected : []
        }
    },
    methods: {
        more_criteria() {
            this.isFormOpen = (this.isFormOpen === true) ? false : true;

        }

    }
});

