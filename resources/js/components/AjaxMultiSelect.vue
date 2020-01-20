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
                <span class="custom__tag">
                    <span>{{ option.name }}</span>
                    <span class="custom__remove" @click="remove(option)">❌</span>
                </span>
            </template>
            <template slot="clear" slot-scope="props">
                <div class="multiselect__clear" v-if="selectedCountries.length"
                     @mousedown.prevent.stop="clearAll(props.search)"></div>
            </template>
            <span slot="noResult">Oops! No elements found. Consider changing the search query.</span>
        </multiselect>
        <pre class="language-json"><code>{{ selectedCountries  }}</code></pre>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    // import { ajaxFindCountry } from './countriesApi'

    export default {
        components: {
            Multiselect
        },
        props: {
            nameOption: String,
            src: {
                type: String,
                required: true
            },
            multiple: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                selectedCountries: [],
                countries: [],
                isLoading: false,
                nameOption: this.nameOption,
                timeout: null,
            }
        },
        methods: {
            limitText(count) {
                return `et ${count} autres ` + nameOption;
            },
            asyncFind(query, cooldown) {
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
                return `${result.value.type} – ${result.label}`
            }
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"/>
cus
