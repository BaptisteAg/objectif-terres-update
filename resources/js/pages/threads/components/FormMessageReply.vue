<template>
    <div>
        <div v-if="activeThreadId" class="content">
            <form @submit="formSubmit">
                <label id="reply-input-label" for="reply-input" class=" label has-text-black"> Répondre</label>
                <div class="field ">
                    <div v-bind:class="[isLoading ?'control is-expanded  has-icons-left is-loading ' : 'control is-expanded  has-icons-left']">
                        <input type="hidden" name="thread_id" :value="activeThreadId">
                        <textarea :disabled="isLoading" id="reply-input" v-model="content"
                                  class=" textarea has-fixed-size" name="content" type="text"
                                  placeholder="Votre message..."/>
                    </div>
                    <br>
                    <div v-if='showResponseType === false ' class="control ">
                        <button class="button is-link button-send-message">
                            Envoyer
                        </button>
                    </div>
                </div>
                <div v-if="showResponseType">
                    <label class="label">Envoyer une réponse type</label>
                    <div class="field is-grouped">
                        <p class="control is-expanded">
                        <span v-bind:class="[isLoading ?'select is-fullwidth is-loading ' : 'select is-fullwidth']">
                        <select :disabled="isLoading" v-model.trim="content">
                            <option disabled selected="selected">Choisissez votre réponse type...</option>
                            <option v-for="responseTemplate in responseTemplates">{{responseTemplate.content}}
                            </option>
                        </select>
                        </span>
                        </p>
                    </div>
                    <br>
                    <p class="control ">
                        <button class="button is-link button-send-message">
                            Envoyer
                        </button>
                    </p>
                </div>
            </form>
        </div>
<!--        <div v-if="value.length !==0 " class="content">-->
<!--            <form @submit="formSubmit">-->
<!--                <label id="reply-input-label" for="reply-input" class=" label has-text-black"> Répondre</label>-->
<!--                <div class="field ">-->
<!--                    <div v-bind:class="[isLoading ?'control is-expanded  has-icons-left is-loading ' : 'control is-expanded  has-icons-left']">-->
<!--                        <input type="hidden" name="thread_id" :value="value[0].thread.id">-->
<!--                        <textarea :disabled="isLoading" id="reply-input" v-model="content"-->
<!--                                  class=" textarea has-fixed-size" name="content" type="text"-->
<!--                                  placeholder="Votre message..."/>-->
<!--                    </div>-->
<!--                    <br>-->
<!--                    <div v-if='showResponseType === false ' class="control ">-->
<!--                        <button class="button is-link button-send-message">-->
<!--                            Envoyer-->
<!--                        </button>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div v-if="showResponseType">-->
<!--                    <div v-if="value[0].thread.ad !== null">-->
<!--                        <label class="label">Envoyer une réponse type</label>-->
<!--                        <div class="field is-grouped">-->
<!--                            <p class="control is-expanded">-->
<!--                        <span v-bind:class="[isLoading ?'select is-fullwidth is-loading ' : 'select is-fullwidth']">-->
<!--                        <select :disabled="isLoading" v-model.trim="content">-->
<!--                            <option disabled selected="selected">Choisissez votre réponse type...</option>-->
<!--                            <option v-for="responseTemplate in responseTemplates">{{responseTemplate.content}}-->
<!--                            </option>-->
<!--                        </select>-->
<!--                        </span>-->
<!--                            </p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <br>-->
<!--                    <p class="control ">-->
<!--                        <button class="button is-link button-send-message">-->
<!--                            Envoyer-->
<!--                        </button>-->
<!--                    </p>-->
<!--                </div>-->
<!--            </form>-->
<!--        </div>-->
    </div>

</template>

<script>
    import axios from 'axios'

    export default {
        props: {
            responseTemplates: '',
            showResponseType: Boolean,
            activeThreadId: ''
        },
        data() {
            return {
                content: '',
                isLoading: false
            }
        },
        methods: {
            formSubmit(e) {
                this.isLoading = true;
                e.preventDefault();
                axios.post('/mon-espace/messagerie/envoi', {
                    content: this.content,
                    thread_id:this.activeThreadId
                })
                    .then(response => {
                        const message = response.data;
                        this.$emit('message-reply-success', message)
                        this.isLoading = false;
                        this.content = '';
                    })
                    .catch(error => {
                        console.log(error)
                    })
            }
        }
    }
</script>
