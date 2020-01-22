const LABELS = {
    ZONE_TYPES: {
        cities: 'Code postal',
        departments: 'Département',
        regions: 'Région'
    }
};

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
    methods: {
        getLabels() {
            return LABELS;
        },
    }
};