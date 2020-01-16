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
            isJobOpportunity: hasOld ? v.is_offer : false,
            isInputRequired: false,
            formInput: {
                beneficiary: hasOld ? v.is_beneficiary : '',
                zipCode: hasOld ? v.zipCode : '',
                jobOpportunity: hasOld ? v.is_offer : '',
                experienceFarming: hasOld ? v.experience_farming : '',
                aboutProject: hasOld ? v.about_project : '',
                aboutContent: hasOld ? v.about_content : '',
                title: hasOld ? v.title : '',
            }
        }
    },
    watch: {
        isJobOpportunity: function () {
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
                required : requiredIf(function () {
                    return this.isInputRequired
                })

            },
            experienceFarming: {numeric},
            title: {
                required,
                minLength: minLength(5)
            }

        }
    }

};