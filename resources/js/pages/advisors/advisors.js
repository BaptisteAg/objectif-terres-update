import Vue from 'vue';
import DisplayMessageContent from "../threads/components/DisplayMessageContent";
import FormMessageReply from "../threads/components/FormMessageReply";
import DocumentsUpload from "../../components/DocumentsUpload";

Vue.component('support-request-dashboard', {
    components: {
        DisplayMessageContent,
        FormMessageReply,
        DocumentsUpload,
    },
    props: {
        oldInputSelected: '',
        thread: '',
    },
    data() {
        return {
            messages : [],
            activeThread: this.thread || null,
            initialLoading : true,
            messagesLoading : true,
            tabsOpen: {
                infoTabOpen: 'support-request-info-tab',
                supportTabOpen: 'support-request-thread-tab',
            },
            showModal: false,
        }
    },
    mounted() {
        if (this.thread) {
            setInterval(_ => this.refreshThread(this.activeThread), 15000);
            this.refreshThread(this.activeThread);
        }
    },
    methods: {
        openInfoTab(tabName) {
            if (this.tabsOpen.infoTabOpen !== tabName) {
                this.tabsOpen.infoTabOpen = tabName
            }
        },
        openSupportTab(tabName) {
            if (this.tabsOpen.supportTabOpen !== tabName) {
                this.tabsOpen.supportTabOpen = tabName
            }
        },
        showValidationModal() {
            this.showModal = true;
        },
        closeValidationModal() {
            this.showModal = false;
        },
        refreshThread(threadId) {
            fetch('/mon-espace/messagerie/' + threadId)
                .then(response => response.json())
                .then(results => {
                    this.messages = results;
                    this.activeThread = threadId;
                    this.initialLoading = false;
                    this.messagesLoading = false;
                })
        },
        onMessageReplySuccess(message) {
            this.messages.push(message)
        },
    },

});