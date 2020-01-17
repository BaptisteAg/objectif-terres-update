import FormNewAdMixin from './mixins/form-new-ad-mixin'
import FormValidationMixin from '../components/mixins/form-new-ad-validation-mixin';
import {minLength, required, numeric, sameAs} from 'vuelidate/lib/validators'
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

            offerGenre: hasOld ? v.offer_genre : '',
            isProductionGenreOther: hasOld ? v.is_production_genre : false,
            formInput: {
                installationTypeId: hasOld ? v.installation_type_id : '',
                productionGenre: hasOld ? v.production_genre : [],
                title: hasOld ? v.title : '',
                minRent :  hasOld ? v.rent_min : '',
                maxRent :  hasOld ? v.rent_max : '',
                chartConfirmation : hasOld ? v.chart_confirmation : false ,
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
            minRent : {numeric},
            maxRent : {numeric},
            chartConfirmation : {
                required,
                sameAs: sameAs( () => true ) },
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