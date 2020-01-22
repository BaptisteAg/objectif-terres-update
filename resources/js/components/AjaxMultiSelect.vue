<template>
    <div>
        <multiselect v-model="selectedCountries"
                     id="ajax"
                     label="name"
                     track-by="code"
                     placeholder="Ecrivez pour rechercher"
                     open-direction="bottom"
                     :options="countries"
                     :multiple="multiple"
                     :searchable="true"
                     :loading="isLoading"
                     :internal-search="false"
                     :clear-on-select="false"
                     :close-on-select="false"
                     :options-limit="300"
                     :limit="3"
                     :limit-text="limitText"
                     :max-height="600"
                     :show-no-results="false"
                     :hide-selected="true"
                     @search-change=" query => asyncFind(query, 300)"
                     :custom-label="customLabel">
            <template slot="tag" slot-scope="{ option, remove }">
                <span class="custom__tag"><span>{{ option.label }}{{ option.name }}</span>
                    <span class="custom__remove" @click="remove(option)">❌</span>
                </span>
            </template>
            <template slot="clear" slot-scope="props">
                <div class="multiselect__clear" v-if="selectedCountries.length"
                     @mousedown.prevent.stop="clearAll(props.search)"></div>
            </template>
            <span slot="noResult">Oups! Pas de {{ nameOptionLabel }} trouvé. Essayer de changer votre recherche.</span>
        </multiselect>
        <input type="hidden" v-for="selectedCountrie in selectedCountries" :value="selectedCountrie.value.id" :name="cities">
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    export default {
        components: {
            Multiselect
        },
        props: {
            nameOptionLabel: String,
            src: {
                type: String,
                required: true
            },
            multiple: {
                type: Boolean,
                default: false
            },
        },
        data() {
            return {
                selectedCountries: [],
                countries: [],
                isLoading: false,
                timeout: null,
            }
        },
        methods: {
            limitText(count) {
                return `et ${count} autres ` + nameOptionLabel;
            },
            asyncFind(query, cooldown) {
                console.log(cooldown);
                if (!cooldown && !this.isFetching) {
                    this.isLoading = true;

                    fetch(this.src + '?q=' + query)
                        .then(response => response.json())
                        .then(results => {
                            if (!results.length) {
                                results.push("Pas de résultat pour " + query + " :(")
                            }

                            console.log(results);

                            results.map(result => {
                                return {
                                    ...result,
                                    id: result.value.id
                                }
                            });

                            this.countries = results;
                            this.isLoading = false;
                        })
                        .catch(error => {
                            console.log(error);
                        })
                        .finally(_ => {
                            this.isLoading = false;
                        });
                } else {
                    if (this.timeout) {
                        clearTimeout(this.timeout);
                    }
                    this.timeout = setTimeout(_=> this.asyncFind(query), cooldown);
                }

            },
            clearAll() {
                this.selectedCountries = []
            },
            customLabel(result) {
                return `${result.label}`
            }
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"/>
