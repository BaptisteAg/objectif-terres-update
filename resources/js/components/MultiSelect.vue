<!-- Vue component -->
<template>
    <div>
        <multiselect v-model="values"
                     :options="data"
                     :multiple="multiple"
                     :close-on-select="false"
                     :clear-on-select="false"
                     :preserve-search="true"
                     :placeholder=placeholder
                     label="name"
                     :track-by=trackBy
                     :custom-label="customLabel">
            <template slot="selection" slot-scope="{ values, search, isOpen }">
                <span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} {{ selectedCountText }}</span>
            </template>
        </multiselect>
        <input type="hidden" v-for="value in values" :value="value.id" :name="name">
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';

    export default {
        components: {
            Multiselect,
        },
        props: {
            data: Array,
            name: String,
            selectedCountText: String,
            placeholder: String,
            multiple: {
                type: Boolean,
                default: true
            },
            trackBy: {
                type: String,
                default: 'name'
            },
            value: {
                type: Array,
            }
        },
        data () {
            return {
                values: this.value || [],
            }
        },
        watch: {
            values(newValues) {
                this.$emit('input', newValues.map(v => v.id))
            }

        },
        methods: {
            customLabel(result) {
                return `${result[this.trackBy]}`
            }
        }
    }

</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"/>

<style>

</style>
