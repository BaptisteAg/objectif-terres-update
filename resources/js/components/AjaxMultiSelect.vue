<template>
    <div>
        <multiselect v-model="selectedData"
                     id="ajax"
                     label="name"
                     track-by="code"
                     placeholder="Ecrivez pour rechercher"
                     open-direction="bottom"
                     :options="data"
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
                <div class="multiselect__clear" v-if="selectedData.length"
                     @mousedown.prevent.stop="clearAll(props.search)"></div>
            </template>
            <span slot="noResult">Oups! Pas de {{ nameOptionLabel }} trouvé. Essayer de changer votre recherche.</span>
        </multiselect>
        <input type="hidden" v-for="selected in selectedData" :value="selected.value.id" :name="name">
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
            name: {
                type: String
            }
        },
        data() {
            return {
                selectedData: [],
                data: [],
                isLoading: false,
                timeout: null,
            }
        },
        methods: {
            limitText(count) {
                return `et ${count} autres ` + nameOptionLabel;
            },
            asyncFind(query, cooldown) {
                if (!cooldown && !this.isFetching) {
                    this.isLoading = true;

                    fetch(this.src + '?q=' + query)
                        .then(response => response.json())
                        .then(results => {
                            if (!results.length) {
                                results =  [{
                                    label: "Pas de résultat pour " + query + " :("
                                }];
                            }
                            else {
                                results.map(result => {
                                    return {
                                        ...result,
                                        id: result.value.id
                                    }
                                });
                            }


                            this.data = results;
                            console.log("nouvelle valeur data", this.data);
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
                this.selectedData = []
            },
            customLabel(result) {
                return `${result.label}`
            }
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"/>
