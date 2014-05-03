var geocoder;
var map;
var infowindow;
var marker;
function initialize() {
    geocoder = new google.maps.Geocoder();
    infowindow = new google.maps.InfoWindow();
    var position = new google.maps.LatLng(40.416761, -3.703489);
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
    
    var input = document.getElementsByClassName('center-address')[0];
    console.log(input);
    var autocomplete = new google.maps.places.Autocomplete(input, {
             types: ["geocode"]
         });

         autocomplete.bindTo('bounds', map);
         var infowindow = new google.maps.InfoWindow();

         google.maps.event.addListener(autocomplete, 'place_changed', function (event) {
              var place = autocomplete.getPlace();
              console.log("Place Changes");
              console.log(place.geometry);
              fillLatLongInputs(place.geometry.location.k, place.geometry.location.A);
              fillFormInputs(place);    
              
            var pos = new google.maps.LatLng(place.geometry.location.k,
               place.geometry.location.A);
            map.setCenter(pos);
            marker.setPosition(pos);
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

    geocoder.geocode({'address': placeToFind}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
            marker.setPosition(results[0].geometry.location);
            fillLatLongInputs(results[0].geometry.location.lat, results[0].geometry.location.lng);
            reverseGeocoding(results[0].geometry.location, true);
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
            fillLatLongInputs(position.coords.latitude, position.coords.longitude);
            
            map.setCenter(pos);
            marker.setPosition(pos);

            map.setCenter(pos);
            reverseGeocoding(pos, false);
        }, function() {
            handleNoGeolocation(true);
        });
    } else {
        handleNoGeolocation(false);
    }
}

function reverseGeocoding(pos, reducedSearch) {
    geocoder.geocode({'latLng': pos, 'region': 'ES'}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
                marker.setPosition(pos);
                infowindow.setContent(results[0].formatted_address);
                infowindow.open(map, marker);
                if (reducedSearch) {
                    fillReducedFormInputs(results[0]);
                } else {
                    fillFormInputs(results[0]);
                }
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
        position: new google.maps.LatLng(40.416761, -3.703489),
        content: content
    };

    infowindow = new google.maps.InfoWindow(options);
    map.setCenter(options.position);
}

function fillLatLongInputs(lat, long) {
    console.log("Coordenadas");
    console.log(lat);
    console.log(long);
    $("form").find(".center-lat").val(lat);
    $("form").find(".center-long").val(long);
}
function fillReducedFormInputs(item) {
    var arrAddress = item.address_components;
    var itemZipcode = '';
    
    $.each(arrAddress, function(i, address_component) {
        if (address_component.types[0] == "postal_code") {
            console.log("itemZipcode:" + address_component.long_name);
            itemZipcode = address_component.long_name;
        }
    });
    $("form").find(".center-zipcode").val(itemZipcode);
}
function fillFormInputs(item) {
    var arrAddress = item.address_components;
    var itemCenterName='';
    var itemAddress = '';
    var itemCity = '';
    var itemProvince = '';
    var itemCommunity = '';
    var itemZipcode = '';
    var itemNumber = '';
    
    $.each(arrAddress, function(i, address_component) {
        if (address_component.types[0] == "premise") {
            console.log(i + ": itemCenterName:" + address_component.long_name);
            itemCenterName = address_component.long_name;
        }
        if (address_component.types[0] == "route") {
            console.log("itemAddress:" + address_component.long_name);
            itemAddress = address_component.long_name;
        }
        if (address_component.types[0] == "locality") {
            console.log("itemCity:" + address_component.long_name);
            itemCity = address_component.long_name;
        }
        if (address_component.types[0] == "administrative_area_level_2") {
            console.log("itemProvince:" + address_component.long_name);
            itemProvince = address_component.long_name;
        }
        if (address_component.types[0] == "administrative_area_level_1") {
            console.log("itemCommunity:" + address_component.long_name);
            itemCommunity = address_component.long_name;
        }
        if (address_component.types[0] == "postal_code") {
            console.log("itemZipcode:" + address_component.long_name);
            itemZipcode = address_component.long_name;
        }
        if (address_component.types[0] == "street_number") {
            console.log("itemNumber:" + address_component.long_name);
            itemNumber = address_component.long_name;
        }
    });
    $("form").find(".center-name").val(itemCenterName);
    $("form").find(".center-address").val(itemAddress + ", " + itemNumber);
    $("form").find(".center-city").val(itemCity);
    $("form").find(".center-province").val(itemProvince);
    $("form").find(".center-community").val(itemCommunity);
    $("form").find(".center-zipcode").val(itemZipcode);
}
function loadScript() {
    var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = "http://maps.googleapis.com/maps/api/js?libraries=places&sensor=false&region=ES&language=es&callback=initialize";
    document.body.appendChild(script);
}

window.onload = loadScript;


