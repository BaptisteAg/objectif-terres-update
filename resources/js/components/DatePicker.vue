<template>
    <div class="control has-icon-right">
        <datepicker
                :language="fr"
                :monday-first="mondayFirst"
                calendar-button-icon="fas fa-calendar-alt"
                input-class="input"
                name="date_research_range"
                placeholder="Plage de dates"
                format="dd/MM/yyyy"
                :disabled-dates="disabledDates"
                v-model="highlighted.from"
                :highlighted="highlighted"
        >
        </datepicker>
        <span class="icon is-small is-right">
            <i class=" fa fa-calendar"></i>
        </span>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker'
    import {fr} from 'vuejs-datepicker/dist/locale'

    export default {
        components: {
            Datepicker
        },
        props: {
            calendarClass: String,
            inputClass: String,
        },
        data() {
            return {
                fr: fr,
                mondayFirst: true,
                disabledDates: {
                    from: new Date(Date.now()),

                },
                highlighted: {
                    to: new Date(Date.now()),
                    from: new Date().setDate(Date.now()) - 6,
                },
            }
        },

    }
</script>

