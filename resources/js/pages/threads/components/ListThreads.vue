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
            <ul class="menu-list" v-if="isUserLoggedAdOwner">
                <li v-for="thread in threads">
                    <template v-if="thread.users[0].id !== userId">
                        <a @click="onThreadClick(thread.id)"><span>{{thread.users[0].first_name}} {{thread.users[0].name}}</span></a>
                    </template>
                    <template v-else>
                        <a @click="onThreadClick(thread.id)"><span>{{thread.users[1].first_name}} {{thread.users[1].name}}</span></a>
                    </template>
                </li>
            </ul>

            <ul class="menu-list" v-else>
                <li v-for="thread in threads">
                    <a @click="onThreadClick(thread.id)"><span>{{thread.title}}</span></a>
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
