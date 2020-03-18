import Vue from "vue";
import Autocomplete from "../../components/Autocomplete";

Vue.component('contact-form', {
    components: {
        Autocomplete,
    },
    data() {
        return {
            optionProfileSelected: '',
            citySelect: [],
        }
    }
});
