
function initMap() {
    var map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: -6.121435 , lng: 106.774124 },
zoom: 13,
    });
const card = document.getElementById("pac-card");
const input = document.getElementById("edit-map-input");
const biasInputElement = document.getElementById("use-location-bias");
const strictBoundsInputElement = document.getElementById("use-strict-bounds");
const options = {
    componentRestrictions: { country: "id" },
    fields: ["formatted_address", "geometry", "name"],
    strictBounds: false,
    types: ["establishment"],
};

map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);
const autocomplete = new google.maps.places.Autocomplete(input, options);
// Bind the map's bounds (viewport) property to the autocomplete object,
// so that the autocomplete requests use the current map bounds for the
// bounds option in the request.
autocomplete.bindTo("bounds", map);
const infowindow = new google.maps.InfoWindow();
const infowindowContent = document.getElementById("infowindow-content");
infowindow.setContent(infowindowContent);
const marker = new google.maps.Marker({
    map,
    anchorPoint: new google.maps.Point(0, -29),
});
autocomplete.addListener("place_changed", () => {
    infowindow.close();
    marker.setVisible(false);
    const place = autocomplete.getPlace();
    var lat = place.geometry.location.lat();
    var lng = place.geometry.location.lng();
    //var edit_map_input = place.geometry.location.lng();

    // Then do whatever you want with them
    document.getElementById("lat").value = lat;
    document.getElementById("lng").value = lng;
    console.log(lat);
    console.log(lng);
    if (place.geometry == '' || place.geometry.location == '') {
        // User entered the name of a Place that was not suggested and
        // pressed the Enter key, or the Place Details request failed.
        //alert("No details available for input: '" + place.name + "'");
        console.log('asdsada');
        return;
    }

    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
        map.fitBounds(place.geometry.viewport);
    } else {
        map.setCenter(place.geometry.location);
        map.setZoom(17);
    }
    marker.setPosition(place.geometry.location);
    marker.setVisible(true);
    infowindowContent.children["place-name"].textContent = place.name;
    infowindowContent.children["place-address"].textContent =
        place.formatted_address;
    infowindow.open(map, marker);
});

    


    
}
$(document).ready(function () {
    $(".edit_btn").click(function (e) {
        e.preventDefault();
        $('.form_update').toggleClass('show');
    });
});
