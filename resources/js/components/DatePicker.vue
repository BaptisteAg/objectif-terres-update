<template>
    <datepicker
            :language ="fr"
            :monday-first = "mondayFirst"
            calendar-button-icon = "fas fa-calendar-alt"
            input-class = "input"
            placeholder = "Plage de dates"
            :disabled-dates = "disabledDates"
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

                }
            }
        },

    }
</script>

