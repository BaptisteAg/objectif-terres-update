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
            oldValue : ''
        },
        data() {
            let date =this.oldValue.split('/');
            let dateFormatted = date[2]+'-'+date[1]+'-'+date[0];
            let d = new Date();
            return {
                fr: fr,
                mondayFirst: true,
                disabledDates: {
                    from: new Date(Date.now()),

                },
                highlighted: {
                    to: new Date(Date.now()),
                    from:this.oldValue ? new Date(dateFormatted) : d.setDate(d.getDate() -7),
                }
            }
        },

    }
</script>

