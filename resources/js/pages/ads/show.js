import Vue from 'vue'
import ModerationModal from "./components/ModerationModal";
import OSMapControllerFactory from "../../map";

Vue.component('vue-moderation-modal', {
    components: {
        ModerationModal
    },
    props: {
        refusalTypes: '',
        responseTemplates: '',
        adId: '',
        attributionAdId :'',
    },
    data() {
        return {
            showModal: false,
            moderationChoice: '',
            selectOptions: {},
            formUrl: '',
            adIdShow: this.adId,
            attributionAd: this.attributionAdId,
        }
    },

    methods: {
        showModerationModal(e) {
            if (e !== false) {
                this.showModal = true
                if (e === "acceptAd") {
                    this.moderationChoice = e;
                    this.selectOptions = this.responseTemplates;
                    this.formUrl = "/mon-espace-moderateur/validation";
                } else if (e === 'modifyAd') {
                    this.moderationChoice = e;
                    this.selectOptions = this.responseTemplates;
                    this.formUrl = "/mon-espace-moderateur/modification";
                } else {
                    this.moderationChoice = e;
                    this.selectOptions = this.refusalTypes;
                    this.formUrl = "/mon-espace-moderateur/refus"
                }
            } else {
                this.showModal = false
            }
        }
    }

});

window.showAdMapInit  = async function (id, locationsAd) {

    const mapController = await OSMapControllerFactory(id);

    const formData = new FormData();

    for (let location of locationsAd) {
        formData.append('names[]', location);
    }

    const locationPolygonData = await fetchJson('/locations/polygon/ad-locations', formData);

    let featureGroup = mapController.addFeatureGroup();

    locationPolygonData.forEach(polygonData => {
        const polygon = mapController.addPolygon(polygonData, {
            smoothFactor: 2
        });

        featureGroup.addLayer(polygon);

    })


    mapController.fitBounds(featureGroup.getBounds());
};