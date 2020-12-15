import Vue from 'vue'
import HeaderMessage from "./components/HeaderMessage";
import DisplayMessageContent from "./components/DisplayMessageContent";
import FormMessageReply from "./components/FormMessageReply";
import ListThreads from "./components/ListThreads";
import MultiSelect from "../../components/MultiSelect";

Vue.component('vue-threads', {
    components: {
        ListThreads,
        HeaderMessage,
        DisplayMessageContent,
        FormMessageReply,
        MultiSelect
    },
    props: {
        initThread: '',
        isDisplayInThreadPage: Boolean,
        isUserAdOwner: Boolean,
        userRole: '',
        userId: "",
    },
    data() {
        return {
            messages: [],
            activeThreadId: this.initThread || null,
            activeThread: {},
            initialLoading: true,
            messagesLoading: true,
            isDisplay: this.isDisplayInThreadPage,
            isUserLoggedAdOwner: this.isUserLoggedAdOwner,
            usersSelected: [],
            isThreadRelatedToUser: false,
            isThreadBlocked: false
        }
    },
    watch: {
        activeThread: function () {
            let ad = this.activeThread.ad
            if (ad !== null) {
                if (ad.deleted_at !== null) {
                    return this.isThreadBlocked = true
                }
            }
            return this.isThreadBlocked = false
        }
    },
    mounted() {
        if (this.initThread) {
            setInterval(_ => this.onThreadClick(this.activeThreadId), 25000);
            this.onThreadClick(this.activeThreadId);
        }
    },
    methods: {
        onThreadClick(threadId) {
            fetch('/mon-espace/messagerie/' + threadId)
                .then(response => response.json())
                .then((results) => {
                    this.messages = results.messages;
                    this.activeThreadId = results.thread.id;
                    this.activeThread = results.thread;
                    this.initialLoading = false;
                    this.messagesLoading = false;
                    this.checkUserRelatedToThread(this.messages)
                })

        },
        onMessageReplySuccess(message) {
            this.messages.push(message)
        },

        onNewThreadClick() {
            this.$refs.newMessageModal.classList.add('is-active')
        },

        checkUserRelatedToThread(messages) {
            if (messages[0]) {
                messages[0].thread.users.some((user) => {
                    if (user.id === this.userId) {
                        return this.isThreadRelatedToUser = true;
                    }
                    return this.isThreadRelatedToUser = false;
                });
            }
        }
    },
});