var geocoder;
var map;
var infowindow;
var marker;
function initialize() {
    geocoder = new google.maps.Geocoder();
    infowindow = new google.maps.InfoWindow();
    var position = new google.maps.LatLng(40.437248, -3.649104);
    //var position = findPosition("Polideportivo pueblo nuevo", "ascao", "Comunidad de Madrid", "Madrid", "Madrid");
    var mapOptions = {
        zoom: 16,
        center: position,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

    marker = new google.maps.Marker({
        map: map,
        position: map.getCenter()
    });
}

function findPosition() {
    var placeToFind = "";
    var address = $("form").find(".center-address").val();
    if (address.length > 0) {
        placeToFind += address + " ";
    }
    var city = $("form").find(".center-city").val();
    if (city.length > 0) {
        placeToFind += city + " ";
    }
    var community = $("form").find(".center-community").val();
    if (community.length > 0) {
        placeToFind += community + " ";
    }
    var province = $("form").find(".center-province").val();
    if (province.length > 0) {
        placeToFind += province;
    }
    console.log(placeToFind);

    geocoder.geocode({'address': placeToFind}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
            marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location
            });
        } else {
            alert("Geocode was not successful for the following reason: " + status);
        }
    });
}
function findMe() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = new google.maps.LatLng(position.coords.latitude,
                    position.coords.longitude);
            map.setCenter(pos);
            marker = new google.maps.Marker({
                map: map,
                position: pos
            });

            map.setCenter(pos);
            reverseGeocoding(pos);
        }, function() {
            handleNoGeolocation(true);
        });
    } else {
        handleNoGeolocation(false);
    }
}

function reverseGeocoding(pos) {
    geocoder.geocode({'latLng': pos}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[1]) {
                marker = new google.maps.Marker({
                    position: pos,
                    map: map
                });
                infowindow.setContent(results[1].formatted_address);
                infowindow.open(map, marker);
            } else {
                alert('No results found');
            }
        } else {
            alert('Geocoder failed due to: ' + status);
        }
    });
}

function handleNoGeolocation(errorFlag) {
    if (errorFlag) {
        var content = 'Lo sentimos, no hemos podido localizarte.';
    } else {
        var content = 'Tu navegador no soporta la geolocalización.';
    }

    var options = {
        map: map,
        position: new google.maps.LatLng(60, 105),
        content: content
    };

    infowindow = new google.maps.InfoWindow(options);
    map.setCenter(options.position);
}
function loadScript() {
    var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = "http://maps.googleapis.com/maps/api/js?sensor=false&region=ES&callback=initialize";
    document.body.appendChild(script);
}

window.onload = loadScript;


