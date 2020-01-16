import FormNewAdMixin from './mixins/form-new-ad-mixin'
import {minLength, required} from 'vuelidate/lib/validators'
import TextAreaCounter from "../../../components/TextAreaCounter";
import VueSlider from "../../../components/VueSlider";
import Autocomplete from '../../../components/Autocomplete'


export default Vue.extend({
    mixins: [FormNewAdMixin],
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
        renderZoneItemData(item) {
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
        },
        selectedZones: {
            hasZone() {
                return this.selectedZones.length;
            }
        }

    }
});