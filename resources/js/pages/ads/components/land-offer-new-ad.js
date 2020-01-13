import FormNewAdMixin from "./mixins/form-new-ad-mixin";

export default {
    mixins: [FormNewAdMixin],
    props: {
    },
    data() {
        return {
            is_activity_transfer: false,
            isProductionGenreOther: false,
            isProductionGenreWantedOther: false,
            isInputRequired: false
        }
    }
};