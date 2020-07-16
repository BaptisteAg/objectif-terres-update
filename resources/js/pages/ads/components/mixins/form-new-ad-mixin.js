import Vue from "vue";

// Whitelist of html form inputs
const INPUT_TAGS = ['input', 'textarea', 'select'];

var smoothScrolls = [];

export default {
    props: {
        oldValues: Object,
        isInputDisabled: Boolean,
        isSupportRequest: Boolean
    },
    data() {
        return {
            uploading: false
        }
    },
    mounted() {
        // Initiate correctly existing disabled status
        if (!this.isInputDisabled) {
            this.$emit('input-enabled', this)
        }
    },
    watch: {
        isInputDisabled(isDisabled) {
            if (!isDisabled) {
                this.$emit('input-enabled', this)
            }
        },
        formInput: {
            handler() {
                this.setInputsBorderColor()
            },
            deep: true
        }
    },
    methods: {
        nextStep() {
            smoothScrolls.forEach(function (smoothScroll) {
                smoothScroll.destroy();
            });
            smoothScrolls = [];

            const smoothScroll = new SmoothScroll();

            const anchorElement = [].slice.call(
                document.querySelectorAll('.form-container')
            ).find(element => element.style.display !== "none");


            // Monkey patch for smoothScroll.js
            // Without this check, it bugs when attempting to scroll to the same current position
            // and indefinetly scroll
            const topPositionRelativeToWindow = Math.abs(anchorElement.getBoundingClientRect().top);
            if(parseInt(topPositionRelativeToWindow) > 0) {
                smoothScroll.animateScroll(anchorElement);
            }

            smoothScrolls.push(smoothScroll);
        },
        setUploading(bool) {
            this.uploading = bool;
        },
        /**
         *  Find the first input within received object parameter, be it either :
         *  - any html element
         *  - a vue component
         *
         * @param {Element|Vue} element
         * @returns {Element}
         */
        findInputElement(element) {
            let input = element;

            if (input instanceof Vue) {
                input = input.$el
            }
            if (input instanceof Element) {
                if (!INPUT_TAGS.includes(input.tagName.toLowerCase())) {
                    input = input.querySelector(INPUT_TAGS) || input
                }
            }

            return input;
        },
        /**
         * Set inputs border color ( red or initial ) based on error status
         */
        setInputsBorderColor() {
            for (const [key, value] of Object.entries(this.formInput)) {
                const validation = this.$v.formInput[key];
                const ref = this.$refs[key];

                // The ref and its validation exists
                if (validation && ref) {
                    const input = this.findInputElement(ref);
                    const hasDirtyError = validation.$dirty && validation.$error;
                    const type = input.getAttribute("type");
                    const isCheckbox = type && type.match(/checkbox|radio/i);
                    const isMultiSelect = input.classList.contains('multiselect__input');
                    const isHidden = type && type.match(/hidden/i);

                    if (isCheckbox || isMultiSelect || isHidden) {
                        let field = input.parentElement;
                        while (!field.classList.contains('field')) {
                            field = field.parentElement
                        }
                        field.style.border = hasDirtyError ? "1px dashed red" : "none"
                    } else {
                        input.style.borderColor = hasDirtyError ? "red" : "#dbdbdb"
                    }
                }
            }
        },
        /**
         * Try to focus on the first error found
         * Fails silently
         */
        focusOnFirstError() {
            return Object.keys(this.formInput).find(inputName => {
                if (this.$v.formInput[inputName] && this.$v.formInput[inputName].$error) {
                    let input = this.findInputElement(this.$refs[inputName]);
                    console.log(input);
                    const $form = this.$refs.formWizard;

                    if (input) {
                        const inputTabIndex = $form.tabs.findIndex(
                            $tab => [...$tab.$el.querySelectorAll(INPUT_TAGS)].find(
                                element => input.isSameNode(element)
                            )
                        );

                        if (typeof inputTabIndex !== "undefined") {
                            // Change current form step if needed
                            $form.changeTab($form.activeTabIndex, inputTabIndex);

                            //console.log(inputTabIndex, $form.tabs[inputTabIndex]);

                            const tab = $form.tabs[inputTabIndex].$el;
                            tab.addEventListener('animationend', e => {
                                // Lets try to focus
                                try {
                                    input.focus();
                                } catch (error) {
                                    console.log(error)
                                }
                            }, {once: true});
                        }
                    }

                    return true;
                }
            });
        },
        onSaveButtonClick(e) {
            this.$emit('click-save-button');
        },
        onSaveButtonSubmit(e) {
            e.preventDefault();
            this.$emit('submit-save-button');
        },
        onPublishButtonClick(e) {
            this.$emit('click-publish-button');
        }
    },
};
