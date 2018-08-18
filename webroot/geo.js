     var map;
		function initMap() {
		  var map = new google.maps.Map(document.getElementById('map'), {
			zoom: 8,
			center: {lat: 40.731, lng: -73.997}
		  });
		  var geocoder = new google.maps.Geocoder;
		  var infowindow = new google.maps.InfoWindow;

		  document.getElementById('submit').addEventListener('click', function() {
			geocodeLatLng(geocoder, map, infowindow);
		  });
		}

		function geocodeLatLng(geocoder, map, infowindow) {
			alert('ok');
		  var input = document.getElementById('latlng').value;
		  var latlngStr = input.split(',', 2);
		  var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
		  geocoder.geocode({'location': latlng}, function(results, status) {
			if (status === 'OK') {
			  if (results[0]) {
				map.setZoom(11);
				var marker = new google.maps.Marker({
				  position: latlng,
				  map: map
				});
				infowindow.setContent(results[0].formatted_address);
				infowindow.open(map, marker);
			  } else {
				window.alert('No results found');
			  }
			} else {
			  window.alert('Geocoder failed due to: ' + status);
			}
		  });
		}
		
		function getLatLng()
		{
			var geocoder = new google.maps.Geocoder();
			var address = document.getElementById('txtAddress').value;

			geocoder.geocode({ 'address': address }, function (results, status) {

				if (status == google.maps.GeocoderStatus.OK) {
					var latitude = results[0].geometry.location.lat();
					var longitude = results[0].geometry.location.lng();
					document.getElementById('geoloc').value = latitude + ',' + longitude;

					var map = new google.maps.Map(document.getElementById('map'), {
					  zoom: 14,
					  center: {lat: latitude, lng: longitude}
					});

					var marker = new google.maps.Marker({
					  position: {lat: latitude, lng: longitude},
					  map: map,
					  title: 'Hello World!'
					});
				}
			});
		}
		
		function getGeoLoc(results){
			var latitude = results[0].geometry.location.lat();
			var longitude = results[0].geometry.location.lng();
			document.getElementById('geoloc').value = latitude + ',' + longitude;

			var map = new google.maps.Map(document.getElementById('map'), {
			  zoom: 14,
			  center: {lat: latitude, lng: longitude}
			});

			var marker = new google.maps.Marker({
			  position: {lat: latitude, lng: longitude},
			  map: map,
			  title: 'Hello World!'
			});
		}
		
		function getPostalCode(){
			var geocoder = new google.maps.Geocoder();
			var address = document.getElementById('txtAddress').value;

			geocoder.geocode({ 'address': address }, function (results, status) {
				console.log(results);
				if (status == google.maps.GeocoderStatus.OK) {
					getGeoLoc(results);
					var addressok = 0;
					document.getElementById("txtCep").value = "";
					document.getElementById("txtNumber").value = "";
					for(i = 0; i < results[0].address_components.length; i++){
						if(results[0].address_components[i].types[0] == "postal_code"){
							document.getElementById("txtCep").value = results[0].address_components[i].long_name;
							addressok++;
						}
						if(results[0].address_components[i].types[0] == "street_number"){
							document.getElementById("txtNumber").value = results[0].address_components[i].long_name;
							addressok++;
						}
						if(results[0].address_components[i].types[0] == "administrative_area_level_2"){
							document.getElementById("txtCidade").value = results[0].address_components[i].long_name;
							addressok++;
						}
						if(results[0].address_components[i].types[0] == "administrative_area_level_1"){
							document.getElementById("txtEstado").value = results[0].address_components[i].short_name;
							addressok++;
						}
					}
					if(addressok==4){
						document.getElementById('txtAddress').value = results[0].formatted_address;
					} else {
						alert('o endereço não foi completamente localizado, pode estar faltando detalhes');
					}
				}
			});
		}