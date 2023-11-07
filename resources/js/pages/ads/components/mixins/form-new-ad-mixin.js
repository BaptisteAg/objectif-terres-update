import Vue from "vue";

// Whitelist of html form inputs
const INPUT_TAGS = ['input', 'textarea', 'select'];

var smoothScrolls = [];

export default {
	props: {
		oldValues: Object,
		isSupportRequest: Boolean,
		supportRequestText: String,
		textContentTerritories: Object,
	},
	data() {
		return {
			uploading: false,
			textTerritoryContent: '',
			isInputDisabled: false,
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
		},
		"formInput.supportRequestTerritoryId": function (val) {
			Object.keys(this.textContentTerritories).forEach(key => {
				if (key.split('-')[6] === val) {
					this.textTerritoryContent = this.textContentTerritories[key].content
				}
			});
		}
	},
	methods: {
		// nextStep() {
		//     smoothScrolls.forEach(function (smoothScroll) {
		//         smoothScroll.destroy();
		//     });
		//     smoothScrolls = [];
		//
		//     const smoothScroll = new SmoothScroll();
		//
		//     const anchorElement = [].slice.call(
		//         document.querySelectorAll('.form-container')
		//     ).find(element => element.style.display !== "none");
		//
		//
		//     // Monkey patch for smoothScroll.js
		//     // Without this check, it bugs when attempting to scroll to the same current position
		//     // and indefinetly scroll
		//     const topPositionRelativeToWindow = Math.abs(anchorElement.getBoundingClientRect().top);
		//     if (parseInt(topPositionRelativeToWindow) > 0) {
		//         smoothScroll.animateScroll(anchorElement);
		//     }
		//
		//     smoothScrolls.push(smoothScroll);
		// },
		nextStep() {
			window.scrollTo({top: 0, behavior: 'smooth'})
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
		findInputContainerElement(element) {
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
				const hasDirtyError = validation?.$dirty && validation?.$error;

				if (hasDirtyError && !ref) {
					console.error(`Could not highlight error : No ref found for formInput.${key}`);
					continue;
				}

				if (validation && ref) {
					let field = this.findInputContainerElement(ref);

					// /!\ .field class must be placed on the input container
					while (!field.classList.contains('field')) {
						field = field.parentElement
					}
					field.classList.toggle('field-error', hasDirtyError);
				}
			}
		},
		/**
		 * Try to focus on the first error found
		 * Fails silently
		 */
		focusOnFirstError() {
			console.log('focusOnFirstError')
			const firstError = Object.keys(this.formInput).find(inputName => {
				if (this.$v.formInput[inputName] && this.$v.formInput[inputName].$error) {
					let input = this.findInputContainerElement(this.$refs[inputName]);
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

                            if(!$form.tabs?.[inputTabIndex]?.$el) {
                                console.error(`Could not focus on error : No tab found for input ${inputName}`);
                                return;
                            }

							const tab = $form.tabs[inputTabIndex].$el;
							tab.addEventListener('animationend', e => {
								// Lets try to focus
								try {
									input.focus();
								} catch (error) {
									console.log(error)
								}
							}, {once: true});
						} else {
							console.error(`Could not focus on error : No tab found for input ${inputName}`);
						}
					}
                    else {
                        console.error(`Could not focus on error : No ref found for input ${inputName}`);
                    }
					return true;
				}
			});
			if (!firstError) {
				// Get errors from $v
				const errors = Object.keys(this.$v.formInput).filter(inputName => {
					return this.$v.formInput[inputName] && this.$v.formInput[inputName].$error
				});
				console.error('Could not find any error to focus on. Errors left : ' + errors);
			}
			return firstError;
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
