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

window.regionMapInit  = async function (mapId, fetchOptions) {
    const mapController = await OSMapControllerFactory(mapId);

    const departmentsPolygonData = await fetchJson('/locations/polygon/departments/', fetchOptions);


    let featureGroup = mapController.addFeatureGroup();

    departmentsPolygonData.forEach(polygonData => {

        const polygon = mapController.addPolygon(polygonData, {
            smoothFactor: 2
        });

        featureGroup.addLayer(polygon);

        polygon.addEventListener('click', _ => {
            location.href = "/recherche?" +
                "ad_category=" + fetchOptions.ad_category +
                '&departments_location_researches_ids[]=' + polygonData.department_id;
        });

        mapController.bindTooltip(polygon, polygonData.ads_count.toString(), {
            className: "leaflet-tooltip-big"
        })
    });

    mapController.fitBounds(featureGroup.getBounds());
};
