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
        const v = this.oldValues;
        const hasOld = Object.keys(v).length && v.associate_seek;

        return {
            formInput: {
                selectedDepartments: hasOld && JSON.parse(old.selected_departments) || [],
                selectedZones: hasOld && JSON.parse(v.selected_zones) || [],

                isLandAlreadyFound: v.is_land_already_found,
                landDescription: hasOld && v.associate_seek.land_description || '',
                associateDescription: hasOld && v.associate_seek.associate_description || '',
                experienceFarming: hasOld && v.associate_seek.experience_farming || '',
                educationLevels: hasOld && v.associate_seek.education_levels || [],

                aboutProject: hasOld && v.about_project_content || '',
                aboutContent: hasOld && v.about_content || '',
                title: hasOld && v.title || '',
                documents: hasOld && JSON.parse(v.documents) || [],
                productionGenres: hasOld && v.production_genres || [],
                productionGenresSecondary: hasOld && v.secondary_production_genres || [],
                chartConfirmation: hasOld && v.chart_confirmation || false,
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
