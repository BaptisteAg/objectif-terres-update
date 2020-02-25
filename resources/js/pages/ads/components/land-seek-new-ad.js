import {maxLength, minLength, numeric, required} from 'vuelidate/lib/validators'

import FormNewAdMixin from './mixins/form-new-ad-mixin'
import TextAreaCounter from "../../../components/TextAreaCounter";
import VueSliderRange from "../../../components/VueSliderRange";
import ZoneSelect from '../../../components/ZoneSelect'
import AdTypeSelect from '../../../components/AdTypeSelect'
import MultiSelect from "../../../components/MultiSelect";
import CustomCheckbox from "../../../components/CustomCheckbox"
import DocumentsUpload from "../../../components/DocumentsUpload"

export default Vue.extend({
    mixins: [FormNewAdMixin],
    props: {},
    components: {
        AdTypeSelect,
        ZoneSelect,
        VueSliderRange,
        MultiSelect,
        CustomCheckbox,
        TextAreaCounter,
        DocumentsUpload
    },
    data() {
        const v = this.oldValues;
        const hasOld = Object.keys(v).length;

        return {
            formInput: {
                selectedZones: hasOld ? JSON.parse(v.selected_zones) : [],
                surfaceRangeMin : hasOld ? v.land_seek.surface_range_min : 0,
                surfaceRangeMax : hasOld ? v.land_seek.surface_range_max : 0,
                productionGenres: hasOld ? v.land_seek.production_genres : [],
                productionTypeAdd: hasOld ? v.land_seek.production_type_add : '',
                installationTypeId: hasOld ? v.land_seek.installation_type_id : '',
                aboutProject: hasOld ? v.about_project_content : '',
                experienceFarming: hasOld ? (v.land_seek.experience_farming || '') : '',
                aboutContent: hasOld ? v.about_content : '',
                title: hasOld ? v.title : '',
                documents: hasOld ? JSON.parse(v.documents) : [],
                chartConfirmation: false,
                //offerGenre: hasOld ? v.land_seek.offer_genre_id : '',
                //minRent: hasOld ? v.land_seek.rent_min : '',
                //maxRent: hasOld ? v.land_seek.rent_max : '',
            }
        }
    },
    computed: {
        productionGenresHasOther() {
            return this.formInput.productionGenres.includes('other');
        }
    },
    watch: {
        'formInput.productionGenres': function (productionGenres) {
            if (!productionGenres.includes('other')) {
                this.formInput.productionTypeAdd = '';
            }
        },
    },
    methods: {
    },
    validations: {
        formInput: {
            productionGenres: {required},
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
            },
            surfaceRangeMax: {required}
        }
    }
});
