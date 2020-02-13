<template>
    <aside class="menu">
        <p class="menu-label">
            Vos discussions
        </p>
        <ul class="menu-list">
            <li v-for="thread in threads">
                <template v-if="thread.title !== null">
                    <a><span @click="onThreadClick(thread.id)">{{thread.title}}</span></a>
                </template>
                <template v-else>
                    <a><span @click="onThreadClick(thread.id)">{{thread.ad.about_content}}</span></a>
                </template>

            </li>
        </ul>
    </aside>
</template>

<script>
    export default {
        props: {
            threads: '',
        },
        data() {
            return {}
        },
        methods: {
            setTitle() {

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

            },
            onThreadClick(threadId) {
                this.$emit('on-thread-click', threadId)

            }
        },
        mounted: function () {

        }
    }
</script>
