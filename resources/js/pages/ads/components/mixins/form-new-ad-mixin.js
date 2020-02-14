import Vue from "vue";
import {maxLength, minLength, required} from "vuelidate/lib/validators";

// Whitelist of html form inputs
const INPUT_TAGS = ['input', 'textarea', 'select'];

export default {
    props: {
        oldValues: Object,
        isInputDisabled: Boolean,
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

        // Initiate correctly existing documents
        if (Array.isArray(this.formInput.documents) && this.formInput.documents.length) {
            const dropzone = this.getDropzone();

            // Dropzone requirements for file object properties are the same as DB document object definition
            this.formInput.documents.forEach(document => {
                dropzone.emit("addedfile", document);
                dropzone.emit("thumbnail", document, document.path);
                dropzone.emit("complete", document);
            })
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
        getDropzone() {
            return this.$refs.documents.$refs.dropzoneElement.dropzone
        },
        /**
         * Handler for dropzone event, before documents are uploaded
         */
        onBeforeDocumentsUpload(files, xhr, formData) {
            formData.append('_token', window.csrf_token);
            formData.append('type', 'ads');
            this.uploading = true;
        },
        /**
         * Set inputs border color ( red or initial ) based on error status
         */
        onSuccessDocumentsUpload(files, documents) {
            if (documents.length) {
                documents.forEach(document => this.formInput.documents.push(document));
            }
            this.uploading = false;
        },
        /**
         * Set inputs border color ( red or initial ) based on error status
         */
        onRemoveUploadedDocument(file) {
            console.log(this.getDropzone().getAcceptedFiles())
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
            _(this.formInput).forEach((value, key) => {
                const validation = this.$v.formInput[key];
                const ref = this.$refs[key];

                // The ref and its validation exists
                if (validation && ref) {
                    const input = this.findInputElement(ref);
                    const hasDirtyError = validation.$dirty && validation.$error;
                    const type = input.getAttribute("type");
                    const isCheckbox = type && type.match(/checkbox|radio/i);
                    const isMultiSelect = input.classList.contains('multiselect__input');

                    if (isCheckbox || isMultiSelect) {
                        let field = input.parentElement;
                        while (!field.classList.contains('field')) {
                            field = field.parentElement
                        }
                        field.style.border = hasDirtyError ? "1px dashed red" : "none"
                    } else {
                        input.style.borderColor = hasDirtyError ? "red" : "#dbdbdb"
                    }
                }
            })
        },
        /**
         * Try to focus on the first error found
         */
        focusOnFirstError() {
            for (let key in Object.keys(this.$v.formInput)) {
                const inputName = Object.keys(this.$v.formInput)[key];

                // Filter out vuelidate private props
                if (inputName.includes("$")) continue;

                if (this.$v.formInput[inputName].$error) {
                    let input = this.findInputElement(this.$refs[inputName]);
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

                            const tab = $form.tabs[inputTabIndex].$el;
                            tab.addEventListener('animationend', e => {
                                // Lets try to focus
                                try {
                                    input.focus();
                                } catch (error) {
                                    console.log(error)
                                }
                            });
                        }
                    }

                    return true;
                }
            }
        }
    },
    validations: {
        formInput: {
            aboutProject: {
                minLength: minLength(5),
                maxLength: maxLength(1000),
                required
            },
            aboutContent: {
                minLength: minLength(5),
                maxLength: maxLength(1000),
                required
            },
            title: {
                required,
                minLength: minLength(5),
            },
            documents: {
                /**
                 * Only one PDF file is admitted
                 *
                 * @param {array} documents
                 * @returns {boolean}
                 */
                onePdf(documents) {
                    return documents.reduce((pdfCount, document) => {
                        return pdfCount + (document.type === "application/pdf");
                    }, 0) <= 1;
                },
                notCurrentlyUploading() {
                    return !this.uploading;
                }
            }
        }
    }
};
