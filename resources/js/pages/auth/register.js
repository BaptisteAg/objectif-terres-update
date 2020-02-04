
import Autocomplete from '../../components/Autocomplete'

new Vue({
    name: "SelectCity",
    components : {
        Autocomplete,
    },
    el: '#vue-multi-select-city',
    data(){
        return {
            citySelect : [],
        }
    }

});
