import Vue from 'vue';

Vue.component('support-request-dashboard', {
    props: {
        oldInputSelected: ''
    },
    data() {
        return {
            tabsOpen: {
                infoTabOpen: 'support-request-info-tab',
                supportTabOpen :'support-request-thread-tab',
            },
            showModal : false
        }
    },
    methods: {
        openInfoTab(tabName) {
           if(this.tabsOpen.infoTabOpen !== tabName){
               this.tabsOpen.infoTabOpen = tabName
           }
        },
        openSupportTab(tabName) {
            if(this.tabsOpen.supportTabOpen !== tabName){
                this.tabsOpen.supportTabOpen = tabName
            }
        },
        showValidationModal(){
            this.showModal = true;
        },
        closeValidationModal(){
            this.showModal = false;
        }
    },

});