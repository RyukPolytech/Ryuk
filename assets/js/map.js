const defaultLocation = [37.764848, 125.625902];

const map = L.map('map');

map.locate({ setView: true, maxZoom: 20 });

function setView(location, zoom) {
	const mapView = map.setView(location, zoom);
	let tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 20,
		attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
	}).addTo(map);
}

function processNode(node) {
	const { id, lat, lon } = node;
	L.marker([lat, lon], {icon: defIcon}).addTo(map);
}

function processPOI(poi) {
	if (poi.type == "node") {
		processNode(poi);
	}
}

function processPOIs(pois) {
	pois.forEach(poi => {
		processPOI(poi);
	});
}

map.addEventListener("locationerror", function (event) {
	setView(defaultLocation, 19);
	document.getElementById("locate_status").innerText = "La localisation a été refusée !";
});

map.addEventListener("locationfound", function (event) {
	setView(event.latlng, 16);
	document.getElementById("locate_status").innerText = "La localisation a été acceptée !";
	const search_radius = 2000;
	const httpResponse = JSON.parse(httpGet(getDefibrilatorAroundRequest(event.latlng.lat, event.latlng.lng, search_radius)));
	const elements = httpResponse.elements;
	processPOIs(elements);
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
	);out;>;out skel qt;`;
	return url;
}