const NewAd = new Vue({
    el: '#form-new-ad',
    data: {
        adTypeSelected: '',
        landSeekAd: {
            isInputDisabled: true,
            offerGenre: '',
            isProductionGenreOther: false,
        },
        landOfferAd: {
            isInputDisabled: true,
            is_activity_transfer: false,
            isProductionGenreOther: false,
            isProductionGenreWantedOther: false,
            isInputRequired : false
        },
        jobAd: {
            isInputDisabled: true,
            isJobOpportunity: false,
            isInputRequired : false
        }
    },
    watch: {
        adTypeSelected: function () {
            this.landSeekAd.isInputDisabled = this.adTypeSelected !== 'land_seek';
            this.landOfferAd.isInputDisabled = this.adTypeSelected !== 'land_offer';
            this.jobAd.isInputDisabled = this.adTypeSelected !== 'job_offer';

        },
        'jobAd.isJobOpportunity': function () {
            this.jobAd.isInputRequired = this.jobAd.isJobOpportunity === "1";
        }
    }
});