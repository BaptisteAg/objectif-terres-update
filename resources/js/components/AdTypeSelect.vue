<template>
	<div>
		<div v-show="value === ''" class="adTypes-container">

			<h1 class="title">Formulaire de {{ onEdit ? 'modification' : 'dépôt' }} d’annonces</h1>
			<p>Objectif Terre est une plateforme ayant pour but de mettre en liens les personnes ayant des projets
				agricoles
				professionnels définis. Si votre annonce ne rentre pas dans cette catégorie (exemple : habitat
				collectif,
				volontariat, partage de jardin, chantier participatif...), veuillez vous référer à la FAQ mise à votre
				disposition pour vous rendre sur la plateforme adaptée à votre besoin.</p>
			<div :class="errors.check ? 'field-error mt-2 pt-2' : 'mt-2 pt-2'">
				<b-field :type="errors.check ? 'is-danger' : ''" :message="errors.check"
						 class="is-flex is-flex-direction-column">
					<b-checkbox v-model="hasCertified" name="has_certified" class="has-text-weight-bold is-size-6">
						<slot name="certified"></slot>
					</b-checkbox>
				</b-field>
			</div>

			<hr class="is-primary">

			<h3 class="title is-4">Je {{ onEdit ? 'modifie' : 'dépose' }} cette annonce</h3>
			<div class="block">
				<b-radio v-model="adContactType" name="ad_contact_type" native-value="me">En mon nom</b-radio>
				<b-radio v-model="adContactType" name="ad_contact_type" native-value="thirdParty">Pour une autre
					personne
				</b-radio>
			</div>

			<div class="pb-4 is-flex is-flex-wrap-wrap is-justify-content-space-between"
				 v-if="adContactType === 'thirdParty'">

				<p>
					Les coordonnées de la personne pour qui je dépose l'annonce, qui seront visibles par les personnes
					qui
					consultent l'annonce.
				</p><br><br>

				<b-field class="w-50 is-size-6" label="Email *" :type="errors.email ? 'is-danger' : ''"
						 :message="errors.email">
					<b-input name="third_party[email]" placeholder="jean.dupont@gmail.com" size="is-medium" rounded
							 type="email"
							 v-model="thirdParty.email"></b-input>
				</b-field>
				<b-field class="w-50 is-size-6" label="Prénom *" :type="errors.firstName ? 'is-danger' : ''"
						 :message="errors.firstName">
					<b-input name="third_party[first_name]" placeholder="Jean" size="is-medium" rounded type="text"
							 v-model="thirdParty.first_name"
					></b-input>
				</b-field>
				<b-field class="w-50 is-size-6" label="Nom *" :type="errors.lastName ? 'is-danger' : ''"
						 :message="errors.lastName">
					<b-input name="third_party[last_name]" placeholder="Dupont" size="is-medium" rounded type="text"
							 v-model="thirdParty.last_name"
					></b-input>
				</b-field>
				<b-field class="w-50 is-size-6" label="Téléphone" :type="errors.phone ? 'is-danger' : ''"
						 :message="errors.phone">
					<b-input name="third_party[phone]" placeholder="06 06 06 06 06" size="is-medium" rounded type="text"
							 v-model="thirdParty.phone"
					></b-input>
				</b-field>
			</div>
			<div v-else>

				<b-field>
					<b-checkbox v-model="accept_share_contact_infos" true-value="0"
								false-value="1" class="is-size-6">Je ne souhaite pas être contacté par téléphone (dans
						ce cas, je serais contacté uniquement par email)
					</b-checkbox>
					<input type="hidden" name="accept_share_contact_infos" :value="accept_share_contact_infos || 1">
				</b-field>
			</div>

			<section :class="errors.adType ? 'field-error mt-5' : 'mt-5'" v-show="!onEdit">
				<h3 class="title is-4">Mon projet</h3>
				<p class="pb-4 help is-danger" v-show="errors.adType">Le type d'annonce n'est pas défini.</p>
				<div class="is-flex-wrap-wrap is-flex is-justify-content-space-between gap-5">
					<div v-for="(adType,adTypeValue) in adTypes"
						 class="bg-beige is-clickable p-5 w-30 is-flex is-justify-content-center is-align-items-center has-text-centered objT-border"
						 :class="{'bg-blue': currentAdType === adTypeValue}" @click="currentAdType = adTypeValue">
						{{ adType.label }}
					</div>
				</div>
			</section>

			<div class="is-flex is-justify-content-flex-end pt-6">
				<b-button size="is-medium" class="ml-2" rounded type="is-danger" @click="setAdType">Etape suivante
				</b-button>
			</div>

		</div>
		<div class="is-align-self-flex-start py-3" v-show="value !== ''">
			<a class="button is-rounded is-danger" href="#" @click.prevent="changeAdType()">
				<b-icon
					class="mr-1"
					icon="chevron-left"
					size="is-small">
				</b-icon>
				Changer de formulaire ou de bénéficiaire</a>
		</div>

		<input type="hidden" :name="name" :value="value">

	</div>
