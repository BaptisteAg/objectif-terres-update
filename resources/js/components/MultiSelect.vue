<!-- Vue component -->
<template>
    <div>
        <multiselect v-model="values"
                     :options="options"
                     :multiple="multiple"
                     :close-on-select="false"
                     :clear-on-select="false"
                     :preserve-search="true"
                     :placeholder="placeholder"
                     :label="label"
                     :track-by="trackBy"
                     :custom-label="customLabel"
                     select-label="Sélectionner"
                     selected-label="Sélectionné"
                     deselect-label="Supprimer"
                     :max-height="height">

        </multiselect>
        <input type="hidden" v-for="v in values" :value="getId(v)" :name="name">
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';

    export default {
        components: {
            Multiselect,
        },
        props: {
            options: Array,
            name: String,
            selectedCountText: String,
            placeholder: String,
            multiple: {
                type: Boolean,
                default: true
            },
            label: {
                type: String,
                default: 'name'
            },
            trackBy: {
                type: String,
                default: 'name'
            },
            idProp: {
                type: String,
                default: 'id'
            },
            value: {
                type: Array,
            },
            height: {
                type: Number,
                default: 500
            }
        },
        data () {
            return {
                values: this.value ? this.value.map(value => this.getId(value)) : [],
            }
        },
        watch: {
            values(newValues) {
                this.$emit('input', newValues.map( value => value[this.idProp]))
            }

        },
        methods: {
            getId(v) {
                return _.isObject(v) ? v[this.idProp] : v
            },
            customLabel(result) {
                return `${result[this.trackBy]}`
            }
        }
    }

</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"/>
