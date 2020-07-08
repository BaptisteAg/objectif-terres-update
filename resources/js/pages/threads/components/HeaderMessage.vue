<template>
    <div>
        <template class="loader-wrapper" v-if="activeThread === null">
        </template>
        <div v-else class="content ">
            <div class="columns is-vcentered">
                <div class="column is-one-third"></div>
                <div class="column ">
                    <template v-if="activeThread.title">
                        <p class="has-text-centered  text-style-title__primary">{{activeThread.title}}</p>
                        <template v-for="(user, index) in activeThread.users">
                            <p class=" is-marginless subtitle is-6 has-text-centered has-text-grey"
                               v-if="user.id !==userId">
                                {{user.first_name}} {{user.name}}</p>
                        </template>
                    </template>
                    <template v-else>
                        <template v-for="(user, index) in activeThread.users">
                            <template v-if="user.deleted_at">
                                <p class="has-text-centered">Utilisateur supprimé</p>
                            </template>
                            <template v-else>
                                <template v-if="activeThread.ad && user.id !==userId ">
                                    <p class="has-text-centered  text-style-title__primary" v-if="user.id !==userId">
                                        {{user.first_name}} <span class="is-uppercase">{{user.name}}</span>
                                    </p>
                                </template>
                                <template v-else-if="!activeThread.ad && user.id !==userId ">
                                    <a class="" target="_blank" :href="'/utilisateurs/' + user.id">
                                        <p class="has-text-centered  text-style-title__primary"
                                           v-if="user.id !==userId">
                                            {{user.first_name}} <span class="is-uppercase">{{user.name}}</span>
                                        </p>
                                    </a>
                                </template>
                            </template>
                        </template>
                    </template>

                    <template v-if="activeThread.ad !== null && activeThread.ad.user_pp.deleted_at === null">
                        <p class=" is-6 has-text-centered">{{activeThread.ad.title}}</p>
                    </template>
                    <br>
                    <template v-if="activeThread.ad !== null && activeThread.ad.user_pp.deleted_at === null">
                        <div class="content" v-if="isDisplay">
                            <div class="buttons is-centered ">
                                <template v-if="activeThread.ad.deleted_at">
                                    Annonce supprimée
                                </template>
                                <template v-else>
                                    <a v-if="activeThread.ad.project_id !==null" target="_blank"
                                       :href="'/mon-espace-primo-accueillant/espace-suivi/' + activeThread.ad.id"
                                       class="">
                                        <button class="button basic secondary">
                                            <span class="icon is-small">
                                                <i class="fas fa-hands-helping"></i>
                                            </span>
                                            <span>Suivi de l'accompagnement</span>
                                        </button>
                                    </a>
                                    <a v-if="activeThread.ad.project_id ===null" target="_blank"
                                       :href="'/annonces/' + activeThread.ad.id" class="">
                                        <button class="button basic secondary">
                                            <span class="icon is-small">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                            <span>Voir l'annonce</span>
                                        </button>
                                    </a>
                                </template>

                            </div>
                        </div>
                    </template>
                </div>
                <div class="column">
                    <div id="loading" class="is-pulled-right" v-if="loading"></div>
                </div>
            </div>
            <hr>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            value: {},
            userId: {},
            isDisplay: '',
            activeThreadId: '',
            activeThread: {},
        },
        data() {
            return {
                loading: false
            }
        },
        watch: {
            value: function () {
                this.loading = true;
                setInterval(_ => this.loading = false, 2000);
            }
        },

    }
</script>
