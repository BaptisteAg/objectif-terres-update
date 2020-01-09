const formHandling = new Vue({
    el: '#form-new-ad',
    data: {
        ad_type_selected: '',
        land_seek_ads: {
            is_input_disabled: true,
            offer_genre: '',
            is_production_type_other: false,
        },
        land_offer_ads: {
            is_input_disabled: true,
            offer_genre: '',
            is_activity_transfer: false,
            is_production_type_other: false,
            is_production_type_wanted_other: false,
        },
        job_ads: {
            is_input_disabled: true,
            is_job_opportunity: false,
        }
    },
    watch: {
        ad_type_selected: function () {
            if (this.ad_type_selected === 'land_seek') {
                this.land_seek_ads.is_input_disabled = false;
            }
            if (this.ad_type_selected != 'land_seek') {
                this.land_seek_ads.is_input_disabled = true;
            }
            if (this.ad_type_selected === 'land_offer') {
                this.land_offer_ads.is_input_disabled = false;
            }
            if (this.ad_type_selected != 'land_offer') {
                this.land_offer_ads.is_input_disabled = true;
            }
            if (this.ad_type_selected === 'job_offer') {
                this.job_ads.is_input_disabled = false;
            } else {
                this.job_ads.is_input_disabled = true;
            }

        },
    }

})