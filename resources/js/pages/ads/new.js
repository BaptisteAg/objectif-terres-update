import LandSeekNewAd from './components/land-seek-new-ad'
import LandOfferNewAd from './components/land-offer-new-ad'
import JobOfferNewAd from './components/job-offer-new-ad'

const NewAd = Vue.component('new-ad', {
    components: {
        'new-land-seek-ad' : LandSeekNewAd,
        'new-land-offer-ad' : LandOfferNewAd,
        'new-job-offer-ad' : JobOfferNewAd
    },
    props: {
        oldAdTypeSelected: String
    },
    data() {
        return {
            adTypeSelected: this.oldAdTypeSelected,
        }
    },
    mounted() {

    },
    methods: {

    },
    watch: {

    }
});