<template>
	<div>
		<b-button @click="showModal = true" rounded :type="buttonType" :size="buttonSize" :icon-left="buttonIcon"
				  :class="buttonIcon && isResponsive ? 'rounded-button-mobile' : ''"
				  :disabled="isDisable">
			<span :class="isResponsive ? 'is-hidden-touch' : ''">{{ buttonLabel }}</span>
		</b-button>
		<b-modal
			v-model="showModal"
			has-modal-card
			trap-focus
			:destroy-on-hide="false"
			aria-role="dialog"
			aria-label="Modal"
			close-button-aria-label="Close"
			aria-modal>
			<template #default="props">
				<div class="bg-beige objT-border p-6 p-5-mobile">
					<h3 class="title">{{ title }} : </h3>
					<p>{{ subtitle }}</p>
					<div class="mt-5">
						<slot></slot>
					</div>
				</div>
			</template>
		</b-modal>
	</div>
</template>

<script>
export default {
	props: {
		title: {
			type: String,
			default: '',
		},
		subtitle: {
			type: String,
			default: '',
		},
		buttonIcon: {
			type: String,
			default: '',
		},
		buttonLabel: {
			type: String,
			default: '',
		},
		buttonType: {
			type: String,
			default: '',
		},
		buttonSize: {
			type: String,
			default: '',
		},
		isDisable: {
			type: Boolean,
			default: false,
		},
		isResponsive: {
			type: Boolean,
			default: false,
		},
	},
	data() {
		return {
			showModal: false,
		}
	},
}
</script>
