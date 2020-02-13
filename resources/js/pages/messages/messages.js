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
    data() {
        return {
            messages : []
        }
    },
    methods : {
        onThreadClick(threadId) {
            fetch('/mon-espace/messagerie/' + threadId)
                .then(response => response.json())
                .then(messages => this.messages = messages)
        }
    }
});
