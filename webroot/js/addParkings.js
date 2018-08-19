function getLatLng(address){
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({ 'address': address }, function (results, status) {

        if (status == google.maps.GeocoderStatus.OK) {
            var latitude = results[0].geometry.location.lat();
            var longitude = results[0].geometry.location.lng();
            document.getElementById('lat').value = latitude;
            document.getElementById('lng').value = longitude;
            
            var map = new google.maps.Map(document.getElementById('map_canvas'), {
                zoom: 16,
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
function getLatLngFromAddr(){
    var address = document.getElementById('address').value+', '+document.getElementById('number').value;
    getLatLng(address);
}
function getLatLngFromZip(){
    var address = document.getElementById('address').value;
    var zip = document.getElementById('zipcode').value;
    var latitude = document.getElementById('lat').value;
    if(latitude==false || address==false)
        getLatLng(zip);
}