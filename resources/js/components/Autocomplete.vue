<template>
  <div class="control autocomplete-control has-icons-right">
    <input type="search"
           class="input autocomplete-input is-medium is-rounded"
           ref="input"
           v-model="autocompleteValue"
           :placeholder="placeholder"
           v-on:click="onClick"
           v-on:awesomplete-select="onSelect"
          >
    <span class="icon is-small right" v-show="isFetching">
      <i class="fas fa-spinner fa-spin has-text-black"></i>
    </span>

    <input autocomplete="off" type="hidden" :name="name" :value="JSON.stringify(value)" v-if="name">
    <slot></slot>
  </div>
</template>

<style lang="scss">
.control.autocomplete-control {
  position: relative;

  .awesomplete {
    width: 100%;

    ul {
      list-style: none;
      z-index: 10;
      margin: 0;
    }
  }

  .autocomplete-input {
    width: 100%;

    &:focus {
    }
  }
}

</style>

<script>
require('awesomplete/awesomplete.min');

export default {
  props: {
    value: {
      type: Array,
      default() {
        return []
      }
    },
    name: {
      type: String
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
    },
    placeholder: {
      type: String
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

      /*if(!e.text.value.id) {
          return
      }*/

      if (!this.multiple) {
        this.value.splice(0, 1)
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

              // Saint etienne ne déclenche pas la liste
              //console.log(JSON.stringify(results));

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
