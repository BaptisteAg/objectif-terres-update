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
            oldValueSelected: '',
        },
        data() {
            const hasOldDate = this.oldValueSelected && this.oldValueSelected !== "null";
            let oldValueFormatted = {};
            if (hasOldDate){
                 oldValueFormatted = JSON.parse(this.oldValueSelected);
            }
            return {
                date: hasOldDate ? {
                    start: new Date(oldValueFormatted.start),
                    end: new Date(oldValueFormatted.end)
                } : null,
                mode: 'range',
            }
        },
        computed: {
            formattedDate() {
                if (!this.date || !this.date.start || !this.date.end) {
                    return []
                } else {
                    return [this.date.start.toLocaleDateString(), this.date.end.toLocaleDateString()]
                }
            },
        }
    }
</script>

