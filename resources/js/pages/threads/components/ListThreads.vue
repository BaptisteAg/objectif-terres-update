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
                    <template v-if="isDisplay">
                        <template v-if="thread.users.length >2">
                            <a @click="onThreadClick(thread.id)">
                                <template v-for="threadUnreadMessages in threadsUnreadMessages">
                                    <span v-if="threadUnreadMessages.id === thread.id" class="icon has-text-danger">
                                    <i class="fas fa-circle has-"></i>
                                    </span>
                                </template>
                                <span class="icon">
                             <i class="fas fa-users"></i>
                            </span>
                                <span>{{thread.title}}</span></a>
                        </template>
                        <template v-else-if="thread.ad_id !== null">
                            <a @click="onThreadClick(thread.id)">
                                <template v-for="threadUnreadMessages in threadsUnreadMessages">
                                    <span v-if="threadUnreadMessages.id === thread.id" class="icon has-text-danger">
                                    <i class="fas fa-circle"></i>
                                    </span>
                                </template>
                                <span class="icon">
                            <i class="far fa-newspaper"></i>
                            </span>
                                <span>{{thread.title}}</span></a>
                        </template>
                        <template v-else>
                            <a @click="onThreadClick(thread.id)">
                                <template v-for="threadUnreadMessages in threadsUnreadMessages">
                                    <span v-if="threadUnreadMessages.id === thread.id" class="icon has-text-danger">
                                    <i class="fas fa-circle"></i>
                                    </span>
                                </template>
                                <span class="icon">
                            <i class="fas fa-user"></i>
                            </span>
                                <span>{{thread.title}}</span></a>
                        </template>
                    </template>
                    <template v-else>
                        <template v-if="thread.users[0].id !== userId">
                            <a><span @click="onThreadClick(thread.id)">{{thread.users[0].first_name}} {{thread.users[0].name}}</span></a>
                        </template>
                        <template v-else>
                            <a><span @click="onThreadClick(thread.id)">{{thread.users[1].first_name}} {{thread.users[1].name}}</span></a>
                        </template>
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
            threadsWithUnreadMessages: '',
            isDisplay: Boolean,
            userId: {},
            isUserModerator: Boolean
        },
        data() {
            return {
                numberUnreadMessages: this.numberOfUnreadMessages,
                threadsUnreadMessages: this.threadsWithUnreadMessages
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
