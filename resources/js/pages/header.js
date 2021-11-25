import MultiSelect from "../components/MultiSelect";
import AjaxMultiSelect from "../components/AjaxMultiSelect";
import VueSlider from "../components/VueSlider";
import VueSliderRange from "../components/VueSliderRange";
import Vue from 'vue'

Vue.component('header-page', {
    components: {
        MultiSelect,
        VueSlider,
        VueSliderRange,
        AjaxMultiSelect,
    },
    props: {
        oldSearchValues: '',
    },
    data() {
        let hasOld = this.oldSearchValues.hasOwnProperty("offer_type") ? Object.values(this.oldSearchValues).some(x => (x !== null && x !== '')) : false;
        return {
            offerTypeSelected: hasOld ? this.oldSearchValues.offer_type : 'OfferAd',
            adCategorySelected: hasOld ? this.oldSearchValues.ad_category : 'land',
            selectedRegions: hasOld ? this.oldSearchValues.regions_location_researches_ids : [],
            selectedDepartments: hasOld ? this.oldSearchValues.departments_location_researches_ids : [],
            selectedCities: hasOld ? this.oldSearchValues.cities_location_researches_ids : [],
            selectedProductions: hasOld ? this.oldSearchValues.production_genres : [],
            selectedBioCertifications: hasOld ? this.oldSearchValues.bio_certifications : [],
            isFormOpen: false,
        }
    },
    methods: {
        more_criteria() {
            this.isFormOpen = this.isFormOpen !== true;
        }
    },
    watch: {
        selectedDepartments(v) {
            if(v.length) {
                this.$refs.header_regions.selected = []
            }
        }
    }
});

