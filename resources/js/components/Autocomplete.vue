<template>
    <input type="text" ref="input" v-on:change="update()">
</template>

<script>
    export default {
        props: {
            src: String,
            selected: Array

        },
        data() {
            return {
                id: 'awesomplete_' + Math.random().toString(36).substr(2, 9)
            }
        },
        mounted() {
            fetch(this.src+'?q='+this.$refs.input.value)
                .then(response => response.json())
                .then(json => {
                    new Awesomplete(this.$refs.input, {
                        list: json
                    })
                })
        }
    }
</script>
