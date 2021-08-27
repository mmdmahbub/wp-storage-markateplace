
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHX0Zbm0cniXReUGXeRHIQQowQkgVZWSE&callback=initMap&libraries=places&v=weekly" async></script>
<script src="<?php echo PluginUrl(); ?>/assets/script.js" ></script>
<div class="row section_padding" >
    <div class="col-md-6">
        <section class="form_wrappr">
            <br/><br/><br/>
            <h1 class="ext_listing_header">Add A New Listing</h1>
            <p>Let’s get you on the map! Just enter your address and select the location you want to add your listing to.</p>
            <form action="" method="post" id="add_listing">
                <div class="form_control">
                    <label>Add New Address</label>
                    <div class="fomr_inside">
                        <input type="text" id="pac-input" name="location" placeholder="Enter Type Your Address..."
                                required/>
                        <input type="hidden" name="add_listing_action">
                        <input type="hidden" name="lat" id="lat">
                        <input type="hidden" name="lng" id="lng">
                        <img src="<?php echo PluginUrl(); ?>images/spin.gif" class="loader">
                        <input type="submit" id="submitBtn" value="Add Listing">
                    </div>
                    <div id="map" style="display: none"></div>
                </div>
            </form> 
            <br />
            <br />
            
        </section>
    </div>
    <div class="col-md-6 intro_img">
        <img src="<?php echo PluginUrl(); ?>images/location-add.png">
    </div>
</div>

