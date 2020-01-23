<template>
    <input type="text"
           class="autocomplete-input"
           ref="input"
           v-model="autocompleteValue"
           v-on:click="onClick"
           v-on:awesomplete-select="onSelect">
</template>

<style lang="scss">
    .content .awesomplete > ul {
        list-style: none;
        z-index: 10;
        margin: 0;
    }

    .awesomplete {
        width: 100%;
    }

    .autocomplete-input {
        width: 100%;
    }
</style>

<script>
    export default {
        props: {
            value: {
                type: Array,
                default() {
                    return []
                }
            },
            src: {
                type: String,
                required: true
            },
            dataRenderer: {
                type: Function,
                default(item) {
                    return item
                }
            },
            multiple: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                autocompleteValue: '',
                timeout: null,
                isFetching: false,
            }
        },
        mounted() {
            const input = this.$refs.input;

            this.$awesomplete = new Awesomplete(input, {
                sort: false,
                data: this.dataRenderer,
                maxItems: 20
            });

            input.setAttribute('autocomplete', 'no' + Date.now());
        },
        watch: {
            autocompleteValue() {
                this.update(300)
            }
        },
        methods: {
            onSelect(e) {
                e.preventDefault();

                if(!this.multiple) {
                    this.value.splice(0,1)
                }
                this.value.push(e.text);

                this.$awesomplete.close();
                e.target.value = '';
            },
            update(cooldown) {
                const query = this.autocompleteValue;

                if (!cooldown && !this.isFetching) {
                    this.isFetching = true;
                    fetch(this.src + '?q=' + query)
                        .then(response => response.json())
                        .then(results => {
                            if (!results.length) {
                                results.push("Pas de résultat pour " + query + " :(")
                            }

                            this.$awesomplete.list = results;
                            this.$awesomplete.evaluate();
                            this.$awesomplete.open();
                        })
                        .catch(error => {
                            console.log(error);
                        })
                        .finally(_ => {
                            this.isFetching = false;
                        })
                } else {
                    if (this.timeout) {
                        clearTimeout(this.timeout);
                    }
                    this.timeout = setTimeout(this.update, cooldown);
                }
            },
            onClick() {
                if (this.autocompleteValue) {
                    this.$awesomplete.open();
                }
            }
        }
    }
</script>
