import Vue from 'vue'
import HeaderMessage from "./components/HeaderMessage";
import DisplayMessageContent from "./components/DisplayMessageContent";
import FormMessageReply from "./components/FormMessageReply";
import ListThreads from "./components/ListThreads";

Vue.component('vue-threads',{
    components :{
        ListThreads,
        HeaderMessage,
        DisplayMessageContent,
        FormMessageReply
    },
    props: {
        initThread : '',
        isDisplayInThreadPage : Boolean,
        isUserAdOwner : Boolean

    },
    data() {
        return {
            messages : [],
            activeThread: this.initThread || null,
            initialLoading : true,
            messagesLoading : true,
            isDisplay : this.isDisplayInThreadPage,
            isUserLoggedAdOwner : this.isUserLoggedAdOwner,
        }
    },
    mounted(){
        if(this.initThread) {
            setInterval(_ => this.onThreadClick(this.activeThread), 15000);
            this.onThreadClick(this.activeThread);

        }
    },
    methods : {
        onThreadClick(threadId) {
            this.messagesLoading = true;
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
        }
    },
});