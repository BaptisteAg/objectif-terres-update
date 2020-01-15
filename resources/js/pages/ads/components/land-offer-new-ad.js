import FormNewAdMixin from "./mixins/form-new-ad-mixin";
import FormValidationMixin from '../components/mixins/form-new-ad-validation-mixin';
import {required, maxLength, numeric, minLength} from 'vuelidate/lib/validators'
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
            isActivityTransfer: '',
            isProductionGenreOther: false,
            isProductionGenreWantedOther: false,
            isInputRequired: false,
            formInput : {
                beneficiary : '',
                zipCode : '',
                surfaceRange : [],
                productionGenreWanted: [],
                altitude : '',
                bioCertification : [],
                title : '',

            }
        }
    },
    validations : {
        isActivityTransfer : {required},
        formInput : {
            beneficiary : {required},
            zipCode : {
                required,
                numeric,
                minLength : minLength(5),
                maxLength : maxLength(5)
            },
            surfaceRange: {required},
            altitude:{
                required,
                numeric},
            bioCertification: {required},
            title : {
                required,
                minLength: minLength(5)
            }
        }
    }
};