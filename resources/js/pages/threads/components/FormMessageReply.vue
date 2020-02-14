<template>
    <div class="content ">
            <p class="has-text-black"> Répondre</p>
            <div class="field has-addons">
                <div class="control is-expanded  has-icons-left">
                    <input  type="hidden" name="thread_id" :value="value[0].thread.id">
                    <input  class="input" name="content" type="text" placeholder="Votre message..."/>
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
    </div>
</template>

<script>
    import axios from 'axios'
    export default {
        props: {
            value: {
                type: Array,
            },
        },
        


    }
</script>
