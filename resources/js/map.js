const LeafletLazy = _ => import(/* webpackChunkName: "leaflet" */'leaflet');
const EsriLeafletLazy = _ => import(/* webpackChunkName: "esri-leaflet" */'esri-leaflet');

const token = 'pk.eyJ1IjoibWlja2l3YXkiLCJhIjoiY2s0YmE0NHZqMDZrejNrcGlxeWJmNHRtdCJ9.In4xuZz8wYnXmDX5jrrhCg';
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

        this.L.esri.basemapLayer('Imagery').addTo(map);
        this.L.esri.basemapLayer('ImageryLabels').addTo(map);

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
}

export default async function (id) {
    const mapController = new OSMapController(id);

    await mapController.loadLeaflet();

    return mapController;
}