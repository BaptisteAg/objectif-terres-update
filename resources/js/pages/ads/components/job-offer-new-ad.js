import FormNewAdMixin from "./mixins/form-new-ad-mixin";
import FormValidationMixin from '../components/mixins/form-new-ad-validation-mixin';
import {required, maxLength, numeric, minLength, requiredUnless, sameAs, requiredIf} from 'vuelidate/lib/validators'
import TextAreaCounter from "../../../components/TextAreaCounter";

export default {
    components: {
        TextAreaCounter
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
                zipCode: hasOld ? v.zipCode : '',
                city: hasOld ? v.city : '',
                agriculturalActivity: hasOld ? v.agricultural_activity : [],
                jobStatus: hasOld ? v.job_status : '',
                jobOpportunity: hasOld ? v.is_offer : '',
                experienceFarming: hasOld ? v.experience_farming : '',
                aboutProject: hasOld ? v.about_project_content : '',
                aboutContent: hasOld ? v.about_content : '',
                title: hasOld ? v.title : '',
            }
        }
    },
    watch: {
        jobOpportunity: function () {
            this.isInputRequired = this.isJobOpportunity === "1";
        }
    },
    validations: {
        formInput: {
            beneficiary: {required},
            jobOpportunity: {required},
            zipCode: {
                numeric,
                minLength: minLength(5),
                maxLength: maxLength(5),
                required: requiredIf(function () {
                    return this.isInputRequired
                })
            },
            city: {
                required: requiredIf(function () {
                    return this.isInputRequired
                })
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
                required
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