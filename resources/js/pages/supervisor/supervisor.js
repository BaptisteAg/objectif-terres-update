import DateRange from "../../components/DateRange";
import Vue from 'vue'

Vue.component('export-to-spreadsheet-form', {
    components: {
        DateRange
    },
    props : {
        oldInputSelected : ''
    },
    data() {
        return {
            isActive : false
        }
    },
    methods: {
        openModal(){
            this.isActive = true;
        },

        closeModal(){
            this.isActive = false
        }
    }
});
