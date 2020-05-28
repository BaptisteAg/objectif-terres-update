import Vue from 'vue'
import HeaderMessage from "./components/HeaderMessage";
import DisplayMessageContent from "./components/DisplayMessageContent";
import FormMessageReply from "./components/FormMessageReply";
import ListThreads from "./components/ListThreads";
import MultiSelect from "../../components/MultiSelect";

Vue.component('vue-threads',{
    components :{
        ListThreads,
        HeaderMessage,
        DisplayMessageContent,
        FormMessageReply,
        MultiSelect
    },
    props: {
        initThread : '',
        isDisplayInThreadPage : Boolean,
        isUserAdOwner : Boolean,
        userRole : '',
    },
    data() {
        return {
            messages : [],
            activeThread: this.initThread || null,
            initialLoading : true,
            messagesLoading : true,
            isDisplay : this.isDisplayInThreadPage,
            isUserLoggedAdOwner : this.isUserLoggedAdOwner,
            isUserModerator: false,
            usersSelected : []
        }
    },
    mounted(){
        if(this.initThread) {
            setInterval(_ => this.onThreadClick(this.activeThread), 15000);
            this.onThreadClick(this.activeThread);

            if(this.userRole >=1){
                this.isUserModerator = true;
            }
        }
    },
    methods : {
        onThreadClick(threadId) {
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

        onNewThreadClick(){
            this.$refs.newMessageModal.classList.add('is-active')
        }
    },
});