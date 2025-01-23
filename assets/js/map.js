const defaultLocation = [37.764848, 125.625902];

const map = L.map('map');

map.locate({ setView: true, maxZoom: 20 });
L.control.scale().addTo(map);

const poiNodes = new Map();

let layers = [];

function setView(location, zoom) {
	const mapView = map.setView(location, zoom);
	let tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 20,
		attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
	}).addTo(map);
}

function addPoint(node, icon, title) {
	const { id, lat, lon } = node;
	const marker = L.marker([lat, lon], { icon: icon }).addTo(map);
	if (title)
		marker.bindPopup(title);
	layers.push(marker);
}

function getMiddlePoint(coordsList) {
	let size = 0;
	let final = [0, 0];
	coordsList.forEach(coord => {
		final[0] += coord[0];
		final[1] += coord[1];
		size++;
	});
	final[0] /= size;
	final[1] /= size;
	return final;
}

function addPolygon(node, polyIcon, color, title) {
	let coordsList = [];
	node.nodes.forEach(nodeID => {
		const coords = poiNodes.get(nodeID);
		coordsList.push(coords);
	});
	const polygon = L.polygon(coordsList, { color: color }).addTo(map);
	const middle = getMiddlePoint(coordsList);
	const marker = L.marker(middle, { icon: polyIcon }).addTo(map);
	if (title)
		marker.bindPopup(title);
	layers.push(marker);
	layers.push(polygon);
}

function clearMakers() {
	layers.forEach(layer => {
		map.removeLayer(layer);
	});
	layers = [];
}

function processPOI(poi) {
	const tags = poi.tags;
	if (poi.type == "node") {
		poiNodes.set(poi.id, [poi.lat, poi.lon]);
		if (tags && tags.emergency == "defibrillator") {
			addPoint(poi, defIcon, tags["defibrillator:location"]);
		}
	}
}

function processArea(poi) {
	if (poi.type == "way") {
		const tags = poi.tags;
		if (tags.amenity == "hospital") {
			addPolygon(poi, hosIcon, "red", tags.name);
		}
		if (tags.landuse == "cemetery") {
			let popupText = "";
			if (tags.name) {
				popupText = tags.name;
				if (tags["cemetery:capacity"])
					popupText += "<br>Capacité : " + tags["cemetery:capacity"];
			}
			addPolygon(poi, cimIcon, "black", popupText);
		}
	}
}

function processPOIs(pois) {
	pois.forEach(poi => {
		processPOI(poi);
	});
	pois.forEach(poi => {
		processArea(poi);
	});
}

function processResponse(response) {
	const elements = response.elements;
	clearMakers();
	processPOIs(elements);
}

function updatePois() {
	const center = map.getCenter();
	const search_radius = 6378137 / (2 ** (map.getZoom() - 5));
	console.log(search_radius);
	if (search_radius < 25000)
		httpGet(getDefibrilatorAroundRequest(center.lat, center.lng, search_radius));
	else
		clearMakers();
}

map.addEventListener("locationerror", function (event) {
	setView(defaultLocation, 19);
	document.getElementById("locate_status").innerText = "La localisation a été refusée !";
});

map.addEventListener("locationfound", function (event) {
	setView(event.latlng, 16);
	document.getElementById("locate_status").innerText = "La localisation a été acceptée !";
});

map.addEventListener("moveend", function (event) {
	updatePois();
});

function getBaseURL() {
	return "https://overpass-api.de/api/interpreter";
}

function httpGet(theUrl) {
	fetch(theUrl).then((response) => response.json().then((data) => processResponse(data)));
}

function getDefibrilatorAroundRequest(lat, lon, search_radius) {
	var baseURL = getBaseURL();
	const url = `${baseURL}?data=[out:json][timeout:5];
	(
	node[\"emergency\"=\"defibrillator\"](around:${search_radius},${lat},${lon});
	way[\"amenity\"=\"hospital\"](around:${search_radius},${lat},${lon});
	way[\"landuse\"=\"cemetery\"](around:${search_radius},${lat},${lon});
	);out;>;out skel qt;`;
	return url;
}