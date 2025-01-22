const defaultLocation = [37.764848, 125.625902];

const map = L.map('map');

map.locate({ setView: true, maxZoom: 20 });

const poiNodes = new Map();

function setView(location, zoom) {
	const mapView = map.setView(location, zoom);
	let tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 20,
		attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
	}).addTo(map);
}

function addPoint(node, icon) {
	const { id, lat, lon } = node;
	L.marker([lat, lon], { icon: icon }).addTo(map);
}

function getMiddlePoint(coordsList) {
	let size = 0;
	let final = [0, 0];
	coordsList.forEach(coord => {
		console.log(coord);
		final[0] += coord[0];
		final[1] += coord[1];
		size ++;
	});
	final[0] /= size;
	final[1] /= size;
	return final;
}

function addPolygon(node, polyIcon, color) {
	let coordsList = [];
	node.nodes.forEach(nodeID => {
		const coords = poiNodes.get(nodeID);
		console.log(nodeID);
		coordsList.push(coords);
	});
	L.polygon(coordsList, {color: color}).addTo(map);
	const middle = getMiddlePoint(coordsList);
	L.marker(middle, { icon: polyIcon }).addTo(map);
}

function processPOI(poi) {
	const tags = poi.tags;
	if (poi.type == "node") {
		poiNodes.set(poi.id, [poi.lat, poi.lon]);
		if (tags && tags.emergency == "defibrillator") {
			addPoint(poi, defIcon);
		}
	}
}

function processArea(poi) {
	if (poi.type == "way") {
		const tags = poi.tags;
		if (tags.amenity == "hospital") {
			addPolygon(poi, hosIcon, "red");
		}
		if (tags.landuse == "cemetery") {
			addPolygon(poi, cimIcon, "black");
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

function updatePois() {
	const center = map.getCenter();
	const search_radius = 2000;
	const httpResponse = JSON.parse(httpGet(getDefibrilatorAroundRequest(center.lat, center.lng, search_radius)));
	const elements = httpResponse.elements;
	processPOIs(elements);
}

map.addEventListener("locationerror", function (event) {
	setView(defaultLocation, 19);
	document.getElementById("locate_status").innerText = "La localisation a été refusée !";
	document.getElementById("update-btn").disabled = false;
});

map.addEventListener("locationfound", function (event) {
	setView(event.latlng, 16);
	document.getElementById("locate_status").innerText = "La localisation a été acceptée !";
	updatePois();
	document.getElementById("update-btn").disabled = false;
});

function getBaseURL() {
	return "https://overpass-api.de/api/interpreter";
}

function httpGet(theUrl) {
	var xmlHttp = new XMLHttpRequest();
	xmlHttp.open("GET", theUrl, false); // false for synchronous request
	xmlHttp.send(null);
	return xmlHttp.responseText;
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