</template>

<script>
export default {
	props: {
		oldValues: {
			type: Object
		},
		value: {
			type: String
		},
		name: {
			type: String,
			required: true
		},
		onEdit: {
			type: Boolean,
			default: false
		}
	},
	data() {
		let old = this.oldValues;

		return {
			errors: {
				check: '',
				email: '',
				firstName: '',
				lastName: '',
				phone: '',
				adType: '',
			},
			adContactType: old.ad_contact_type || 'me',
			thirdParty: {
				first_name: old.third_party?.first_name || "",
				last_name: old.third_party?.last_name || "",
				email: old.third_party?.email || "",
				phone: old.third_party?.phone || "",
			},
			accept_share_contact_infos: old.accept_share_contact_infos,
			hasCertified: !!old.id,
			currentAdType: this.value
		}
	},
	computed: {
		adTypes() {
			return {
				land_seek: {
					label: "Recherche de terres agricoles",
				},
				associate_seek: {
					label: "Recherche d'associé.es pour projet d'installation",
				},
				job_seek: {
					label: "Recherche d'experience agricole (emploi salarié, stage, espace-test)",
				},
				land_offer: {
					label: "Offre de terres agricoles",
				},
				associate_offer: {
					label: "Recherche d'associé.es sur ferme existante",
				},
				job_offer: {
					label: "Offre de stages, d'emploi ou de tests, agricoles",
				},
			}
		},
	},
	methods: {
		validateFields() {
			this.errors = {
				check: '',
				email: '',
				firstName: '',
				lastName: '',
				phone: '',
				adType: '',
			};

			if (!this.hasCertified) {
				this.errors.check = 'Vous devez certifier que votre annonce concerne un projet agricole professionnel.';
				window.scrollTo({top: 0, behavior: 'smooth'});
			}

			if (!this.currentAdType) {
				this.errors.adType = true;
			}

			if (this.adContactType === 'thirdParty') {
				let emailRegex = /^[\w-]+(.[\w-]+)*@([\w-]+.)+[a-zA-Z]{2,7}$/;
				if (!emailRegex.test(this.thirdParty.email)) {
					this.errors.email = "L'email n'est pas valide.";
				}
				if (!this.thirdParty.first_name) {
					this.errors.firstName = 'Le prénom est requis.';
				}
				if (!this.thirdParty.last_name) {
					this.errors.lastName = 'Le nom est requis.';
				}
				if (!this.currentAdType) {
					this.errors.adType = "Le type d'annonce n'est pas défini.";
				}
			}

			return Object.values(this.errors).every(error => !error);
		},
		created() {
			this.currentAdType = this.value;
		},
		setAdType() {
			if (this.validateFields()) {
				this.$emit('input', this.currentAdType);
			}
		},
		changeAdType() {
			this.$emit('input', '');
		}
	},
}
</script>
