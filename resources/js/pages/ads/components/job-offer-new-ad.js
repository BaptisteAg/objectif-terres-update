import FormNewAdMixin from "./mixins/form-new-ad-mixin";
import FormValidationMixin from '../components/mixins/form-new-ad-validation-mixin';
import {required, maxLength, numeric, minLength, requiredUnless, sameAs, requiredIf} from 'vuelidate/lib/validators'
import TextAreaCounter from "../../../components/TextAreaCounter";
import ZoneSelect from "../../../components/ZoneSelect";

export default {
    components: {
        TextAreaCounter,
        ZoneSelect,
    },
    mixins: [FormNewAdMixin, FormValidationMixin],
    props: {},
    data() {
        const v = this.oldValues;
        const hasOld = Object.keys(v).length;

        return {
            isInputRequired: false,
            formInput: {
                beneficiary: hasOld ? v.is_beneficiary : '',
                selectedZones: hasOld ? JSON.parse(v.selected_zones) : [],
                agriculturalActivity: hasOld ? v.agricultural_activity : [],
                jobStatus: hasOld ? v.job_status : '',
                isJobOpportunity: hasOld ? v.is_offer : '',
                experienceFarming: hasOld ? v.experience_farming : '',
                aboutProject: hasOld ? v.about_project_content : '',
                aboutContent: hasOld ? v.about_content : '',
                title: hasOld ? v.title : '',
            }
        }
    },
    watch: {
        'formInput.isJobOpportunity': function () {
            this.isInputRequired = this.isJobOpportunity === "1";
        },

    },
    validations: {
        formInput: {
            beneficiary: {required},
            isJobOpportunity: {required},
            selectedZones: {
                hasZone() {
                    return this.formInput.selectedZones.length;
                }
            },
            agriculturalActivity: {
                required: requiredIf(function () {
                    return this.isInputRequired
                })
            },
            jobStatus: {
                required: requiredIf(function () {
                    return this.isInputRequired
                })
            },
            experienceFarming: {numeric},
            aboutProject: {
                minLength: minLength(5),
                maxLength: maxLength(1000),
                required: requiredIf(function () {
                    return this.isInputRequired
                })

            },
            aboutContent: {
                minLength: minLength(5),
                maxLength: maxLength(1000),
                required
            },
            title: {
                required,
                minLength: minLength(5)
            },
        }
    }

};
