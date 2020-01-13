import FormNewAdMixin from './mixins/form-new-ad-mixin'


export default Vue.extend({
    mixins: [FormNewAdMixin],
    props: {
    },
    data() {
        return {
            offerGenre: this.oldValues.offer_genre,
            isProductionGenreOther: false,
        }
    }
});