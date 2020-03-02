import Vue from 'vue'
import ModerationModal from "./components/ModerationModal";


Vue.component('vue-moderation-modal', {
    components: {
        ModerationModal
    },
    props: {
        refusalTypes: '',
        responseTemplates: '',
        attributionAd: ''
    },
    data() {
        return {
            showModal: false,
            moderationChoice: '',
            selectOptions: {},
            formUrl: '',
            attributionAdId: this.attributionAd,
        }
    },

    methods: {
        showModerationModal(e) {
            if (e !== false) {
                this.showModal = true
                if (e === "acceptAd") {
                    this.moderationChoice = e;
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