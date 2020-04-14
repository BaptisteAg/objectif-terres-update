<template>
    <div class="control has-icon-right">
        <input type="hidden" :value="JSON.stringify(date) " name="date-range-selected">
        <date-picker
                mode='range'
                v-model='date'
                :max-date='new Date(Date.now())'
                :is-required=true
                :input-props='{
                         placeholder: "Séléctionner une plage de date"}'
        >
        </date-picker>
        <p class="text-red-600 text-xs italic mt-1" v-if="errorMessage">
            {{ errorMessage }}
        </p>
        <input type="hidden" :value="formattedDate[0]" name="date_from">
        <input type="hidden" :value="formattedDate[1]" name="date_to">
        <span class="icon is-small is-right">
            <i class=" fa fa-calendar"></i>
        </span>
    </div>
</template>

<script>
    import DatePicker from 'v-calendar/lib/components/date-picker.umd';

    export default {
        components: {
            DatePicker
        },
        props: {
            oldValue: '',
        },
        data() {
            return {
                date: null,
                mode: 'range',
            }
        },
        computed: {
            formattedDate() {
                if (this.date === null) {
                    return []
                } else {
                    return [this.date.start.toLocaleDateString(), this.date.end.toLocaleDateString()]
                }
            },
        }
    }
</script>

