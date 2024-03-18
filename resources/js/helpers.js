export const LocationHelper = {
    LABELS : {
        cities: 'Commune',
        departments: 'Département',
        regions: 'Région',
        zipcodesrange: 'Tous codes postaux',
        citiesrange: 'Toutes communes'
    },

    INPUT_NAME_RANGE_MAPPING : {
        citiesrange: 'cities',
        zipcodesrange: 'cities'
    },

    renderZoneItemData(item) {
        return {
            label: LocationHelper.getFormattedLabel(item),
            value: {
                ...item.value,
                originalLabel: item.label
            },
        }
    },
    getFormattedLabel(item) {
        if(!item.value) {
            return item
        }
        else {
            return '<b>' + LocationHelper.LABELS[item.value.type] + '</b>: ' + item.label;
        }
    },
    getLabel(key) {
        return LocationHelper.LABELS[key];
    },
    getInputNameRangeMapping(key) {
        return LocationHelper.INPUT_NAME_RANGE_MAPPING[key];
    }
}