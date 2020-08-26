import Vue from 'vue'

import TextAreaCounter from "../components/TextAreaCounter";

Vue.component('support-request-start', {
    components: {
        TextAreaCounter
    },
    data: () => {
        return {
            region: ''
        }
    }
});

