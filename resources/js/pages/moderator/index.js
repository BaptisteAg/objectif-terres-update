import MultiSelect from "../../components/MultiSelect";
import AjaxMultiSelect from "../../components/AjaxMultiSelect";
import VueSlider from "../../components/VueSlider";
import Autocomplete from '../../components/Autocomplete'
import Vue from 'vue'


Vue.component('research-form-moderator',{
    components : {
        MultiSelect,
        VueSlider,
        AjaxMultiSelect,
        Autocomplete
    },
    data() {
        return {
            optionProfileSelected: '',
            citySelect: [],
        }
    }
});
