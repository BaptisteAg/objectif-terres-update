<!-- Vue component -->
<template>
    <label class="cradio-container">
        <input :type="isRadio ? 'radio' : 'checkbox'"
               :name="name"
               :value="inputValue"
               :disabled="disabled"
                v-model="checked">
        <span class="cradio-checkmark">
            <slot></slot>
        </span>
    </label>
</template>

<style lang="scss">
    .cradio-container {
        display: inline-block;
        position: relative;
        padding-left: 100%;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        height: 100px;
        line-height: 13px;
        text-align: center;

        /* Hide the browser's default checkbox */
        input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        /* On mouse-over, add a grey background color */
        &:hover input ~ .cradio-checkmark {
            background-color: #ccc;
        }

        /* When the checkbox is checked, add a blue background */
        input:checked ~ .cradio-checkmark {
            background-color: #579ea5;
            color: #fff;
        }

        /* Show the checkmark when checked */
        input:checked ~ .cradio-checkmark:after {
            display: block;
        }

        /* Style the checkmark/indicator */
        .checkmark:after {
            left: 9px;
            top: 5px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }
    }

    /* Create a custom checkbox */
    .cradio-checkmark {
        position: absolute;
        top: 0;
        left: 0;
        padding-top: 20px;
        height: 100%;
        width: 100%;
        background-color: #eee;
        border-radius: 5px;
        box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.2);

        /* Create the cradio-checkmark/indicator (hidden when not checked) */
        &:after {
            content: "";
            position: absolute;
            display: none;
        }
    }
</style>

<script>
    export default {
        props: {
            name: String,
            value: {
                type: [Number, String, Array],
                required: true
            },
            inputValue: String,
            disabled: Boolean,
            isRadio: {
                type: Boolean,
                default: false
            },
            exclusiveValues: {
                type: Array,
                default: _ => []
            }
        },
        data() {
            return {
                checked: this.value
            };
        },
        watch: {
            checked(newValue) {
                if(Array.isArray(newValue)) {
                    if(newValue.length) {
                        this.$emit('input', this.value.concat(newValue))
                    }
                    else {
                        this.$emit('input', this.value.filter(v => v !== this.inputValue))
                    }
                }
                else {
                    this.$emit('input', this.inputValue)
                }
            }
        }
    }
</script>
