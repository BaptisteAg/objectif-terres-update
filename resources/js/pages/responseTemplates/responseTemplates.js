import Vue from 'vue';

Vue.component('response-template-page', {
    data() {
        return {
            showModal: false,
            responseTemplateToModify: '',
            responseTemplateToDelete: '',
        }
    },
    methods: {
        showValidationModal(ResponseTemplateId) {
            this.responseTemplateToDelete = ResponseTemplateId;
            this.showModal = true;
        },
        closeValidationModal() {
            this.showModal = false;
            this.responseTemplateToDelete = '';
        },
        modifyResponseTemplate(responseTemplateId) {
            this.responseTemplateToModify = responseTemplateId;
        },

    }
});