import {maxLength, minLength, numeric, required} from 'vuelidate/lib/validators'

import FormNewAdMixin from './mixins/form-new-ad-mixin'
import TextAreaCounter from "../../../components/TextAreaCounter";
import VueSliderRange from "../../../components/VueSliderRange";
import ZoneSelect from '../../../components/ZoneSelect'
import AdTypeSelect from '../../../components/AdTypeSelect'
import MultiSelect from "../../../components/MultiSelect";
import CustomRadio from "../../../components/CustomRadio"
import DocumentsUpload from "../../../components/DocumentsUpload"

export default Vue.extend({
    mixins: [FormNewAdMixin],
    props: {},
    components: {
        AdTypeSelect,
        ZoneSelect,
        VueSliderRange,
        MultiSelect,
        CustomRadio,
        TextAreaCounter,
        DocumentsUpload
    },
    data() {
        const v = this.oldValues;
        const hasOld = Object.keys(v).length;

        return {
            formInput: {
                selectedZones: hasOld ? JSON.parse(v.selected_zones) : [],
                productionGenre: hasOld ? v.land_seek.production_genre : [],
                productionTypeAdd: hasOld ? v.land_seek.production_type_add : '',
                installationTypeId: hasOld ? v.land_seek.installation_type_id : '',
                //offerGenre: hasOld ? v.land_seek.offer_genre_id : '',
                //surfaceRangeMin : hasOld ? v.land_seek.surface_range_min : 0,
                //surfaceRangeMax : hasOld ? v.land_seek.surface_range_max : 0,
                //minRent: hasOld ? v.land_seek.rent_min : '',
                //maxRent: hasOld ? v.land_seek.rent_max : '',
                aboutProject: hasOld ? v.about_project_content : '',
                experienceFarming: hasOld ? (v.land_seek.experience_farming || '') : '',
                aboutContent: hasOld ? v.about_content : '',
                title: hasOld ? v.title : '',
                documents: hasOld ? JSON.parse(v.documents) : [],
                chartConfirmation: false,
            }
        }
    },
    computed: {
        isProductionGenreOther() {
            return this.formInput.productionGenre.includes('other');
        }
    },
    watch: {
        'formInput.productionGenre': function (productionGenre) {
            if (!productionGenre.includes('other')) {
                this.formInput.productionTypeAdd = '';
            }
        },
    },
    methods: {
    },
    validations: {
        formInput: {
            selectedZones: {
                hasZone(zones) {
                    return zones.length;
                }
            },
            productionGenre: {required},
            installationTypeId: {required},
            minRent: {numeric},
            maxRent: {numeric},
            experienceFarming: {
                minLength: minLength(5),
                maxLength: maxLength(1000),
            },
            chartConfirmation: {
                checked(v) {
                    return !!v
                }
            }
        }
    }
});
