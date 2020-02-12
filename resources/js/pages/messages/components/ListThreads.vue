<template>
    <aside class="menu">
        <p class="menu-label">
           Vos discussions
        </p>
        <ul class="menu-list">
            <li v-for="datas in menuData">
                <a>
                    <span v-for="data in datas">
                    <span v-if='data.threadTitle !== null'>
                        <span>{{data.threadTitle}}</span>
                        </span>
                    <span v-else>
                        <span>{{data.user.first_name}} <strong>{{data.user.name}} </strong></span>
                    </span>
                    </span>

                </a>
            </li>
        </ul>
    </aside>
</template>

<script>
    export default {
        props: {
            threads: Object,
        },
        data() {
            return {
                menuData: [],

            }
        },
        methods: {
            getInterlocutors() {
                for (let [key, thread] of Object.entries(this.threads)) {
                    let interlocutorsInThread = [];
                    thread.forEach(message => {
                        if (message.receiver_user_id !== 21) {
                            interlocutorsInThread.push({
                                threadId: message.thread_id,
                                threadTitle: message.thread.title,
                                user: message.receiver_user
                            });

                        } else if (message.sender_user_id !== 21) {
                            interlocutorsInThread.push({
                                threadId: message.thread_id,
                                threadTitle: message.thread.title,
                                user: message.sender_user
                            });

                        }
                        let valueArr = interlocutorsInThread.map(function (item) {
                            return item.user.id
                        });
                        valueArr.some(function (item, idx) {
                            if (valueArr.indexOf(item) !== idx) {
                                interlocutorsInThread.splice(valueArr.indexOf(item), 1);
                            }
                        })

                    })
                    this.menuData.push(interlocutorsInThread);
                }


                // Object.keys(this.threads).forEach(key => {
                //     let thread = this.threads[key]
                //     thread.forEach(message => {
                //
                //
                //         if (message.receiver_user_id !== 21) {
                //             // this.interlocutors[key] = message.receiver_user
                //
                //             this.interlocutors[key] = {value : message.receiver_user} ;
                //             // this.interlocutors.push(message.receiver_user)
                //
                //         } else if (message.sender_user_id !== 21) {
                //             // this.interlocutors[key] = message.sender_user
                //             this.interlocutors[key] = {value : message.sender_user} ;
                //             // this.interlocutors.push(message.sender_user)
                //         }
                //
                //         // let valueArr = this.interlocutors.map(function(item){ return item.id });
                //         // let test = this.interlocutors;
                //         // let isDuplicate = valueArr.some(function(item, idx){
                //         //    if(valueArr.indexOf(item) !== idx){
                //         //        console.log(test)
                //         //        test.splice(valueArr.indexOf(item), 1);
                //         //    }
                //         // });
                //
                //     })
                // })

            }
        },
        mounted: function () {
            this.getInterlocutors()
        }
    }
</script>
