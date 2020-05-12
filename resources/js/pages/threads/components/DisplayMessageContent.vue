<template>
    <div class="display-message">
        <template v-if="value.length === 0">
            <p class="has-text-centered">Ce fil de discussion ne contient pas encore de messages! </p>
        </template>
        <template v-if="value" v-for="message in value">
            <template v-if="message.sender_user_id === userId">
                <div class=" message-sended">
                    <div class="columns">
                        <div class="column is-half ">
                        </div>
                        <div class="column is-half">
                            <div class="content message-sender">
                                <p class="has-text-white">
                                    {{message.content}}
                                </p>
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
                            <p class="is-marginless has-text-grey"><span>{{message.sender_user.first_name}}</span>
                                {{message.sender_user.name}} </p>
                            <div class="content message-receiver ">
                                <div class="message-receiver-content">
                                    <p class="has-text-black">
                                        {{message.content}}
                                    </p>
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

<style lang="scss">
    .display-message {
        overflow-x: hidden;
        max-height: 500px;
    }

    .message-sender {
        border-bottom-left-radius: 5px;
        border-top-left-radius: 5px;
        float: right;
        background-color: hsl(204, 86%, 53%);
        margin-right: 0px;
        padding-top: 5px;
        padding-bottom: 5px;
        padding-left: 15px;
        padding-right: 15px;

        &:first-child {
            border-top-left-radius: 15px;
        }

        &:last-child {
            border-bottom-left-radius: 15px;
        }
    }

    .message-receiver {
        border-bottom-right-radius: 5px;
        border-top-right-radius: 5px;
        background-color: hsl(0, 0%, 86%);
        margin-right: 0px;
        float: left;
        padding-top: 5px;
        padding-bottom: 5px;
        padding-right: 15px;
        padding-right: 15px;
    }

    .message-receiver-content {
        margin-left: 12px
    }


</style>

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
    }
</script>
