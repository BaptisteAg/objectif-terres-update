import Autocomplete from '../../components/Autocomplete'
import Vue from 'vue'

Vue.component('register-form', {
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
