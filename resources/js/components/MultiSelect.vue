<!-- Vue component -->
<template>
    <div>
        <label class="typo__label"></label>
        <multiselect v-model="values"
                     :options="options"
                     :multiple="multiple"
                     :close-on-select="false"
                     :clear-on-select="false"
                     :preserve-search="true"
                     :placeholder=placeholder
                     label="name"
                     track-by="name" >
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
            multiple: Boolean,
        },
        data () {
            return {
                values: [],
                options: this.data,
            }
        },
        watch: {
            values(newValues) {
                console.log(newValues);
                this.$emit('multiselect-select', newValues)
            }

        }
    }

</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"/>

<style>

</style>
