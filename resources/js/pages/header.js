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
        searchValues: '',

    },
    data() {
        const hasOld = Object.keys(this.searchValues).length;
        return {
            hasOld : hasOld,
            offerTypeSelected: hasOld  ? this.searchValues.offer_type : 'OfferAd',
            adCategorySelected: hasOld ? this.searchValues.ad_category : 'land',
            selectedRegions: hasOld ? this.searchValues.regions_location_researches_ids : [],
            selectedDepartments : hasOld ? this.searchValues.departments_location_researches_ids : [],
            selectedCities : hasOld ? this.searchValues.cities_location_researches_ids : [],
            selectedRadius : hasOld ? this.searchValues.radius_research+'km' : '',
            selectedRangeSurface : hasOld ? this.searchValues.surfaces_research : '',
            selectedProductions : hasOld ? this.searchValues.production_genres : [],
            selectedBioCertifications : hasOld ? this.searchValues.bio_certifications : [],
            isFormOpen : false,
        }
    },
    methods: {
        more_criteria() {
            this.isFormOpen = this.isFormOpen !== true;
        }

    }
});

