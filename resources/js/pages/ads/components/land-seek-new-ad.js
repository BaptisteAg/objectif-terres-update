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
import ListSelect from "../../../components/ListSelect"
import DocumentsUpload from "../../../components/DocumentsUpload"
import Autocomplete from "../../../components/Autocomplete"

export default Vue.extend({
    mixins: [FormNewAdMixin],
    props: {},
    components: {
        Autocomplete,
        AdTypeSelect,
        ZoneSelect,
        VueSliderRange,
        VueSlider,
        MultiSelect,
        CustomCheckbox,
        TextAreaCounter,
        DocumentsUpload,
        ListSelect,
    },
    data() {
        let v = this.oldValues;

        if (!v.land_seek) {
            v.land_seek = {}
        }

        const extraFormInput = this.isSupportRequest ? {
            offerGenres: v.land_seek.offer_genres || [],
            rentMax: v.land_seek.rent_max || '0',
            priceMax: v.land_seek.price_max || '',
            educationLevels: v.land_seek.education_levels || [],
            supportRequestText: v.support_request_text || '',
            supportRequestTerritoryId: v.support_request_territory_id || "",
        } : {};

        return {
            formInput: {
                selectedDepartment: v.selected_departments && JSON.parse(v.selected_departments) || [],
                selectedZones: v.selected_zones && JSON.parse(v.selected_zones) || [],
                surfaceRangeMin: v.land_seek.surface_range_min || '0',
                surfaceRangeMax: v.land_seek.surface_range_max || '1000000',
                landDescription: v.land_seek.land_description || '',
                buildingRequirement: v.land_seek && v.land_seek.buildings ? v.land_seek.buildings[1] : '',
                farmsRequirement: v.land_seek && v.land_seek.buildings ? v.land_seek.buildings[2] : '',
                productionGenres: v.land_seek.production_genres || [],
                productionTypeAdd: v.land_seek.production_type_add || '',
                isBio: v.land_seek.is_bio || undefined,
                installationTypeId: v.land_seek.installation_type_id || '',
                aboutProject: v.about_project_content || '',
                // experienceFarming: v.land_seek.experience_farming || '',
                aboutContent: v.about_content || '',
                title: v.title || '',
                documents: v.documents && JSON.parse(v.documents) || [],
                chartConfirmation: v.chart_confirmation || false,
                secondProductionGenres: v.land_seek.secondary_production_genres || [],
                secondProductionTypeAdd: v.land_seek.secondary_production_type_add || '',
                ...extraFormInput
            }
        }
    },
    computed: {
        productionGenresHasOther() {
            return this.formInput.productionGenres.includes('other');
        },
        secondProductionGenresHasOther() {
            return this.formInput.secondProductionGenres.includes('other');
        },
    },
    watch: {
        'formInput.productionGenres': function (productionGenres) {
            if (!productionGenres.includes('other')) {
                this.formInput.productionTypeAdd = '';
            }
        },
    },
    methods: {},
    validations() {
        const extraValidations = this.isSupportRequest ? {
            offerGenres: {required},
            supportRequestText: {
                minLength: minLength(10),
                maxLength: maxLength(400),
            },
        } : {};

        return {
            formInput: {
                ...baseValidations.formInput,
                selectedDepartment: {
                    required,
                },
                surfaceRangeMax: {
                    minValue: minValue(5)
                },
                landDescription: {
                    minLength: minLength(5),
                    maxLength: maxLength(1500),
                },
                productionGenres: {required},
                buildingRequirement: {required},
                farmsRequirement: {required},
                installationTypeId: {required},
                rentMax: {numeric},
                isBio: {required},

                experienceFarming: {
                    minLength: minLength(5),
                    maxLength: maxLength(1500),
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
