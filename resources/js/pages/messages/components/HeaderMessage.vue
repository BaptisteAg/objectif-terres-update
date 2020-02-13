<template>
    <div>
        <div class="content ">
            <template v-if="value[0].thread.users[0].id !== userId">
                <p class="title is-4 has-text-centered" >{{value[0].thread.users[0].first_name}} {{value[0].thread.users[0].name}}</p>
            </template>
            <template v-else>
                <p class="title is-4 has-text-centered" >{{value[0].thread.users[1].first_name}} {{value[0].thread.users[1].name}}</p>
            </template>
            <a><p class="subtitle is-6 has-text-centered" >{{value[0].thread.ad.title}}</p></a>
        </div>
        <hr>
    </div>
</template>

<script>
    export default {
        props : {
            value: {
                type: Array,
            },
            userId:{
                type: Number,
            }
        },
        mounted() {

        },

    }
</script>
