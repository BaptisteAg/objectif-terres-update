import {bounds} from "leaflet/dist/leaflet-src.esm";

const LeafletLazy = _ => import(/* webpackChunkName: "leaflet" */'leaflet');
const EsriLeafletLazy = _ => import(/* webpackChunkName: "leaflet-esri" */'esri-leaflet');

const centerCoords = [46.290552, 2.771017];

class OSMapController {
    constructor(id) {
        this.id = id;
    }

    async loadLeaflet() {
        this.L = await LeafletLazy();
        this.L.esri = await EsriLeafletLazy();

        this.initMap()
    }

    initMap() {
        const map = this.L.map(this.id, {
            center: centerCoords,
            zoom: 5,
            zoomControl: true,
            scrollWheelZoom: false
        });

        this.L.esri.basemapLayer("Streets").addTo(map);

        this.map = map;
    }

    addPolygon(polygonData, {color = '#b34818', smoothFactor = 0} = {}) {
        const polygon = this.L.geoJSON(polygonData.geojson, {
            smoothFactor: smoothFactor,
            style: {
                color: color
            }
        });

        polygon.addTo(this.map);

        return polygon
    }

    addFeatureGroup() {
        // Déclaration du nouveau feature group
        let drawnItems = new L.FeatureGroup();

        // Ajoute le feature group à la map
        this.map.addLayer(drawnItems);

        // return le feature group
        return drawnItems;
    }

    /**
     *
     * @param {Polygon} polygon
     * @param tooltipText
     * @param className
     */
    bindTooltip(polygon, tooltipText, {className = ""}) {
        polygon.bindTooltip(tooltipText, {
            permanent: true,
            direction: "center", className: 'leaflet-tooltip ' + className}
        ).openTooltip();

        polygon.addEventListener('mouseover', _ => {
            polygon._tooltip._contentNode.classList.add('leaflet-tooltip-mouseover')
        });
        polygon.addEventListener('mouseout', _ => {
            polygon._tooltip._contentNode.classList.remove('leaflet-tooltip-mouseover')
        });
    }

    bindPopup(polygon, popupHtml, { closable = true, open = false }) {
        const popup = this.L.popup({
            closeOnClick: closable,
            autoClose: closable,
            direction: top,
            maxWidth: 560
        }).setContent(popupHtml);

        polygon.bindPopup(popup);

        if(open) {
            polygon.openPopup();
        }

        return popup;
    }

    remove(polygon) {
        this.map.removeLayer(polygon);
    }

    /**
     *
     * @param {LatLng} layer
     */
    fitBounds(layer) {
        this.map.fitBounds(layer)
    }
}

export default async function (id) {
    const mapController = new OSMapController(id);

    await mapController.loadLeaflet();

    return mapController;
}