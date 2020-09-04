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
            textRegionsContent: '',
        }
    },
    watch: {
        region: function (val) {
            Object.keys(this.textRegions).forEach(key => {
                if (key.split('-')[6] === val) {
                    this.textRegionsContent = this.textRegions[key].content
                }
            });
        }
    },
});

