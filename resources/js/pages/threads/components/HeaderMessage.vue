<template>
    <div>
        <template class="loader-wrapper" v-if="value.length === 0">
        </template>
        <div v-else class="content ">
            <div class="columns is-vcentered">
                <div class="column is-one-third"></div>
                <div class="column ">
                    <template v-if="value[0].thread.title">
                        <p class="title is-4 has-text-centered">{{value[0].thread.title}}</p>
                        <template v-if="value[0].thread.users[0].id !== userId">
                            <p class="subtitle is-6 has-text-centered has-text-grey">
                                {{value[0].thread.users[0].first_name}}
                                {{value[0].thread.users[0].name}}</p>
                        </template>
                        <template v-else>
                            <p class="subtitle is-6 has-text-centered has-text-grey">
                                {{value[0].thread.users[1].first_name}}
                                {{value[0].thread.users[1].name}}</p>
                        </template>

                    </template>
                    <template v-else-if="value[0].thread.users[0].id !== userId">
                        <p class="title is-4 has-text-centered">{{value[0].thread.users[0].first_name}}
                            {{value[0].thread.users[0].name}}</p>
                    </template>
                    <template v-else>
                        <p class="title is-4 has-text-centered">{{value[0].thread.users[1].first_name}}
                            {{value[0].thread.users[1].name}}</p>
                    </template>

                    <template v-if="value[0].thread.ad !== null">
                        <a :href="'/annonces/' + value[0].thread.ad.id" v-if="isDisplay"><p
                                class="subtitle is-6 has-text-centered">{{value[0].thread.ad.title}}</p></a>
                    </template>
                    <br>
                    <template v-if="value[0].thread.ad !== null">
                        <div class="content" v-if="isDisplay">
                            <div class="buttons is-centered ">
                                <a :href="'/annonces/' + value[0].thread.ad.id">
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
