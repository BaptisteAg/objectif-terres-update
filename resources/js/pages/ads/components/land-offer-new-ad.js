import FormNewAdMixin from "./mixins/form-new-ad-mixin";
import FormValidationMixin from '../components/mixins/form-new-ad-validation-mixin';
import {maxLength, minLength, numeric, required, sameAs} from 'vuelidate/lib/validators'
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
            formInput: {
                isBeneficiary: hasOld ? v.is_beneficiary : '',
                zipCode: hasOld ? v.zip_code : '',
                surface: hasOld ? v.surface : '',
                isActivityTransfer: hasOld ? !!v.is_activity_transfer : '',
                productionGenre: hasOld ? v.production_genre : [],
                productionGenreWanted: hasOld ? v.production_genre_wanter : [],
                altitude: hasOld ? v.altitude : '',
                bioCertification: hasOld ? v.bioCertification : [],
                confirmPriceFermage: hasOld ? !!v.confirm_price_fermage : false,
                aboutProject: hasOld ? v.about_project_content : '',
                aboutContent: hasOld ? v.about_content : '',
                title: '',
                chartConfirmation: false,
            }
        }
    },
    computed: {
        isProductionGenreOther() {
            return this.formInput.productionGenre.includes('other');
        },
        isProductionGenreWantedOther() {
            return this.formInput.productionGenreWanted.includes('other');
        }
    },
    validations: {
        formInput: {
            isBeneficiary: {required},
            zipCode: {
                required,
                numeric,
                minLength: minLength(5),
                maxLength: maxLength(5)
            },
            surface: {
                required,
                numeric
            },
            isActivityTransfer: {required},
            altitude: {
                required,
                numeric
            },
            bioCertification: {required},
            confirmPriceFermage: {
                checked(v) {return !!v}
            },
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
            chartConfirmation: {
                checked(v) {return !!v}
            },
            title: {
                required,
                minLength: minLength(5)
            }
        }
    }
};