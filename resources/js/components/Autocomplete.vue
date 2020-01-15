<template>
    <input type="text" class="autocomplete-input" ref="input" v-model="value" v-on:click="onClick">
</template>

<style lang="scss">
    .content .awesomplete > ul {
        list-style:none;
        z-index: 10;
        margin:0;
    }
    .awesomplete {
        width:100%;
    }
    .autocomplete-input {
        width:100%;
    }
</style>

<script>
    export default {
        props: {
            src: {
                type: String,
                required: true
            },
            onDataRender: {
                type : Function
            },
            onSelect: {
                type: Function,
                required: true
            },
            onResultsLoaded: {
                type: Function,
                default: _ => {}
            }
        },
        data() {
            return {
                id: 'awesomplete_' + Math.random().toString(36).substr(2, 9),
                value: '',
                timeout: null,
                isFetching: false,
            }
        },
        mounted() {
            const input = this.$refs.input;

            this.$awesomplete = new Awesomplete(input, {
                sort: false,
                data: this.onDataRender,
                maxItems: 20
            });

            input.addEventListener('awesomplete-select', e => {
                e.preventDefault();
                this.onSelect({
                    ...e.text
                });
                this.$awesomplete.close();
                input.value = '';
            })
        },
        watch: {
            value() {
                this.update(300)
            }
        },
        methods: {
            update(cooldown) {
                const query = this.value;

                if (!cooldown && !this.isFetching) {
                    this.isFetching = true;
                    fetch(this.src + '?q=' + query)
                        .then(response => response.json())
                        .then(results => {
                            if(!results.length) {
                                results.push("Pas de résultat pour "+query+" :(")
                            }

                            this.onResultsLoaded(results);

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
                if(this.value) {
                    this.$awesomplete.open();
                }
            }
        }
    }
</script>
