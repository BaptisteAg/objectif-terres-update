<section class="mb-6 field" ref="selectedDepartments">
    <label class="label">Département de référence *</label>
    <autocomplete
            name="department_id"
            id="department_id"
            autocomplete="off"
            src="/locations/departments"
            placeholder="Saisissez au moins 2 caractères pour faire apparaître la liste"
            v-model="formInput.selectedDepartments"
            :vuelidate="$v.formInput.selectedDepartments"
    >
        <template v-for="(zone, i) in formInput.selectedDepartments">
            <input
                    key="zone.id"
                    autocomplete="off"
                    type="hidden"
                    name="department_id"
                    :value="zone.value.id"
            >
            <div
                    key="zone.label"
                    class="tag autocomplete-input-tag is-info"
                    @click="_ => formInput.selectedDepartments.splice(i, 1)"
            >
                @{{ zone.label }}
                <i class="fa fa-trash" style="cursor:pointer; margin-left: 0.5em;"></i>
            </div>
        </template>
        <input type="hidden" :disabled="disabled" name="selected_departments" :value="JSON.stringify(formInput.selectedDepartments)">
    </autocomplete>
</section>
