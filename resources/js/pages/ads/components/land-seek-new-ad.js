import FormNewAdMixin from './mixins/form-new-ad-mixin'
import Autocomplete from '../../../components/Autocomplete'

export default Vue.extend({
    mixins: [FormNewAdMixin],
    components: {
        Autocomplete
    },
    props: {
    },
    data() {
        return {
            offerGenre: this.oldValues.offer_genre,
            isProductionGenreOther: false,
        }
    }
});