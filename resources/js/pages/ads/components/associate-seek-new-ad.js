import {maxLength, minLength, required} from 'vuelidate/lib/validators'
import baseValidations from './base-validations'

import FormNewAdMixin from "./mixins/form-new-ad-mixin";

import TextAreaCounter from "../../../components/TextAreaCounter";
import CustomCheckbox from "../../../components/CustomCheckbox"
import Autocomplete from '../../../components/Autocomplete'
import DocumentsUpload from "../../../components/DocumentsUpload"
import MultiSelect from "../../../components/MultiSelect";
import ZoneSelect from '../../../components/ZoneSelect'
import ListSelect from "../../../components/ListSelect.vue";

export default {
    components: {
        ZoneSelect,
        TextAreaCounter,
        CustomCheckbox,
        Autocomplete,
        DocumentsUpload,
        MultiSelect,
        ListSelect
    },
    mixins: [FormNewAdMixin],
    props: {},
    data() {
        const old = this.oldValues;

        if(!old.associate_seek) {
            old.associate_seek = {}
        }

        return {
            formInput: {
                selectedDepartments: old.selected_departments && JSON.parse(old.selected_departments) || [],
                selectedZones: old.selected_zones && JSON.parse(old.selected_zones) || [],

                isLandAlreadyFound: old.associate_seek.is_land_already_found,
                landDescription: old.associate_seek.land_description || '',
                associateDescription: old.associate_seek.associate_description || '',
                experienceFarming: old.associate_seek.experience_farming || '',
                educationLevels: old.associate_seek.education_levels || [],
                productionGenres: old.associate_seek.production_genres || [],
                productionGenresSecondary: old.associate_seek.secondary_production_genres || [],

                aboutProject: old.about_project_content || '',
                aboutContent: old.about_content || '',
                title: old.title || '',
                documents: old.documents && JSON.parse(old.documents) || [],
                chartConfirmation: old.chart_confirmation || true,
            }
        }
    },
    validations() {
        return {
            formInput: {
                ...baseValidations.formInput,
                selectedDepartments: {
                    required
                },
                associateDescription: {
                    minLength: minLength(5),
                    maxLength:
                        maxLength(1500),
                    required
                },
                productionGenres: {
                    required,
                },
                educationLevels: {
                    required
                },
            }
        }
    }
};
