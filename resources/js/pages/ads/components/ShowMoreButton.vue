<template>
	<div :class="(ad.showCities ? 'w-100' : 'w-50') + ' is-flex is-flex-wrap-wrap is-justify-content-space-between'">
		<div :class="ad.showCities ? 'w-50' : 'w-100'">
			<strong>Département{{ Object.keys(ad.secondaryDepartmentsList).length > 0 ? 's' : '' }} :</strong>
			{{ ad.mainDepartment.name }} ({{ ad.mainDepartment.code }})
			<div v-if="Object.keys(ad.secondaryDepartmentsList).length">
				<small v-if="!showAllDepartments">
					{{ secondaryDepartments() }}
					<br>
                    <template v-if="Object.keys(ad.secondaryDepartmentsList).length > 3">
                        (+ {{ Object.keys(ad.secondaryDepartmentsList).length - 3 }} autres)
                        <a @click.prevent="showAllDepartments = !showAllDepartments">Tout afficher</a>
                    </template>
				</small>
				<div v-else>
					{{
						Object.keys(ad.secondaryDepartmentsList).map(key => ad.secondaryDepartmentsList[key]).join(', ')
					}}
				</div>
			</div>
		</div>
		<div class="w-50" v-if="ad.showCities && Object.keys(ad.citiesList).length">
			<strong>Commune{{ Object.keys(ad.citiesList).length > 1 ? 's' : '' }} :</strong>
			<template v-if="!showAllCities">
				{{ Object.keys(ad.citiesList).slice(0, 3).map(key => ad.citiesList[key]).join(', ') + (Object.keys(ad.citiesList).length > 3 ? '...' : '') }}
				<br>
				<small v-if="Object.keys(ad.citiesList).length > 3">(+ {{ Object.keys(ad.citiesList).length - 3  }} autres)
					<a @click.prevent="showAllCities = !showAllCities">Tout afficher</a>
				</small>
			</template>
			<div v-else>
				{{ Object.keys(ad.citiesList).map(key => ad.citiesList[key]).join(', ') }}
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: 'ShowMoreButton',
	props: {
		ad: Object,
	},
	data() {
		return {
			showAllDepartments: false,
			showAllCities: false,
		};
	},
	methods: {
		secondaryDepartments() {
			let secondaryDepartmentsList = [];
			if (this.ad.secondaryDepartmentsList) {
				secondaryDepartmentsList = Object.keys(this.ad.secondaryDepartmentsList).slice(0, 3).map(key => this.ad.secondaryDepartmentsList[key])
				secondaryDepartmentsList = secondaryDepartmentsList.join(', ') + (Object.keys(this.ad.secondaryDepartmentsList).length > 3 ? '...' : '');
			}
			return secondaryDepartmentsList;
		}
	},
	mounted() {
	},
	computed: {}
};
</script>
