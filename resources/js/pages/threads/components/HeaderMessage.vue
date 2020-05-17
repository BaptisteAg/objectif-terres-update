<template>
    <div>
        <template class="loader-wrapper" v-if="value.length === 0">
        </template>
        <div v-else class="content ">
            <div class="columns is-vcentered">
                <div class="column is-one-third"></div>
                <div class="column ">
                    <template v-if="value[0].thread.title">
                        <p class="title is-5 has-text-centered">{{value[0].thread.title}}</p>
                        <template v-for="(user, index) in value[0].thread.users">
                            <p class=" is-marginless subtitle is-6 has-text-centered has-text-grey"
                               v-if="user.id !==userId">
                                {{user.first_name}} {{user.name}}</p>
                        </template>
                    </template>

                    <template v-else>
                            <template v-for="(user, index) in value[0].thread.users">
                                <a target="_blank" :href="'/utilisateurs/' + user.id">  <p class=" title is-5 has-text-centered is-marginless" v-if="user.id !==userId"> {{user.first_name}} <span class="is-uppercase">{{user.name}}</span></p></a>
                            </template>
                    </template>

                    <template v-if="value[0].thread.ad !== null">
                       <p class="subtitle is-6 has-text-centered">{{value[0].thread.ad.title}}</p>
                    </template>
                    <br>
                    <template v-if="value[0].thread.ad !== null">
                        <div class="content" v-if="isDisplay">
                            <div class="buttons is-centered ">
                                <a target="_blank" :href="'/annonces/' + value[0].thread.ad.id">
                                    <button class="button is-link ">
											<span class="icon is-small">
											 <i class="fas fa-eye"></i>
											</span>
                                        <span>Voir l'annonce</span>
                                    </button>
                                </a>
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
            activeThreadId : '',
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
