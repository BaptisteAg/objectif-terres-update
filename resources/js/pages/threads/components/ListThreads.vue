<template>
    <div>
        <div class="content" v-if="isDisplay">
            <template v-if="numberThreadsUnreadMessages <=1">
                <p>{{numberThreadsUnreadMessages}} discussion non lue</p>
            </template>
            <template v-else>
                <p>{{numberThreadsUnreadMessages}} discussions non lues</p>
            </template>
            <button v-if="isUserTdlMember" @click="onNewThreadClick" class="open-modal-new-message button primary basic"
                    type="button">
                <span class="icon is-small">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </span>
                <span> Créer une discussion</span>
            </button>
        </div>
        <aside class="menu">
            <p class="menu-label" v-if="isDisplay">
                Vos discussions
            </p>
            <p class="menu-label" v-else>
                Fils de discussion concernant cette annonce
            </p>
            <ul class="menu-list">
                <li v-for="thread in threads">
                    <template v-if="isDisplay">
                        <template v-if="thread.users.length >2">
                            <a @click="onThreadClick(thread.id)">
                                <template v-for="threadUnreadMessages in threadsUnreadMessages">
                                    <span v-if="threadUnreadMessages.id === thread.id "
                                          class="icon text_danger">
                                        <i class="fas fa-circle has-"></i>
                                    </span>
                                </template>
                                <span class="icon">
                                    <i class="fas fa-users"></i>
                                </span>
                                <span>{{thread.title}}</span></a>
                        </template>
                        <template v-else-if="thread.ad_id !== null">
                            <template v-if="thread.ad.user_pp_id === userId">
                                <a @click="onThreadClick(thread.id)">
                                    <template v-for="threadUnreadMessages in threadsUnreadMessages">
                                        <span v-if="threadUnreadMessages.id === thread.id "
                                              class="icon text_danger">
                                            <i class="fas fa-circle has-"></i>
                                        </span>
                                    </template>
                                    <span class="icon">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <span>{{thread.title}}</span>
                                    <span class="text_size small">{{thread.ad.title}}</span>
                                </a>
                            </template>
                            <template v-else>
                                <a @click="onThreadClick(thread.id)">
                                    <template v-for="threadUnreadMessages in threadsUnreadMessages">
                                        <span v-if="threadUnreadMessages.id === thread.id "
                                              class="icon text_danger">
                                            <i class="fas fa-circle"></i>
                                        </span>
                                    </template>
                                    <span class="icon">
                                        <i class="far fa-newspaper"></i>
                                    </span>
                                    <template v-if="thread.ad.deleted_at !== null">
                                        Annonce supprimée
                                    </template>
                                    <template v-else>
                                        <span>{{thread.title}}</span>
                                    </template>
                                    <br>
                                </a>
                            </template>
                        </template>
                        <template v-else>
                            <a @click="onThreadClick(thread.id)">
                                <template v-for="threadUnreadMessages in threadsUnreadMessages">
                                    <span v-if="threadUnreadMessages.id === thread.id"
                                          class="icon text_danger">
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
                        <template v-if="isUserTdlMember">
                            <a @click="onThreadClick(thread.id)">
                                <template v-for="threadUnreadMessages in threadsUnreadMessages">
                                    <span v-if="threadUnreadMessages.id === thread.id "
                                          class="icon text_danger">
                                        <i class="fas fa-circle "></i>
                                    </span>
                                </template>
                                <span class="icon">
                                    <i class="fas fa-user"></i>
                                </span>
                                <span>{{thread.title}}</span>
                            </a>
                        </template>
                        <template v-else>
                            <a @click="onThreadClick(thread.id)">
                                <template v-for="threadUnreadMessages in threadsUnreadMessages">
                                    <span v-if="threadUnreadMessages.id === thread.id "
                                          class="icon text_danger">
                                        <i class="fas fa-circle has-"></i>
                                    </span>
                                </template>
                                <span class="icon">
                                    <i class="fas fa-newspaper"></i>
                                </span>
                                <span>{{thread.title}}</span>
                            </a>
                        </template>

                    </template>
                </li>
            </ul>
        </aside>
    </div>

</template>

<script>
    import axios from 'axios'

    export default {
        props: {
            threads: '',
            numberOfThreadsWithUnreadMessages: '',
            threadsWithUnreadMessages: '',
            isDisplay: Boolean,
            userId: {},
            userRole: '',
        },
        data() {
            return {
                numberThreadsUnreadMessages: this.numberOfThreadsWithUnreadMessages,
                threadsUnreadMessages: this.threadsWithUnreadMessages,
                isUserTdlMember : this.userRole >=1,
            }
        },
        methods: {
            onThreadClick(threadId) {
                this.$emit('on-thread-click', threadId);
                axios.get('/mon-espace/messagerie/actualisation')
                    .then(response => (
                        this.threadsUnreadMessages = response.data,
                            this.numberThreadsUnreadMessages = response.data.length
                    ))
            },
            onNewThreadClick() {
                this.$emit('on-new-thread-click')
            }

        },

    }
</script>
