import {maxLength, minLength, numeric, required} from 'vuelidate/lib/validators'

import FormNewAdMixin from './mixins/form-new-ad-mixin'
import TextAreaCounter from "../../../components/TextAreaCounter";
import VueSlider from "../../../components/VueSlider";
import ZoneSelect from '../../../components/ZoneSelect'
import AdTypeSelect from'../../../components/AdTypeSelect'

import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

export default Vue.extend({
    mixins: [FormNewAdMixin],
    props: {},
    components: {
        TextAreaCounter,
        VueSlider,
        ZoneSelect,
        AdTypeSelect,
        vueDropzone: vue2Dropzone
    },
    data() {
        const v = this.oldValues;
        const hasOld = Object.keys(v).length;

        return {
            formInput: {
                installationTypeId: hasOld ? v.installation_type_id : '',
                productionGenre: hasOld ? v.production_genre : [],
                productionTypeAdd: hasOld ? v.production_type_add : '',
                title: hasOld ? v.title : '',
                minRent: hasOld ? v.rent_min : '',
                maxRent: hasOld ? v.rent_max : '',
                chartConfirmation: false,
                offerGenre: hasOld ? v.offer_genre_id : '',
                selectedZones: hasOld ? JSON.parse(v.selected_zones) : [],
                aboutProject: hasOld ? v.about_project_content : '',
                aboutContent: hasOld ? v.about_content: '',
                experienceFarming: hasOld ? (v.experience_farming || '') : '',
            },
        }
    },
    computed: {
        isProductionGenreOther() {
            return this.formInput.productionGenre.includes('other');
        }
    },
    watch: {
        'formInput.productionGenre': function(productionGenre) {
            if(!productionGenre.includes('other')) {
                this.formInput.productionTypeAdd = '';
            }
        },
    },
    validations: {
        formInput: {
            selectedZones: {
                hasZone() { return this.formInput.selectedZones.length; }
            },
            installationTypeId: {required},
            productionGenre: {required},
            minRent: {numeric},
            maxRent: {numeric},
            experienceFarming: {
                minLength: minLength(5),
                maxLength: maxLength(1000),
            },
            aboutProject: {
                minLength: minLength(5),
                maxLength: maxLength(1000),
                required
            },
            aboutContent: {
                minLength: minLength(5),
                maxLength: maxLength(1000),
                required
            },
            title: {
                required,
                minLength: minLength(5),
            },
            chartConfirmation: {
                checked(v) {return !!v}
            }

        }
    }
});
