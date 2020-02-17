<template>
    <div>
        <div class="content">
            <p>{{numberUnreadMessages}} message non lus</p>
        </div>
        <aside class="menu">
            <p class="menu-label">
                Vos discussions
            </p>
            <ul class="menu-list">
                <li v-for="thread in threads">
                    <a><span @click="onThreadClick(thread.id)">{{thread.title}}</span></a>
                </li>
            </ul>
        </aside>
    </div>

</template>

<script>
    export default {
        props: {
            threads: '',
            numberOfUnreadMessages: '',
        },
        data() {
            return {
                numberUnreadMessages : this.numberOfUnreadMessages
            }
        },
        methods: {
            onThreadClick(threadId) {
                this.$emit('on-thread-click', threadId)
            },
        },

    }
</script>
