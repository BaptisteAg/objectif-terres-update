import FormNewAdMixin from './mixins/form-new-ad-mixin'
import FormValidationMixin from '../components/mixins/form-new-ad-validation-mixin';
import {minLength, required} from 'vuelidate/lib/validators'
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
        const v = this.oldValues;
        const hasOld = Object.keys(v).length;

        return {
            formInput: {
                installationTypeId: hasOld ? v.installation_type_id : '',
                productionGenre: hasOld ? v.production_genre : [],
                title: hasOld ? v.title : '',
                offerGenre: hasOld ? v.offer_genre : '',
            },
            selectedZones: hasOld ? JSON.parse(v.selected_zones) : [],
            labelsByZoneType: {
                cities: 'Commune',
                departments: 'Département',
                regions: 'Région'
            }
        }
    },
    computed: {
        isProductionGenreOther() {
            return this.formInput.productionGenre.includes('other');
        }
    },
    methods: {
        onZoneSelect(selectedZone) {
            this.selectedZones.push(selectedZone);
        },
        renderZoneItemData(item) {
            return {
                label: '<b>' + this.labelsByZoneType[item.value.type] + '</b>: ' + item.label,
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
            installationTypeId: {required},
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