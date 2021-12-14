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
        thread: '',
        adId: '',
        isUserAdvisorInCharge: Boolean,

    },
    data() {
        return {
            messages: [],
            activeThreadId: this.thread || null,
            initialLoading: true,
            messagesLoading: true,
            isSupportStageSelectOpen: false,
            isSupportStateSelectOpen: false,
            isProjectStatusSelectOpen: false,
            tabsOpen: {
                infoTabOpen: 'support-info-tab',
                supportTabOpen: 'support-thread-tab',
            },
            showModal: false,
            showUserBlockedValidationModal: false,
            noteToModify: '',
            noteToDelete: '',
            documents: [],
            uploading: false,
            userAdvisorInCharge: this.isUserAdvisorInCharge,
            isThreadRelatedToUser: this.isUserAdvisorInCharge,
        }
    },
    mounted() {
        if (this.thread) {
            setInterval(_ => this.refreshThread(this.activeThreadId), 15000);
            this.refreshThread(this.activeThreadId);
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
        showValidationModal(event) {
            this.showModal = true;
            this.isSupportStageSelectOpen = false;
            this.isSupportStateSelectOpen = false;
            this.isProjectStatusSelectOpen = false;
        },
        sendStatusChange(event) {
            event.target.form.submit()
            const chargement = document.createElement("p");
            chargement.innerText = "Chargement..";
            event.target.parentElement.replaceWith(chargement)
        },
        showDeleteNoteValidationModal(noteId) {
            this.showModal = true;
            this.noteToDelete = noteId;

        },
        closeValidationModal() {
            this.showModal = false;
            this.noteToDelete = '';
        },

        refreshThread(threadId) {
            fetch('/mon-espace/messagerie/' + threadId)
                .then(response => response.json())
                .then(results => {
                    this.messages = results.messages;
                    this.activeThreadId = threadId;
                    this.initialLoading = false;
                    this.messagesLoading = false;
                })
        },
        onMessageReplySuccess(message) {
            this.messages.push(message)
        },
        modifyNote(noteId) {
            this.noteToModify = noteId;
        },
        setUploading(bool) {
            this.uploading = bool;
        },
    },
    validations() {
        return {
            documents: {
                notCurrentlyUploading() {
                    return !this.uploading;
                }
            }
        }
    },

});
