import MultiSelect from "../../components/MultiSelect";
import AjaxMultiSelect from "../../components/AjaxMultiSelect";
import VueSlider from "../../components/VueSlider";
import Autocomplete from '../../components/Autocomplete'
import DatePicker from "../../components/DatePicker";
import VueSliderRange from "../../components/VueSliderRange";
import Vue from 'vue'


Vue.component('research-form-moderator',{
    components : {
        MultiSelect,
        VueSlider,
        AjaxMultiSelect,
        Autocomplete,
        DatePicker,
        VueSliderRange
    },
    data() {
        return {
            adType: 'land',
            citySelect: [],
        }
    },
    methods : {
        adTypeSelected(value){
            this.adType = value;
        }
    }
});
