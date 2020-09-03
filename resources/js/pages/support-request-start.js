import Vue from 'vue'

import TextAreaCounter from "../components/TextAreaCounter";

Vue.component('support-request-start', {
    components: {
        TextAreaCounter
    },
    props: {
        textRegions: {}
    },
    data() {
        return {
            region: '',
            textRegionsContent: this.textRegions,
        }
    },

});

