<template>
	<div>
		<div class="w-50">
			<strong>Département :</strong>
			{{ ad.departments.name }} ({{ ad.departments.code }})
			<div v-if="ad.secondaryDepartmentsList && ad.secondaryDepartmentsList.length">
				<br><small>
				{{ slicedSecondaryDepartments.join(', ') }}
				<span v-if="ad.secondaryDepartmentsList.length > 3 && !showAllDepartments">
            , ... ({{ ad.secondaryDepartmentsList.length - 3 }} autres)
          </span>
				<button @click="showAllDepartments = !showAllDepartments">
					{{ showAllDepartments ? 'Afficher moins' : 'Afficher plus' }}
				</button>
			</small>
			</div>
		</div>

		<div class="w-50" v-if="displayCitiesCondition">
			<strong>Commune{{ ad.citiesList.length > 1 ? 's' : '' }} :</strong>
			{{ slicedCitiesList }}
			<div v-if="!showCities">
				<br><small>(non visible pour les autres utilisateurs)</small>
			</div>
			<button v-if="ad.citiesList.length > 3" @click="showAllCities = !showAllCities">
				{{ showAllCities ? 'Afficher moins' : 'Afficher plus' }}
			</button>
		</div>
	</div>
</template>

<script>
export default {
	name: 'AdDetail',
	props: {
		ad: Object,
		user: Object,
		showCities: {
			type: Boolean,
			default: false
		},
	},
	data() {
		return {
			showAllDepartments: false,
			showAllCities: false,
		};
	},
	created() {
		console.log(this.ad)
	},
	computed: {
		displayCitiesCondition() {
			return this.showCities || this.user.id === this.ad.user_pp_id || this.user.role >= 1;
		},
		slicedSecondaryDepartments() {
			return this.showAllDepartments ?
				this.ad.secondaryDepartmentsList :
				this.ad.secondaryDepartmentsList.slice(0, 3);
		},
		slicedCitiesList() {
			return this.showAllCities ?
				this.ad.citiesList :
				this.ad.citiesList.slice(0, 3);
		},
	}
};
</script>
