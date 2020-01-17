import FormNewAdMixin from "./mixins/form-new-ad-mixin";
import FormValidationMixin from '../components/mixins/form-new-ad-validation-mixin';
import {required, maxLength, numeric, minLength, sameAs} from 'vuelidate/lib/validators'
import TextAreaCounter from "../../../components/TextAreaCounter";
export default {
    components: {
        TextAreaCounter
    },
    mixins: [FormNewAdMixin, FormValidationMixin],
    props: {
    },
    data() {
        const v = this.oldValues;
        const hasOld = Object.keys(v).length;

        return {
            isActivityTransfer: hasOld ? v.is_activity_transfer : false,
            isProductionGenreOther: hasOld ? v.other_production_genre :  false,
            isProductionGenreWantedOther: hasOld ? v.production_genre_wanted : false,
            isInputRequired: false,
            formInput : {
                isBeneficiary : hasOld ? v.is_beneficiary : '',
                zipCode :  hasOld ? v.zipCode : '',
                surfaceRange :hasOld ? v.surface_range : [],
                productionGenreWanted: [],
                altitude : hasOld ? v.altitude : '',
                bioCertification : hasOld ? v.bioCertification: [],
                confirmPriceFermage : hasOld ? v.confirm_price_fermage : false,
                chartConfirmation : hasOld ? v.chart_confirmation : false ,
                title : '',

            }
        }
    },
    validations : {
        isActivityTransfer : {required},
        formInput : {
            isBeneficiary : {required},
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
            confirmPriceFermage : {
                required,
                sameAs: sameAs( () => true ) },
            chartConfirmation : {
                required,
                sameAs: sameAs( () => true ) },
            title : {
                required,
                minLength: minLength(5)
            }
        }
    }
};