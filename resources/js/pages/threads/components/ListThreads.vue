<template>
    <div>
        <div class="content" v-if="isDisplay">
            <template v-if="numberThreadsUnreadMessages <=1">
                <p>{{numberThreadsUnreadMessages}} discussion non lu</p>
            </template>
            <template v-else>
                <p>{{numberThreadsUnreadMessages}} discussions non lus</p>
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
                                    <span v-if="threadUnreadMessages.id === thread.id "
                                          class="icon has-text-danger">
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
                                <template v-if="thread.users[0].id !== userId">
                                    <a @click="onThreadClick(thread.id)">
                                        <template v-for="threadUnreadMessages in threadsUnreadMessages">
                                            <span v-if="threadUnreadMessages.id === thread.id "
                                                  class="icon has-text-danger">
                                            <i class="fas fa-circle has-"></i>
                                            </span>
                                        </template>
                                        <span class="icon">
                                             <i class="fas fa-user"></i>
                                         </span>
                                        <span>{{thread.users[0].first_name}} {{thread.users[0].name}}
                                        </span>
                                    </a>
                                </template>
                                <template v-else>
                                    <a @click="onThreadClick(thread.id)">
                                        <template v-for="threadUnreadMessages in threadsUnreadMessages">
                                            <span v-if="threadUnreadMessages.id === thread.id "
                                                  class="icon has-text-danger">
                                            <i class="fas fa-circle has-"></i>
                                            </span>
                                        </template>
                                        <span class="icon">
                                             <i class="fas fa-user"></i>
                                         </span>
                                        <span>{{thread.users[1].first_name}} {{thread.users[1].name}}
                                        </span>
                                    </a>
                                </template>
                            </template>

                            <template v-else>
                                <a @click="onThreadClick(thread.id)">
                                    <template v-for="threadUnreadMessages in threadsUnreadMessages">
                                    <span v-if="threadUnreadMessages.id === thread.id "
                                          class="icon has-text-danger">
                                    <i class="fas fa-circle"></i>
                                    </span>
                                    </template>
                                    <span class="icon">
                            <i class="far fa-newspaper"></i>
                            </span>
                                    <span>{{thread.title}}</span>
                                </a>
                            </template>

                        </template>
                        <template v-else>
                            <a @click="onThreadClick(thread.id)">
                                <template v-for="threadUnreadMessages in threadsUnreadMessages">
                                    <span v-if="threadUnreadMessages.id === thread.id"
                                          class="icon has-text-danger">
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
                            <a @click="onThreadClick(thread.id)">
                                <template v-for="threadUnreadMessages in threadsUnreadMessages">
                                            <span v-if="threadUnreadMessages.id === thread.id "
                                                  class="icon has-text-danger">
                                            <i class="fas fa-circle has-"></i>
                                            </span>
                                </template>
                                <span class="icon">
                                             <i class="fas fa-user"></i>
                                         </span>
                                <span>{{thread.users[0].first_name}} {{thread.users[0].name}}
                                        </span>
                            </a>
                        </template>
                        <template v-else>
                            <a @click="onThreadClick(thread.id)">
                                <template v-for="threadUnreadMessages in threadsUnreadMessages">
                                            <span v-if="threadUnreadMessages.id === thread.id "
                                                  class="icon has-text-danger">
                                            <i class="fas fa-circle has-"></i>
                                            </span>
                                </template>
                                <span class="icon">
                                             <i class="fas fa-user"></i>
                                         </span>
                                <span>{{thread.users[1].first_name}} {{thread.users[1].name}}
                                        </span>
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
            isUserModerator: Boolean
        },
        data() {
            return {
                numberThreadsUnreadMessages: this.numberOfThreadsWithUnreadMessages,
                threadsUnreadMessages: this.threadsWithUnreadMessages
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
