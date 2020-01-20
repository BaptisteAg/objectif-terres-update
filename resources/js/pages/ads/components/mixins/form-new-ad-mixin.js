export default {
    props: {
        oldValues: Object,
        isInputDisabled: Boolean
    },
    mounted() {
        if(!this.isInputDisabled) {
            this.$emit('input-enabled', this)
        }
    },
    watch: {
        isInputDisabled(isDisabled) {
            if(!isDisabled) {
                this.$emit('input-enabled', this)
            }
        }
    },
};