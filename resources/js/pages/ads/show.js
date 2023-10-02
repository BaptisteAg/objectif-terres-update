import Vue from 'vue'
import AdHistoryModal from "./components/AdHistoryModal";
import ModerationModal from "./components/ModerationModal";
import OSMapControllerFactory from "../../map";

Vue.component('vue-moderation-modal', {
    components: {
        ModerationModal,
        AdHistoryModal,
    },
    props: {
        responseTemplates: '',
        adId: '',
        attributionAdId :'',
    },
    data() {
        return {
            showPreModal: false,
            showModal: false,
            moderationChoice: '',
            selectOptions: {},
            formUrl: '',
            adIdShow: this.adId,
            attributionAd: this.attributionAdId,
            historyModalOpen : false,
        }
    },
    created() {
        this.$root.$on('modifyAd', this.showModerationModal)
    },
    methods: {
        showModerationModal(e) {
            if (e !== false) {
                this.showModal = true
                this.moderationChoice = e;
                this.selectOptions = this.responseTemplates;
                if (e === "acceptAd") {
                    this.formUrl = "/gestion-des-annonces/validation";
                } else if (e === 'modifyAd') {
                    this.formUrl = "/gestion-des-annonces/modification";
                } else {
                    this.formUrl = "/gestion-des-annonces/refus"
                }
            } else {
                this.showModal = false
            }
        },
        showHistoryModal(){
            this.historyModalOpen = true;
        },
        showPreModerationModal(){
            this.showPreModal = true;
        }
    },

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
