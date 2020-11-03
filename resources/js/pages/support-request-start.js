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
            regionsAllowToUseService: [1, 3, 4, 12, 15, 16, 20, 21],
            showSubmitFormButton: false,
        }
    },
    watch: {
        region: function (val) {
            Object.keys(this.textRegions).forEach(key => {
                if (key.split('-')[6] === val) {
                    this.textRegionsContent = this.textRegions[key].content
                }
            });

            if (this.regionsAllowToUseService.includes(parseInt(val))) {
                this.showSubmitFormButton = true
            } else {
                this.showSubmitFormButton = false
            }
            ;
        }
    },
});

