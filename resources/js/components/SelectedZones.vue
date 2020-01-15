<template>

</template>

<style lang="scss">
    .selected-zones {

    }
</style>

<script>
    export default {
        props: {
            selected: {
                type: Object,
                required: true
            },
            name: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                zones: this.selected
            }
        }
    }
</script>
