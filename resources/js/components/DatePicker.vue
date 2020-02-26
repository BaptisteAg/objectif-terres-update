<template>
    <datepicker
            :language ="fr"
            :monday-first = "mondayFirst"
            calendar-button-icon = "fas fa-calendar-alt"
            input-class = "input"
            name="dateResearchRange"
            placeholder = "Plage de dates"
            :disabled-dates = "disabledDates"
            v-model = "highlighted.from"
            :highlighted="highlighted"
            >

    </datepicker>
</template>

<script>
    import Datepicker from 'vuejs-datepicker'
    import {fr} from 'vuejs-datepicker/dist/locale'
    export default {
        components: {
            Datepicker
        },
        props:{
          calendarClass : String,
          inputClass: String,
        },
        data(){
            return{
                fr: fr,
                mondayFirst :true,
                disabledDates: {
                    from: new Date(Date.now()),

                },
                highlighted : {
                    to : new Date(Date.now()),
                    from : new Date(Date.now()),
                },
            }
        },

    }
</script>

