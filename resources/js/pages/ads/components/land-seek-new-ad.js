import FormNewAdMixin from './mixins/form-new-ad-mixin'
import FormValidationMixin from '../components/mixins/form-new-ad-validation-mixin';
import {required, maxLength, minLength} from 'vuelidate/lib/validators'
import TextAreaCounter from "../../../components/TextAreaCounter";
import VueSlider from "../../../components/VueSlider";
import Autocomplete from '../../../components/Autocomplete'


export default Vue.extend({
    mixins: [FormNewAdMixin, FormValidationMixin],
    props: {},
    components: {
        TextAreaCounter,
        VueSlider,
        Autocomplete,
    },
    data() {
        return {
            offerGenre: this.oldValues.offer_genre,
            isProductionGenreOther: false,
            formInput: {
                installationType: '',
                productionGenre: [],
                title: '',
            },
            selectedZones : this.oldValues.selected_zones ? JSON.parse(this.oldValues.selected_zones) : [],
            labelsByZoneType : {
                cities: 'Commune',
                departments: 'Département',
                regions: 'Région'
            }
        }
    },
    methods: {
        onZoneSelect(selectedZone) {
            this.selectedZones.push(selectedZone);
        },
        onZoneDataRender(item) {
            return {
                label: '<b>'+this.labelsByZoneType[item.value.type] + '</b>: ' + item.label,
                value: {
                    ...item.value,
                    originalLabel: item.label,
                    type: item.value.type
                },
            }
        }
    },
    validations: {
        formInput: {
            installationType: {required},
            productionGenre: {required},
            title: {
                required,
                minLength: minLength(5),
            }
        }

    }
});