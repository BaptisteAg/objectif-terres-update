import FormNewAdMixin from './mixins/form-new-ad-mixin'
import Autocomplete from '../../../components/Autocomplete'

export default Vue.extend({
    mixins: [FormNewAdMixin],
    components: {
        Autocomplete
    },
    methods: {
        onZoneSelect(selectedZone) {
            this.selectedZones.push(selectedZone);
        },
        onZoneDataRender(item) {
            return {
                label: '<b>'+this.labelsByZoneType[item.value.type] + '</b>: ' + item.label,
                value: {
                    ...item.value,
                    originalLabel: item.label,
                    type: item.value.type
                },
            }
        }
    },
    data() {
        return {
            offerGenre: this.oldValues.offer_genre,
            isProductionGenreOther: false,
            selectedZones : this.oldValues.selected_zones ? JSON.parse(this.oldValues.selected_zones) : [],
            labelsByZoneType : {
                cities: 'Commune',
                departments: 'Département',
                regions: 'Région'
            }
        }
    }
});