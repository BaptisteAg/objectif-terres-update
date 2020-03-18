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
    props: {
        searchValues: [Array, Object]
    },
    data() {
        return {
            offerTypeSelected: this.searchValues ? this.searchValues.offer_type : 'offer',
            adCategorySelected: this.searchValues ? this.searchValues.ad_category : 'land',
            selectedRegions: this.searchValues ? this.searchValues.regions : [],
            isFormOpen : false,
            productionsSelected : [],
            bioProductionsSelected : [],
            regionsSelected :[],
            departmentsSelected : []
        }
    },
    methods: {
        more_criteria() {
            this.isFormOpen = this.isFormOpen !== true;
        }

    }
});

