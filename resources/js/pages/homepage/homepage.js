import OSMapControllerFactory from "../../map"

window.homepageMapInit  = async function (id) {
    const mapController = await OSMapControllerFactory(id);

    const polygonData = await fetchJson('/locations/polygon/france');

    const francePolygon = mapController.addPolygon(polygonData, {
        smoothFactor: 2
    });

    mapController.bindPopup(francePolygon, `
				<form id="leaflet-preform" action="/recherche">
					<div class="select form-field">
						<select name="offer_type">
							<option value="OfferAd">Je cherche</option>
							<option value="SeekAd">Je propose</option>
						</select>
					</div>
					<div class="select form-field">
						<select name="ad_category">
							<option value="land">une terre</option>
							<option value="job">un emploi</option>
						</select>
					</div>
					<button class="button is-normal basic primary">ok</button>
				</form>
			`, {closable: false, open: true});

    const form = document.getElementById("leaflet-preform");

    form.addEventListener('submit', async function (event) {
        event.preventDefault();

        form.querySelector('button').innerHTML = '<i class="fa fa-spinner fa-spin" style="font-size:25px;margin-top:8px;"></i>';

        const formData = new FormData(form);

        const regionsPolygonData = await fetchJson('/locations/polygon/regions', formData);

        let featureGroup = mapController.addFeatureGroup();

        if (!regionsPolygonData.length) {
            alert("Désolé, il n'y a pas d'annonce de ce type pour l'instant.");
            form.querySelector('button').innerHTML = "ok";
            return;
        }

        mapController.remove(francePolygon);

        regionsPolygonData.forEach(polygonData => {
            const polygon = mapController.addPolygon(polygonData, {
                smoothFactor: 2
            });

            featureGroup.addLayer(polygon);

            polygon.addEventListener('click', _ => {
                location.href = "/recherche?" +
                    "offer_type=" + formData.get('offer_type') +
                    "&ad_category=" + formData.get('ad_category') +
                    '&regions_location_researches_ids[]=' + polygonData.region_id;
            });

            mapController.bindTooltip(polygon, polygonData.ads_count.toString() + " annonce"+(polygonData.ads_count > 1 ?"s" : ''), {
                className: "leaflet-tooltip-big"
            })
        });

        mapController.fitBounds(featureGroup.getBounds());
    });
};