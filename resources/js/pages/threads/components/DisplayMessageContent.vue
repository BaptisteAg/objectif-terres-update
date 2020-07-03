<template>
    <div ref="content" class="display-message">
        <template v-if="value.length === 0">
            <p class="has-text-centered">Ce fil de discussion ne contient pas encore de messages! </p>
        </template>
        <template v-if="value" v-for="message in value">
            <template v-if="message.sender_user_id === userId">
                <div class=" message-sended">
                    <div class="columns">
                        <div class="column is-half ">
                        </div>
                        <div class="column is-half is-flex pt-20" style="flex-direction : column; align-items: end ">
                            <p class="is-marginless text_secondary"><span>{{message.sender_user.first_name}}</span>
                                {{message.sender_user.name}} </p>
                            <div class="content message-sender">
                                <div v-if="message.documents.length >0">
                                    <template v-for=" document in message.documents">
                                        <a :href="'/'+document.path" :download="document.name">
                                            <template v-if="document.type.includes('image')">
                                                <img :src="'/'+document.path" width="180px" :alt="document.name"
                                                     style="margin-right:5px">
                                            </template>
                                            <template v-else>
                                                <button class="button basic small secondary" style="margin-bottom: 5px">
                                                    <span class="icon is-small">
                                                        <i class="fas fa-file"></i>
                                                    </span>
                                                    <span>{{document.name}}</span>
                                                </button>
                                            </template>
                                        </a>
                                    </template>
                                </div>
                                <div v-else>
                                    <p class="has-text-white">
                                        {{message.content}}
                                    </p>
                                </div>
                                <div v-if="!message.day_posted" id="loading" style="height : 30px; width : 30px"></div>
                                <time v-else class="has-text-white is-size-7">Le {{message.day_posted}} à
                                    {{message.time_posted}}
                                </time>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <template v-if="message.sender_user_id !== userId">
                <div class="content message-received">
                    <div class="columns">
                        <div class="column is-half ">
                            <p class="is-marginless has-text-grey pt-20"><span>{{message.sender_user.first_name}}</span>
                                {{message.sender_user.name}} </p>
                            <div class="content message-receiver ">
                                <div class="message-receiver-content">
                                    <div v-if="message.documents.length >0">
                                        <template v-for=" document in message.documents">
                                            <a :href="'/'+document.path" :download="document.name">
                                                <template v-if="document.type.includes('image')">
                                                    <img :src="'/'+document.path" width="180px" :alt="document.name"
                                                         style="margin-right:5px">
                                                </template>
                                                <template v-else>
                                                    <button class="button basic small secondary"
                                                            style="margin-bottom: 5px">
                                                        <span class="icon is-small">
                                                            <i class="fas fa-file"></i>
                                                        </span>
                                                        <span>{{document.name}}</span>
                                                    </button>
                                                </template>
                                            </a>
                                        </template>
                                    </div>
                                    <div v-else>
                                        <p class="has-text-black">
                                            {{message.content}}
                                        </p>
                                    </div>

                                    <div v-if="!message.day_posted" id="loading"
                                         style="height : 30px; width : 30px"></div>
                                    <time class="has-text-black is-size-7">Le {{message.day_posted}} à
                                        {{message.time_posted}}
                                    </time>
                                </div>
                            </div>
                        </div>
                        <div class="column"></div>
                    </div>
                </div>
            </template>
        </template>
        <hr>
    </div>
</template>

<script>
    export default {
        props: {
            value: {},
            userId: {}
        },
        data() {
            return {
                loading: false
            }
        },
        watch: {
            value: function () {
                this.loading = true;
                setInterval(_ => this.loading = false, 1000);

            }
        },
        updated() {
            let el = this.$refs.content
            el.scrollTop = el.scrollHeight;
        }
    }
</script>
