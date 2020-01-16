<template>
    <input type="text"
           class="autocomplete-input"
           ref="input"
           v-model="value"
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
            src: {
                type: String,
                required: true
            },
            dataRenderer: {
                type: Function
            }
        },
        data() {
            return {
                value: '',
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
        },
        watch: {
            value() {
                this.update(300)
            }
        },
        methods: {
            onSelect(e) {
                e.preventDefault();
                this.$emit('autocomplete-select', e.text);
                this.$awesomplete.close();
                e.target.value = '';
            },
            update(cooldown) {
                const query = this.value;

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
                if (this.value) {
                    this.$awesomplete.open();
                }
            }
        }
    }
</script>
