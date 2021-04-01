<template>
    <div class="modal is-active">
        <div class="modal-background" @click="$emit('close')"></div>
        <div class="modal-content">
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">
                        Historique de l'annonce
                    </p>
                </header>
                <div class="card-content">
                    <div v-if="isLoading ">
                        <p>Chargement...</p>
                    </div>
                    <div v-else>
                        <div v-if="historyData !== null">
                            <div v-if="historyData.length">
                                <table class="table is-narrow is-hoverable is-fullwidth">
                                    <tbody>
                                    <tr v-for="data in historyData">
                                        <td>Date : {{data.created_at}}</td>
                                        <td v-html="data.body"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div v-else>
                                <p>Aucune donnée trouvée</p>
                            </div>
                        </div>
                        <div v-else>
                            <p>Erreur de chargement</p>
                        </div>
                    </div>
                </div>
                <footer class="card-footer">
                    <div class="buttons card-footer-item">
                        <button @click="$emit('close')" class="button form-button basic secondary">
                            <span>Fermer</span></button>
                    </div>
                    <button id="close-modal" class="modal-close is-large" aria-label="close"
                            @click="$emit('close')"></button>
                </footer>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        props: {
            adId: '',
        },
        data() {
            return {
                isLoading: true,
                historyData: null,
            }
        },
        methods: {},
        mounted() {
            axios
                .get('https://objectif-terres.test/historique/' + this.adId)
                .then(response => (this.historyData = response.data.histories))
                .catch(error => {
                    console.log(error)
                })
                .finally(() => this.isLoading = false)
        }


    }

</script>
