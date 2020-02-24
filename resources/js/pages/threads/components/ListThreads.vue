<template>
    <div>
        <div class="content" v-if="isDisplay">
            <template v-if="numberUnreadMessages <=1">
                <p>{{numberUnreadMessages}} message non lus</p>
            </template>
            <template v-else>
                <p>{{numberUnreadMessages}} messages non lus</p>
            </template>
            <button v-if="isUserModerator" @click="onNewThreadClick" class="open-modal-new-message button is-link"
                    type="button">
								 <span class="icon is-small">
								<i class="fa fa-plus" aria-hidden="true"></i>
								</span>
                <span> Créer une nouvelle discussion</span>
            </button>
        </div>
        <aside class="menu">
            <p class="menu-label" v-if="isDisplay">
                Vos discussions
            </p>
            <p class="menu-label" v-else>
                Vos fils de discussion concernant cette annonce
            </p>
            <ul class="menu-list">
                <li v-for="thread in threads">
                    <template v-if="thread.users.length >2">
                        <a @click="onThreadClick(thread.id)">
                            <span class="icon">
                             <i class="fas fa-users"></i>
                            </span>
                            <span>{{thread.title}}</span></a>
                    </template>
                    <template v-else-if="thread.ad_id !== null">
                        <a @click="onThreadClick(thread.id)">
                            <span class="icon">
                            <i class="far fa-newspaper"></i>
                            </span>
                            <span>{{thread.title}}</span></a>
                    </template>
                    <template v-else>
                        <a @click="onThreadClick(thread.id)">
                            <span class="icon">
                            <i class="fas fa-user"></i>
                            </span>
                            <span>{{thread.title}}</span></a>
                    </template>
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
            isDisplay: Boolean,
            isUserLoggedAdOwner: Boolean,
            userId: {},
            isUserModerator: Boolean
        },
        data() {
            return {
                numberUnreadMessages: this.numberOfUnreadMessages
            }
        },
        methods: {
            onThreadClick(threadId) {
                this.$emit('on-thread-click', threadId)
            },
            onNewThreadClick() {
                this.$emit('on-new-thread-click')
            }

        },

    }
</script>
