import OSMapControllerFactory from "../../map"

/*import {Pagination} from 'vue-pagination-2';
import Vue from 'vue';

Vue.Component('search', {
    components: {
        Pagination,
    },
    props: {
        options : {
            theme : 'bulma',
        },
    }
});*/

window.regionMapInit  = async function (mapId, queryString) {
    const mapController = await OSMapControllerFactory(mapId);

    let departmentsPolygonData = await fetchJson('/locations/polygon/departments/?' + queryString);

    let featureGroup = mapController.addFeatureGroup();

    if(typeof departmentsPolygonData === 'object') {
        departmentsPolygonData = Object.values(departmentsPolygonData);
    }

    departmentsPolygonData.forEach(polygonData => {

        const polygon = mapController.addPolygon(polygonData, {
            smoothFactor: 2
        });

        featureGroup.addLayer(polygon);

        polygon.addEventListener('click', _ => {
            location.href = "/recherche?" + queryString + '&departments[]=' + polygonData.department_id;
        });

        mapController.bindTooltip(polygon, polygonData.ads_count.toString(), {
            className: "leaflet-tooltip-big"
        })
    });

    mapController.fitBounds(featureGroup.getBounds());
};
