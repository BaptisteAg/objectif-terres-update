import Vue from 'vue';
import DisplayMessageContent from "../threads/components/DisplayMessageContent";
import FormMessageReply from "../threads/components/FormMessageReply";
import DocumentsUpload from "../../components/DocumentsUpload";
import axios from "axios";

Vue.component('support-request-dashboard', {
    components: {
        DisplayMessageContent,
        FormMessageReply,
        DocumentsUpload,
    },
    props: {
        thread: '',
        adId : '',
    },
    data() {
        return {
            messages : [],
            activeThread: this.thread || null,
            initialLoading : true,
            messagesLoading : true,
            tabsOpen: {
                infoTabOpen: 'support-info-tab',
                supportTabOpen: 'support-notes-tab',
            },
            showModal: false,
            projectDataKeyId : '',
            notes : [],
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
        getAllNotesByProjectDataKey(e) {
            this.isLoading = true;
            axios.post('/mon-espace-primo-accueillant/liste-notes-indicateurs', {
                ad_id: this.adId,
                project_data_key_id:this.projectDataKeyId
            })
                .then(response => {
                    console.log(response.data)
                     this.notes = response.data;
                     this.isLoading = false;
                })
                .catch(error => {
                    console.log(error)
                })
        }
    },

});