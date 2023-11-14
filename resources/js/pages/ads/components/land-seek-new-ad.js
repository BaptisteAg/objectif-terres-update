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
        let old = this.oldValues;

        if (!old.land_seek) {
            old.land_seek = {}
        }

        return {
            formInput: {
                selectedDepartments: old.selected_departments && JSON.parse(old.selected_departments) || [],
                selectedZones: old.selected_zones && JSON.parse(old.selected_zones) || [],
                surfaceRangeMin: old.land_seek.surface_range_min || '0',
                surfaceRangeMax: old.land_seek.surface_range_max || '1000000',
                landDescription: old.land_seek.land_description || '',
                buildingRequirement: old.land_seek && old.land_seek.buildings ? old.land_seek.buildings[1] : '',
                farmsRequirement: old.land_seek && old.land_seek.buildings ? old.land_seek.buildings[2] : '',
                productionGenres: old.land_seek.production_genres || [],
                productionTypeAdd: old.land_seek.production_type_add || '',
                isBio: old.land_seek.is_bio,
                installationTypeId: old.land_seek.installation_type_id || '',
                aboutProject: old.about_project_content || '',
                // experienceFarming: v.land_seek.experience_farming || '',
                aboutContent: old.about_content || '',
                title: old.title || '',
                documents: old.documents && JSON.parse(old.documents) || [],
                chartConfirmation: old.chart_confirmation || true,
                productionGenresSecondary: old.land_seek.secondary_production_genres || [],
                secondProductionTypeAdd: old.land_seek.secondary_production_type_add || ''
            }
        }
    },
    computed: {
        productionGenresHasOther() {
            return this.formInput.productionGenres.includes('other');
        },
        productionGenresSecondaryHasOther() {
            return this.formInput.productionGenresSecondary.includes('other');
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
        return {
            formInput: {
                ...baseValidations.formInput,
                selectedDepartments: {
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
                    required,
                    isTrue: value => value === true
                }
            }
        }
    }
});
