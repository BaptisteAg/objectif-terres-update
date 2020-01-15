import FormNewAdMixin from './mixins/form-new-ad-mixin'
import FormValidationMixin from '../components/mixins/form-new-ad-validation-mixin';
import {required, maxLength, minLength} from 'vuelidate/lib/validators'
import TextAreaCounter from "../../../components/TextAreaCounter";

export default Vue.extend({
    components: {
        TextAreaCounter
    },
    mixins: [FormNewAdMixin, FormValidationMixin],
    props: {},
    data() {
        return {
            offerGenre: this.oldValues.offer_genre,
            isProductionGenreOther: false,
            formInput: {
                installationType: '',
                productionGenre: [],
                title: '',
            },
        }
    },
    validations: {
        formInput: {
            installationType: {required},
            productionGenre: {required},
            title: {
                required,
                minLength: minLength(5)
            }
        }

    }
});