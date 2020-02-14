<template>
    <div>
        <template v-for="message in value">
            <template v-if="message.sender_user_id === userId">
                <div class="content message-sended">
                    <div class="columns">
                        <div class="column is-half ">
                        </div>
                        <div class="column is-half has-background-info ">
                            <div class="content">
                                <p class="has-text-white">
                                    {{message.content}}
                                </p>
                                <time class="has-text-white">Le {{message.created_at}}</time>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <template v-else>
                <div class="content message-received">
                    <div class="columns">
                        <div class="column is-half has-background-grey-lighter ">
                            <div class="content ">
                                <p class="has-text-black">
                                   {{message.content}}
                                </p>
                                <time class="has-text-black">Le {{message.created_at}}</time>
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
            value: {
                type: Array,
            },
            userId: {
                type: Number,
            }
        },
    }
</script>
