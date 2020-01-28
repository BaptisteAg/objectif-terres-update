import Vue from "vue";

const INPUT_TAGS = ['input', 'textarea', 'select'];

/**
 *  Find the first input in object parameter, be it either :
 *  - any html element
 *  - a vue component
 *
 * @param input
 * @returns {Element}
 */
function findInputElement(input) {
    if (input instanceof Vue) {
        input = input.$el
    }
    if (input instanceof Element) {
        if (!INPUT_TAGS.includes(input.tagName.toLowerCase())) {
            input = input.querySelector(INPUT_TAGS);
        }
    }

    return input
}

export default {
    props: {
        oldValues: Object,
        isInputDisabled: Boolean,
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
                const ref = this.$refs[key];

                // The ref and its validation exists
                if(validation && ref) {
                    const input = findInputElement(ref);
                    const hasDirtyError = validation.$dirty && validation.$error;

                    if(input.getAttribute("type") === "checkbox") {
                        input.parentElement.style.border = hasDirtyError ? "1px dashed red" : "none"
                    }
                    else {
                        input.style.borderColor = hasDirtyError ? "red" : "#dbdbdb"
                    }
                }
            })
        },
        focusOnFirstError() {
            for (let key in Object.keys(this.$v.formInput)) {
                const inputName = Object.keys(this.$v.formInput)[key];

                // Filter out vuelidate private props
                if (inputName.includes("$")) continue;

                if (this.$v.formInput[inputName].$error) {
                    let input = findInputElement(this.$refs[inputName]);
                    const $form = this.$refs.formWizard;

                    if(input) {
                        const inputTabIndex = $form.tabs.findIndex(
                            tab => [...tab.$el.querySelectorAll(INPUT_TAGS)].find(
                                element => input.isSameNode(element)
                            )
                        );

                        if(inputTabIndex) {
                            // Change current form step if needed
                            $form.changeTab($form.activeTabIndex, inputTabIndex);

                            // Lets try to focus
                            try {
                                input.focus();
                            } catch (error) {
                                console.log(error)
                            }
                        }
                    }

                    return true;
                }
            }
        }
    }
};
