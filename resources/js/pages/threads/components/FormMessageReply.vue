<template>

    <div v-if="value.length !==0 " class="content ">
        <form @submit="formSubmit">
            <p class="has-text-black"> Répondre</p>
            <div class="field has-addons">
            <div class="control is-expanded  has-icons-left">
                <input type="hidden" name="thread_id" :value="value[0].thread.id">

                <input v-model="content" class="input" name="content" type="text" placeholder="Votre message..."/>
                <span class="icon is-small is-left">
                        <i class="fas fa-reply"></i>
                    </span>
            </div>
                <div class="control">
                <button class="button is-link">
                    Envoyer
                </button>
            </div>
            </div>
        </form>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        props: {
           value:{}
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
                    .then (response => {
                        console.log(response)
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
