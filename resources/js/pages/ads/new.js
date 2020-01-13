import { required, minLength, between } from 'vuelidate/lib/validators'
const NewAd = new Vue({
    el: '#form-new-ad',
    data: {
        adTypeSelected: '',
        landSeekAd: {
            isInputDisabled: true,
            offerGenre: '',
            isProductionGenreOther: false,
            zipCode : "",
            regions:"",
            departments:""

        },
        landOfferAd: {
            isInputDisabled: true,
            isActivityTransfer: false,
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
    },
    validations : {
        landSeekAd : {
            installationType : {
                required,
            },
            zipCode : {
                minLength : minLength(5),
                required,
            },


        },
        validationGroup : ['landSeekAd.installationType', 'landSeekAd.zipCode', ]
    },

});