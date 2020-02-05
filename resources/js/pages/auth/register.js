
import Autocomplete from '../../components/Autocomplete'

new Vue({
    name: "SelectCity",
    components : {
        Autocomplete,
    },
    el: '#vue-register-form',
    data(){
        return {
            optionProfileSelected : '',
            citySelect : [],
        }
    }

});
