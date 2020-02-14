import {maxLength, minLength, numeric, required} from 'vuelidate/lib/validators'

import FormNewAdMixin from './mixins/form-new-ad-mixin'
import TextAreaCounter from "../../../components/TextAreaCounter";
import VueSlider from "../../../components/VueSlider";
import VueSliderRange from "../../../components/VueSliderRange";
import ZoneSelect from '../../../components/ZoneSelect'
import AdTypeSelect from '../../../components/AdTypeSelect'
import MultiSelect from "../../../components/MultiSelect";
import CustomRadio from "../../../components/CustomRadio"

import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

export default Vue.extend({
    mixins: [FormNewAdMixin],
    props: {},
    components: {
        CustomRadio,
        TextAreaCounter,
        VueSlider,
        VueSliderRange,
        ZoneSelect,
        AdTypeSelect,
        MultiSelect,
        vueDropzone: vue2Dropzone
    },
    data() {
        const v = this.oldValues;
        const hasOld = Object.keys(v).length;

        return {
            formInput: {
                surfaceRangeMin : hasOld ? v.land_seek.surface_range_min : 0,
                surfaceRangeMax : hasOld ? v.land_seek.surface_range_max : 0,
                installationTypeId: hasOld ? v.land_seek.installation_type_id : '',
                productionGenre: hasOld ? v.land_seek.production_genre : [],
                productionTypeAdd: hasOld ? v.land_seek.production_type_add : '',
                minRent: hasOld ? v.land_seek.rent_min : '',
                maxRent: hasOld ? v.land_seek.rent_max : '',
                offerGenre: hasOld ? v.land_seek.offer_genre_id : '',
                selectedZones: hasOld ? JSON.parse(v.land_seek.selected_zones) : [],
                experienceFarming: hasOld ? (v.land_seek.experience_farming || '') : '',
                aboutProject: hasOld ? v.about_project_content : '',
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
