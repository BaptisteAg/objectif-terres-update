import Vue from 'vue';

Vue.component('response-template-page',{
    data(){
        return{
            showModal: false,
            responseTemplateToModify: '',
        }
    },
    methods:{
        showValidationModal() {
            console.log('oui')
            this.showModal = true;
        },
        closeValidationModal() {
            this.showModal = false;
        },
        modifyResponseTemplate(responseTemplateId) {
            this.responseTemplateToModify = responseTemplateId;
        },
    }
});