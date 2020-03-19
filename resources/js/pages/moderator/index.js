import MultiSelect from "../../components/MultiSelect";
import AjaxMultiSelect from "../../components/AjaxMultiSelect";
import VueSlider from "../../components/VueSlider";
import Autocomplete from '../../components/Autocomplete'
import DatePicker from "../../components/DatePicker";
import VueSliderRange from "../../components/VueSliderRange";
import CustomCheckbox from "../../components/CustomCheckbox";
import Vue from 'vue'


Vue.component('research-form-moderator',{
    components : {
        MultiSelect,
        VueSlider,
        AjaxMultiSelect,
        Autocomplete,
        DatePicker,
        VueSliderRange,
        CustomCheckbox
    },
    props : {
        oldInputSelected : ''
    },
    data() {
        const hasOld = Object.values(this.oldInputSelected).some(x => (x !== null && x !== ''));
        return {
            hasOld : this.oldInputSelected,
            adTypeSelected:hasOld && this.oldInputSelected.ad_type ? this.oldInputSelected.ad_type : [],
            regionsSelected: hasOld ? this.oldInputSelected.regions_location_researches : [],
            citySelect: hasOld ? this.oldInputSelected.cities_location_researches : [],
            departmentsSelected :hasOld ? this.oldInputSelected.departments_location_researches : [],
            dateSelected : hasOld? this.oldInputSelected.date_research_range : ''
        }
    },

});
