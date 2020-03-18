import Autocomplete from '../../components/Autocomplete'
import Vue from 'vue'

Vue.component('register-form', {
    components: {
        Autocomplete,
    },
    props: {
        oldValues: {
            type: Object
        }
    },
    data() {
        return {
            optionProfileSelected: this.oldValues.profile || '',
            citySelect: this.oldValues.citySelect ? JSON.parse(this.oldValues.citySelect) : [],
        }
    }
});
