import FormNewAdMixin from "./mixins/form-new-ad-mixin";

export default {
    mixins: [FormNewAdMixin],
    props: {
    },
    data() {
        return {
            isJobOpportunity: false,
            isInputRequired: false
        }
    },
    watch: {
        isJobOpportunity: function () {
            this.jobAd.isInputRequired = this.jobAd.isJobOpportunity === "1";
        }
    }
};