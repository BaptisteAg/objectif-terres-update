import Vue from "vue";

function findInputElement(input) {
    if (input instanceof Vue) {
        input = input.$el
    }
    if (input instanceof Element) {
        const tagNames = ['input', 'textarea', 'select'];

        if (!tagNames.includes(input.tagName.toLowerCase())) {
            input = input.querySelector(tagNames.join(','));
        }
    }

    return input
}

export default {
    props: {
        oldValues: Object,
        isInputDisabled: Boolean
    },
    mounted() {
        if(!this.isInputDisabled) {
            this.$emit('input-enabled', this)
        }
    },
    watch: {
        isInputDisabled(isDisabled) {
            if(!isDisabled) {
                this.$emit('input-enabled', this)
            }
        },
        formInput : {
            handler(formInput) {
                this.setInputsBorderColor()
            },
            deep: true
        }
    },
    methods: {
        setInputsBorderColor() {
            _(this.formInput).forEach((value, key) => {
                const validation = this.$v.formInput[key];

                if(validation && this.$refs[key]) {
                    const input = findInputElement(this.$refs[key]);
                    const hasDirtyError = validation.$dirty && validation.$error;

                    input.style.borderColor = hasDirtyError ? "red" : "#dbdbdb"
                }
            })
        },
        focusOnFirstError() {
            for (let key in Object.keys(this.$v.formInput)) {
                const inputName = Object.keys(this.$v.formInput)[key];
                if (inputName.includes("$")) return false;
                if (this.$v.formInput[inputName].$error) {
                    let input = findInputElement(this.$refs[inputName]);

                    try {
                        input.focus();
                    } catch (error) {
                        console.log(error)
                    }
                    return true;
                }
            }
        }
    }
};
