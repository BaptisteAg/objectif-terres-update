import {maxLength, minLength, numeric, minValue, required} from 'vuelidate/lib/validators'
import baseValidations from './base-validations'

import FormNewAdMixin from './mixins/form-new-ad-mixin'

import TextAreaCounter from "../../../components/TextAreaCounter";
import VueSliderRange from "../../../components/VueSliderRange";
import VueSlider from "../../../components/VueSlider";
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
        VueSlider,
        MultiSelect,
        CustomCheckbox,
        TextAreaCounter,
        DocumentsUpload
    },
    data() {
        const v = this.oldValues;
        const hasOld = Object.keys(v).length && v.land_seek;

        const extraFormInput = this.isSupportRequest ? {
            offerGenres: hasOld && v.land_seek.offer_genres || [],
            rentMax : hasOld && v.land_seek.rent_max || '0',
            priceMax : hasOld && v.land_seek.price_max || '200000',
            educationLevels: hasOld && v.land_seek.education_levels || [],
        } : {};

        return {
            formInput: {
                selectedZones: hasOld && JSON.parse(v.selected_zones) || [],
                surfaceRangeMin : hasOld && v.land_seek.surface_range_min || '0',
                surfaceRangeMax : hasOld && v.land_seek.surface_range_max || '1000000',
                landDescription: hasOld && v.land_seek.land_description || '',
                productionGenres: hasOld && v.land_seek.production_genres || [],
                productionTypeAdd: hasOld && v.land_seek.production_type_add || '',
                installationTypeId: hasOld && v.land_seek.installation_type_id || '',
                aboutProject: hasOld && v.about_project_content || '',
                experienceFarming: hasOld && v.land_seek.experience_farming || '',
                aboutContent: hasOld && v.about_content || '',
                title: hasOld && v.title || '',
                documents: hasOld && JSON.parse(v.documents) || [],
                chartConfirmation: hasOld && v.chart_confirmation || false,
                ...extraFormInput
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
    validations() {
        const extraValidations = this.isSupportRequest ? {
            offerGenres: {required},
        } : {};

        return {
            formInput: {
                ...baseValidations.formInput,
                surfaceRangeMax: {
                    minValue: minValue(5)
                },
                landDescription: {
                    minLength: minLength(5),
                    maxLength: maxLength(1000),
                },
                productionGenres: {required},
                installationTypeId: {required},
                rentMax: {numeric},
                experienceFarming: {
                    minLength: minLength(5),
                    maxLength: maxLength(1000),
                },
                chartConfirmation: {
                    checked(v) {
                        return !!v
                    }
                },
                ...extraValidations
            }
        }
    }
});
