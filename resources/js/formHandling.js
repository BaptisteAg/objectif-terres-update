const formHandling = new Vue({
    el: '#form-new-ad',
    data: {
        ad_type_selected: '',
        land_seek_ads: {
            is_input_disabled: true,
            offer_genre: '',
            production_genre_selected : [],
            is_production_genre_other: false,
        },
        land_offer_ads: {
            is_input_disabled: true,
            is_activity_transfer: false,
            is_production_genre_other: false,
            is_production_genre_wanted_other: false,
            is_input_required : false
        },
        job_ads: {
            is_input_disabled: true,
            is_job_opportunity: false,
            is_input_required : false
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
        'job_ads.is_job_opportunity': function () {
            if (this.job_ads.is_job_opportunity === "1") {
                this.job_ads.is_input_required = true
            } else if (this.job_ads.is_job_opportunity === '0') {
                this.job_ads.is_input_required = false
            }
        }
    }

})