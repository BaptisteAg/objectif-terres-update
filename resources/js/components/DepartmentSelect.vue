<template>
  <div>
    <b-dropdown expanded v-model="selectedDepartments" aria-role="list" class="mb-3" multiple>
      <template #trigger="{ active }">
        <b-button
            :label="departmentsLabel()"
            :icon-right="active ? 'menu-up' : 'menu-down'"/>
      </template>

      <b-dropdown-item v-for="(department, index) in departments" :key="index" aria-role="listitem"
                       :value="department.id">
        {{ department.name }}
      </b-dropdown-item>
    </b-dropdown>
  </div>

</template>
<script>
export default {
  props: ['departments'],
  data() {
    return {
      selectedDepartments: [],
    }
  },
  methods: {
    departmentsLabel() {
      if (this.selectedDepartments.length === 0) {
        return 'Tous les départements'
      }

      if (this.selectedDepartments.length === this.departments.length) {
        return 'Tous les départements'
      }

      if (this.selectedDepartments.length === 1) {
        return this.departments.find(department => department.id === this.selectedDepartments[0]).name
      }

      return `${this.selectedDepartments.length} départements sélectionnés`
    }
  }
}
</script>