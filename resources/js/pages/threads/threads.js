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
    },
    data() {
        return {
            messages : [],
            activeThread: this.initThread || null,
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
            fetch('/mon-espace/messagerie/' + threadId)
                .then(response => response.json())
                .then(results => {
                    this.messages = results;
                    this.activeThread = threadId;
                })
        },
        onMessageReplySuccess(message) {
            this.messages.push(message)
        }
    },
});