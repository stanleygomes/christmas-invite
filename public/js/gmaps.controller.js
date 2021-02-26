var markers = [],
	infoWindow = new google.maps.InfoWindow(),
	geocoder = new google.maps.Geocoder(),
	bounds,
	placesList = [],
	map = new google.maps.Map(document.getElementById('map_'), {
		scrollwheel: false,
		zoom: 7,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		zoomControlOptions: {
			position: google.maps.ControlPosition.RIGHT_TOP
		},
	});

var style = new google.maps.StyledMapType(
	[{
		featureType: 'all',
		stylers: [{
			saturation: -10
		}]
	}, {
		featureType: "road.arterial",
		elementType: "geometry",
		stylers: [{
			hue: "#f8f5c0"
		}, {
			saturation: 100
		}, {
			lightness: -30
		}, {
			gamma: 1.50
		}]
	}], {
		name: "Sermagri"
	}
);

map.mapTypes.set('s', style);
map.setMapTypeId('s');

var initialLocation = {
	lat: -14.969539,
	lng: -54.508424
};

function isset (v){
	if(typeof v !== 'undefined')
		return true;
	else
		return false;
}

if (navigator.geolocation) {
	navigator.geolocation.getCurrentPosition(function (position) {
		//nothing
	}, function () {

		$.post("/onde-encontrar/locais", {
			lat: initialLocation.lat,
			lng: initialLocation.lng
		}, function (data){

			placesList = data;

			createMarkers(data);

			if (data.length == 1) {
				map.setCenter({
					lat: parseFloat(data[0].latitude),
					lng: parseFloat(data[0].longitude)
				});
				map.setZoom(14);
			} else {
				map.fitBounds(bounds);
			}
		});
	});
}
else {
	//nothing
}

function createMarkers(onde_comprar) {
	for (var i = 0; i < markers.length; i++) {
		markers[i].setMap(null);
	}
	markers = [];
	bounds = new google.maps.LatLngBounds();

	$(onde_comprar).each(function (i, e) {
		var latLng = {
			lat: parseFloat(e.latitude),
			lng: parseFloat(e.longitude)
		};
		var titulo = e.titulo;

		var marker = new google.maps.Marker({
			position: latLng,
			map: map,
			title: titulo,
			animation: google.maps.Animation.DROP
		});

		var html = "<div style='font-size: 15px; max-width: 350px'>" +
			"<h3><strong>" + e.name + "</strong></h3>" + (e.street + (e.number != "" ? "," + e.number : '') +
			" - " + "district" + (e.zipcode != 0 ? " CEP" + e.zipcode : '')) +
			"<br>" + e.name + " - " + e.city + " / " + e.state +
			(e.email != "" ? ("<br><br>" + e.email) : "") +
			(e.phone != "" ? ("<br><br>" + e.phone) : "") +
			"<br><br><a target='_blank' href='//google.com.br/maps/dir//" + latLng.lat + "," + latLng.lng + "/@" + +latLng.lat + "," + latLng.lng + "z'><strong>COMO CHEGAR</strong></a>" +
			"</div>";

		google.maps.event.addListener(marker, 'click', function () {
			infoWindow.setContent(html);
			infoWindow.open(map, marker);
		});

		markers.push(marker);
		bounds.extend(marker.getPosition());
	});
}

function codeAddress(address, callback) {
	if (address == "") {
		callback(initialLocation);
	}

	geocoder.geocode({
		'address': address,
		componentRestrictions: {
			country: 'br'
		}
	}, function (results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			var latLng = {
				lat: results[0].geometry.location.lat(),
				lng: results[0].geometry.location.lng()
			};

			callback(latLng);
		} else {
			callback(null);
		}
	});
}

function showPlaces (data, latLng){

	// calcDistance(latLng);

	createMarkers(data);

	// if(data[0].distancia > 1000)
	// 	showModal("&nbsp;", "Nenhum local próximo foi encontrado. Exibindo os resultados mais próximos de " + key + ".");

	if (data.length == 1) {
		map.setCenter({
			lat: parseFloat(data[0].latitude),
			lng: parseFloat(data[0].longitude)
		});
		map.setZoom(14);
	} else if (data.length > 1) {

		if (data[0].distancia < 8) {
			map.setZoom(13);
		} else if (data[0].distancia < 20) {
			map.setZoom(12);
		} else if (data[0].distancia < 50) {
			map.setZoom(10);
		} else if (data[0].distancia < 90) {
			map.setZoom(9);
		} else if (data[0].distancia < 160) {
			map.setZoom(8);
		} else if (data[0].distancia < 350) {
			map.setZoom(7);
		} else if (data[0].distancia < 800) {
			map.setZoom(6);
		} else if (data[0].distancia < 1300) {
			map.setZoom(5);
		} else {
			map.setZoom(4);
		}

		if (data[0].distancia > 80)
			map.setCenter(latLng);
		else {
			map.setCenter({
				lat: parseFloat(data[0].latitude),
				lng: parseFloat(data[0].longitude)
			});
		}
	}
	// else
	// 	showModal("&nbsp;", "Nenhum representante encontrado nesta pesquisa.");
}

// function radians (v){
// 	return v * (180 / Math.PI);
// }

// function calcDistance (latLng){

// 	for(i = 0; i < placesList.length; i++){
// 		latitude = placesList[i].latitude;
// 		longitude = placesList[i].longitude;

// 		placesList[i].distancia = (6371 * Math.acos(Math.cos(radians(latLng.lat)) * Math.cos(radians(latLng.lat)) * Math.cos(radians(longitude) - radians(latLng.lng)) + Math.sin(radians(latLng.lat)) * Math.sin(radians(latitude))));
// 	}

// 	var ordering = placesList.slice(0);
// 	ordering.sort(function (a, b){
// 	    return a.distancia - b.distancia;
// 	});
// 	placesList = ordering;
// }

function searchPlaces(latLng) {

	var key = null;

	if (latLng === "todos")
		var  latLng = {lat : 0, lng : 0}
	else
		var key = $('#fieldfinder').val();

	if (latLng === null) {
		showModal("&nbsp;", "Nenhum local encontrado para esta busca.");
		return;
	}

	// if(placesList.length > 0){
	// 	showPlaces(placesList, latLng);
	// }
	// else{
	$.post("/onde-encontrar/buscar", {
		lat: latLng.lat,
		lng: latLng.lng,
		key: key
	}, function (data) {
		placesList = data;
		showPlaces(placesList, latLng);
	});
	// }
}

$("#findall").click(function (e){
	e.preventDefault();

	searchPlaces("todos");
	return false;
});

$("#formfinder").submit(function (e) {
	e.preventDefault();

	var val = $('#fieldfinder').val();

	codeAddress(val, function (latLng) {
		searchPlaces(latLng);
	});
});

