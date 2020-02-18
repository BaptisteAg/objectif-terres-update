import FormNewAdMixin from "./mixins/form-new-ad-mixin";
import {maxLength, minLength, numeric, required, requiredIf} from 'vuelidate/lib/validators'
import TextAreaCounter from "../../../components/TextAreaCounter";
import CustomCheckbox from "../../../components/CustomCheckbox"
import Autocomplete from '../../../components/Autocomplete'
import DocumentsUpload from "../../../components/DocumentsUpload"
import MultiSelect from "../../../components/MultiSelect";

export default {
    components: {
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
        const hasOld = Object.keys(v).length;

        return {
            formInput: {
                selectedZones: hasOld ? v.selected_zones : [],

                offerTypes: hasOld ? v.job_offer.offer_types : [],
                jobDescription: hasOld ? v.job_offer.job_description : '',
                experienceFarming: hasOld ? v.job_offer.experience_farming : '',
                educationLevels: hasOld ? v.job_offer.education_levels : [],

                aboutProject: hasOld ? v.about_project_content : '',
                aboutContent: hasOld ? v.about_content : '',
                title: hasOld ? v.title : '',
                documents: hasOld ? JSON.parse(v.documents) : [],
                //beneficiary: hasOld ? v.is_beneficiary : '',
                //agriculturalActivity: hasOld ? v.agricultural_activity : [],
            }
        }
    },
    watch: {

    },
    validations: {
        formInput: {
            jobDescription: {
                required,
                minLength: minLength(5),
                maxLength: maxLength(1000)
            },
            experienceFarming: {
                required,
                minLength: minLength(5),
                maxLength: maxLength(1000)
            },
        }
    }

};
