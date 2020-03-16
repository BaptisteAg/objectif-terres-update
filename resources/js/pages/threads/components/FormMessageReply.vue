<template>

    <div v-if="value.length !==0 " class="content">
        <form @submit="formSubmit">
            <label id="reply-input-label" for="reply-input" class=" label has-text-black"> Répondre</label>
            <div class="field has-addons">
                <div class="control is-expanded  has-icons-left">
                    <input type="hidden" name="thread_id" :value="value[0].thread.id">
                    <textarea id="reply-input" v-model="content" class="textarea has-fixed-size" name="content" type="text"
                           placeholder="Votre message..."/>

                </div>
                <div v-if='isUserModerator === false' class="control">
                    <button class="button is-link">
                        Envoyer
                    </button>
                </div>
            </div>

            <div v-if="isUserModerator">
                <label class="label">Envoyer une réponse type</label>
                <div class="field is-grouped">
                    <p class="control is-expanded">
                    <span class="select is-fullwidth">
                    <select v-model.trim="content">
                        <option disabled selected="selected">Choisissez votre réponse type...</option>
                        <option v-for="responseTemplate in responseTemplates">{{responseTemplate.content}}
                        </option>
                    </select>
                </span>
                    </p>
                    <p class="control">
                        <button class="button is-link">
                            Envoyer
                        </button>
                    </p>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        props: {
            value: {},
            responseTemplates: '',
            isUserModerator: Boolean
        },
        data() {
            return {
                content: '',
            }
        },
        methods: {
            formSubmit(e) {
                e.preventDefault();
                axios.post('/mon-espace/messagerie/envoi', {
                    content: this.content,
                    thread_id: this.value[0].thread.id
                })
                    .then(response => {
                        const message = response.data;
                        this.$emit('message-reply-success', message)
                        this.content = '';
                    })
                    .catch(error => {
                        console.log(error)
                    })
            }
        }
    }
</script>
