<!-- Vue component -->
<template>
    <div>
        <label class="typo__label"></label>
        <multiselect v-model="selectedValues"
                     :options="options"
                     :multiple="multiple"
                     :close-on-select="false"
                     :clear-on-select="false"
                     :preserve-search="true"
                     :placeholder=placeholder
                     label="name"
                     track-by="name" >
            <template slot="selection" slot-scope="{ selectedValues, search, isOpen }">
                <span class="multiselect__single" v-if="selectedValues.length &amp;&amp; !isOpen">{{ selectedValues.length }} {{ selectedCountText }}</span>
            </template>
        </multiselect>
        <input type="hidden" v-for="value in selectedValues" :value="value.id" :name="name">
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';
    import { ajaxFindCountry } from './countriesApi'

    export default {
        components: {
            Multiselect,
        },
        props: {
            data: Array,
            name: String,
            selectedCountText: String,
            placeholder: String,
            multiple: Boolean,
        },
        data () {
            return {
                selectedValues: [],
                options: this.data,
                multiple: this.multiple,
                isLoading: false
            }
        },
        watch: {
            selectedValues(newValues) {
                console.log(newValues);
                this.$emit('multiselect-select', newValues)
            }

        },
        methods: {
            limitText (count) {
                return `and ${count} other countries`
            },
            asyncFind (query) {
                this.isLoading = true
                ajaxFindCountry(query).then(response => {
                    this.countries = response
                    this.isLoading = false
                })
            },
            clearAll () {
                this.selectedCountries = []
            }
        }
    }

</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"/>

<style>

</style>
