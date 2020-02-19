<!-- Vue component -->
<template>
    <div>
        <multiselect v-model="selected"
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
        <input type="hidden" v-for="option in selected" :value="option.id" :name="name">

        <template v-if="showIcons">
            <template v-for="option in selected">
                <span class="biocertification-icon" v-if="option.icon">
                    <img :src="option.icon" :alt="option.name">
                </span>
            </template>
        </template>
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
                default: _ => []
            },
            height: {
                type: Number,
                default: 500
            },
            clearOtherValues: {
                type: Array,
                default: _ => []
            },
            showIcons: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                selectedIds: this.value || []
            };
        },
        computed: {
            selected: {
                get() {
                    return this.selectedIds.map(id =>
                        this.options.find(option => option.id.toString() === id)
                    )
                },
                set(options) {
                    let selectedOptions = [];

                    const lastOption = options[options.length-1];

                    // any of the clearingIds will clear other ids from the array
                    if (this.clearingIds.includes(lastOption.id)) {
                        selectedOptions = [lastOption];
                    }
                    else {
                        selectedOptions = options.filter(option => {
                            return !this.clearingIds.includes(option.id);
                        });
                    }

                    console.log(selectedOptions);

                    this.selectedIds = selectedOptions.map(option => option[this.idProp]);
                    this.$emit('input', this.selectedIds);
                    return selectedOptions;
                }
            },
            clearingIds() {
                return this.clearOtherValues.map(options => options[this.idProp]);
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
