 
  <?php 
  
    $post_id = $_GET['step_1'];
    
    global $current_user;
    wp_get_current_user();
    $post   = get_post( $post_id );
    $meta = get_post_meta( $post_id );
    $unser = unserialize($meta['map_info'][0]);
    $lat = $unser['_lat'];
    $lng = $unser['_lng'];
    if($lat == ""){
        $lat = -6.121435;
    }

    if($lng == ""){
        $lng = 106.774124;
    }
    //print_r($unser);
    if ($post_id == "" OR !is_user_logged_in() OR $current_user->ID != $post->post_author)  {
        wp_die('Something went wrong!');
    }

 ?>

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHX0Zbm0cniXReUGXeRHIQQowQkgVZWSE&callback=initMap&libraries=places&v=weekly" async></script>
  <div class="container"><div class="form_header">
        <div class="row">
            <div class="col-md-8 header_left">
                <h2>Step-1</h2>
            </div>
            <div class="col-md-4 text-right">
                <a href="" class="save_btn">Save & Exit</a>
            </div>    
        </div>
    </div></div>
  <div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="text_box">
                <h1>Check The Location</h1>
                <p>
                    Move the pin around to make sure it\'s in the right spot.
                </p>
            </div>
            <div class="map_box">
                 <div id="map" style=""></div>
                <div class="address_box">
                    <h1>Address</h1>
                    <p>
                        <?php echo $unser['_map_location']; ?>
                    </p>
                    <form action="" method="post" id="form_update" class="form_update">
                        <input type="text" name="_map_location" id="edit-map-input" value="<?php echo $unser['_map_location']; ?>">
                       
                        <?php wp_nonce_field("update_listing_action"); ?>
                        <input type="hidden" name="action" value="update_listing_action">
                        <input type="hidden" name="lat" id="lat" value="<?php $unser['_lat']; ?>">
                        <input type="hidden" name="lng" id="lng" value="<?php $unser['_lng']; ?>">
                        <input type="hidden" name="step_1"  value="step_1">
                        <input type="hidden" name="pid"  value="<?php echo $post_id; ?> ">
                    </form>
                    <a href="" class="edit_btn btn">Edit</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info_box">
                <h4>Your Privacy</h4>
                <p>The full address won’t be visible on your listing. It will only be shown when you have an enquiry and you choose to share your details.</p>
            </div>
        </div>
    </div>
  </div>
  <br/><br/><br/>

  <div class="fixed_control_box">
      <div class="container">
          <div class="row">
              <div class="has-drop-shadow">
                <a href="" class="back_btn"> < </a>
                <a href="" class="next_btn"> Next  </a>
              </div>
          </div>
      </div>
  </div>
<script >
    function initMap() {
    var map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: <?= $lat; ?> , lng: <?= $lng; ?> },
        zoom: 13,
    });
    const card = document.getElementById("pac-card");
    const input = document.getElementById("edit-map-input");
    const biasInputElement = document.getElementById("use-location-bias");
    const strictBoundsInputElement = document.getElementById("use-strict-bounds");
    const options = {
        componentRestrictions: { country: ["sg", "aus"]  },
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
    $(document).ready(function(){
        $(".edit_btn").click(function(e){
            e.preventDefault();
            $('.form_update').toggleClass('show');
        });
    });

</script>







