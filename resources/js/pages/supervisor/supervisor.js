import DatePicker from "../../components/DatePicker";
import Vue from 'vue'

Vue.component('export-to-spreadsheet-form', {
    components: {
        DatePicker,
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
