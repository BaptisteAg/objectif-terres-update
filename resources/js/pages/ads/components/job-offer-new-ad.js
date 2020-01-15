import FormNewAdMixin from "./mixins/form-new-ad-mixin";
import FormValidationMixin from '../components/mixins/form-new-ad-validation-mixin';
import {required, maxLength, numeric, minLength, requiredIf} from 'vuelidate/lib/validators'
import TextAreaCounter from "../../../components/TextAreaCounter";

export default {
    components: {
        TextAreaCounter
    },
    mixins: [FormNewAdMixin, FormValidationMixin],
    props: {
    },
    data() {
        return {
            isJobOpportunity: false,
            isInputRequired: false,
            formInput : {
                beneficiary : '',
                zipCode : '',
                jobOpportunity : '',
                experienceFarming : '',
                aboutProject:'',
                aboutContent : '',
                title : '',
            }
        }
    },
    watch: {
        isJobOpportunity: function () {
            this.isInputRequired = this.isJobOpportunity === "1";
        }
    },
    validations : {
        formInput : {
            beneficiary: {required},
            jobOpportunity : {required},
            zipCode : {
                numeric,
                minLength : minLength(5),
                maxLength : maxLength(5),
                required : requiredIf(function(){
                    return !this.isInputRequired
                })
            },
            experienceFarming : {numeric},
            title : {
                required,
                minLength: minLength(5)
            }

        }
    }

};