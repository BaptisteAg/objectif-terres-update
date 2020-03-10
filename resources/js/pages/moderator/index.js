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
    data() {
        return {
            adTypeSelected: [],
            citySelect: [],
            departmentsSelected :[],
            regionsSelected: [],
        }
    },

});
