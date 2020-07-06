import {maxLength, minLength, required} from 'vuelidate/lib/validators'
import baseValidations from './base-validations'

import FormNewAdMixin from "./mixins/form-new-ad-mixin";

import TextAreaCounter from "../../../components/TextAreaCounter";
import CustomCheckbox from "../../../components/CustomCheckbox"
import Autocomplete from '../../../components/Autocomplete'
import DocumentsUpload from "../../../components/DocumentsUpload"
import MultiSelect from "../../../components/MultiSelect";
import ZoneSelect from '../../../components/ZoneSelect'

export default {
    components: {
        ZoneSelect,
        TextAreaCounter,
        CustomCheckbox,
        Autocomplete,
        DocumentsUpload,
        MultiSelect
    },
    mixins: [FormNewAdMixin],
    props: {},
    data() {
        const v = this.oldValues;
        const hasOld = Object.keys(v).length && v.job_seek;

        return {
            formInput: {
                selectedZones: hasOld && v.selected_zones || [],

                offerTypes: hasOld && v.job_seek.offer_types || [],
                experienceFarming: hasOld && v.job_seek.experience_farming || '',
                educationLevels: hasOld && v.job_seek.education_levels || [],

                aboutProject: hasOld && v.about_project_content || '',
                aboutContent: hasOld && v.about_content || '',
                title: hasOld && v.title || '',
                documents: hasOld && JSON.parse(v.documents) || [],
                //beneficiary: hasOld && v.is_beneficiary || '',
                //agriculturalActivity: hasOld && v.agricultural_activity || [],
            }
        }
    },
    validations() {
        return {
            formInput: {
                ...baseValidations.formInput,
                experienceFarming: {
                    required,
                    minLength: minLength(5),
                    maxLength: maxLength(1000)
                },
            }
        }
    }
};
