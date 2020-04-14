import MultiSelect from "../components/MultiSelect";
import AjaxMultiSelect from "../components/AjaxMultiSelect";
import VueSlider from "../components/VueSlider";
import Autocomplete from '../components/Autocomplete'
import VueSliderRange from "../components/VueSliderRange";
import CustomCheckbox from "../components/CustomCheckbox";
import Vue from 'vue'
import {LocationHelper} from "../helpers";
import DateRange from "../components/DateRange";

Vue.component('dashboard-form-filter',{
    components : {
        MultiSelect,
        DateRange,
        VueSlider,
        AjaxMultiSelect,
        Autocomplete,
        VueSliderRange,
        CustomCheckbox
    },
    props : {
        oldInputSelected : ''
    },
    data() {
        const hasOld = Object.values(this.oldInputSelected).some(x => (x !== null && x !== ''));
        return {
            adTypeSelected:hasOld && this.oldInputSelected.ad_type ? this.oldInputSelected.ad_type : [],
            locations : hasOld && this.oldInputSelected.json_locations ?JSON.parse(this.oldInputSelected.json_locations)  : []
        }
    },
    computed: {
        hasCities() {
            return !!this.locations.find(zone => zone.value.type.match(/cities|zipcode/));
        },
        helper() {
            return LocationHelper;
        }
    },
    methods : {
    }

});
