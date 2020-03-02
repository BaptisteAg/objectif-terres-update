<template>
    <form @submit="formSubmit" >
        <div class="modal is-active">
            <div class="modal-background" @click="$emit('close')"></div>
            <div class="modal-content">
                <div class="card">

                    <div class="card-content">
                        <template v-if="moderationChoice === 'modifyAd'">
                            <h3 class="title is-3 has-text-centered has-text-black ">Demander la modification de
                                l'annonce</h3>
                        </template>
                        <template v-else-if="moderationChoice === 'rejectAd'">
                            <h3 class="title is-3 has-text-centered has-text-black ">Refuser l'annonce</h3>
                        </template>
                        <template v-else>
                            <h3 class="title is-3 has-text-centered has-text-black ">Êtes-vous sûre de vouloir valider cette annonce ?</h3>
                        </template>
                    </div>
                    <div class="card-content" v-if="moderationChoice !== 'acceptAd'">
                        <h5 class="has-text-link is-size-5">Justifier votre choix en envoyant un message au porteur de
                            projet
                        </h5>
                        <br>
                        <div class="container">
                            <div class="field">
                                <div class="field">
                                    <label class="label has-text-left">Envoyer un message type</label>
                                    <p class="control is-expanded">
                                    <span class="select is-fullwidth">
                                <select v-model.trim="content">
                                    <option disabled selected="selected">Choisissez votre réponse type...</option>
                                    <option v-for="selectOption in selectOptions" :value="selectOption.content">{{selectOption.name}} - {{selectOption.content}}
                                    </option>
                                </select>
                            </span>
                                    </p>
                                </div>
                                <div class="field">
                                    <label class="label has-text-left">Votre message</label>
                                    <div class="control">
                                    <textarea v-model="content" required name="content" class="textarea is-medium"
                                              placeholder="Votre message..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <footer class="card-footer">
                        <div class="buttons card-footer-item">
                            <button  class="button is-link">
                                <span>Valider</span>
                            </button>
                            <button @click="$emit('close')" class="button is-link is-light">
                                <span>Annuler</span></button>
                        </div>
                        <button id="close-modal" class="modal-close is-large" aria-label="close"
                                @click="$emit('close')"></button>
                    </footer>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
    import axios from 'axios'
    export default {
        props: {
            moderationChoice: '',
            selectOptions: {},
            formUrl : '',
            attributionAdId : '',
        },
        data() {
            return {
                content: '',
            }
        },
        methods: {
            formSubmit(e) {
                e.preventDefault();
                axios.post(this.formUrl, {
                    content: this.content,
                    attributionAdId : this.attributionAdId
                })
                    .then(response => {
                        window.location = response.data.redirect;
                    })
                    .catch(error => {
                        console.log(error)
                    })
            }
        }

    }

</script>
