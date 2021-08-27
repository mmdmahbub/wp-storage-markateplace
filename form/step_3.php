<?php 
$post_id = $_GET['step_3'];

global $current_user;
wp_get_current_user();
$post   = get_post( $post_id );
$meta = get_post_meta( $post_id );

$_bolt_lock   = "";
$_CCTV   = "";	
$_Door_defender_lock   = "";	
$_lockable_door   = "";
$_on_site_staff   = "";
$_padlock   = "";
$_roller_shutter_doors   = "";
$_security_alarm   = "";
$_security_bar   = "";
$_security_gate   = "";
$_security_lighting   = "";
$_smoke_detector   = "";
$_climate_control   = "";	
$_dehumidifier   = "";
$_electricity_car_charging   = "";
$_electricity_normal_socket   = "";
$_Electricity_three_phase   = "";
$_fire_alarm   = "";
$_ground_door_strip   = "";
$_heating   =  "";
$_lighting   =  "";
$_private_entrance   =  "";
$_shelving   =  "";
$_water_supply   =  "";


if(metadata_exists('post', $post_id, 'feature_info')){
    $unser = unserialize($meta['feature_info'][0]);
    $_bolt_lock   = $unser['_bolt_lock'];
    $_CCTV   = $unser['_CCTV'];	
    $_Door_defender_lock   = $unser['_Door_defender_lock'];	
    $_lockable_door   = $unser['_lockable_door'];
    $_on_site_staff   = $unser['_on_site_staff'];
    $_padlock   = $unser['_padlock'];
    $_roller_shutter_doors   = $unser['_roller_shutter_doors'];
    $_security_alarm   = $unser['_security_alarm'];
    $_security_bar   = $unser['_security_bar'];
    $_security_gate   = $unser['_security_gate'];
    $_security_lighting   = $unser['_security_lighting'];
    $_smoke_detector   = $unser['_smoke_detector'];
    $_climate_control   = $unser['_climate_control'];	
    $_dehumidifier   = $unser['_dehumidifier'];
    $_electricity_car_charging   = $unser['_electricity_car_charging'];
    $_electricity_normal_socket   = $unser['_electricity_normal_socket'];
    $_Electricity_three_phase   = $unser['_Electricity_three_phase'];
    $_fire_alarm   = $unser['_fire_alarm'];
    $_ground_door_strip   = $unser['_ground_door_strip'];
    $_heating   = $unser['_heating'];
    $_lighting   = $unser['_lighting'];
    $_private_entrance   = $unser['_private_entrance'];
    $_shelving   = $unser['_shelving'];
    $_water_supply   = $unser['_water_supply'];
}
 // echo "<pre>";
  //print_r($unser);
 // echo "</pre>";

  function checkedProperty($value){
    echo "value =";
    if($value == 1){
      echo "'$value"."'";
    }else{
      echo 0;
    }
    if($value == 1){
      echo "checked='checked'";
    }
  }
?>
  <div class="container">
    <div class="form_header">
        <div class="row">
            <div class="col-md-8 header_left">
                <h6>Step-3</h6>
            </div>
            <div class="col-md-4 text-right">
                <a href="" class="save_btn">Save & Exit</a>
            </div>    
        </div>

        
    </div>
    <div class="row">
        <div class="col-md-9">
             <div class="text_box">
                <h1>What features does the space have?</h1>
                <p>
                   Only select the features that Guests can use or benefit from.
                </p>
            </div>
            <form action="" id="form_update">
            <div class="feature_list">
                <div class="row">
                    <div class="col-md-6">
                      <label><input type="checkbox" class="input_checkbox" name="bolt_lock" <?php checkedProperty($_bolt_lock); ?> > Bolt Lock</label>
                    </div>
                    <div class="col-md-6">
                      <label><input type="checkbox" class="input_checkbox" name="CCTV" <?php checkedProperty($_CCTV); ?>> CCTV </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                      <label><input type="checkbox" class="input_checkbox" name="Door_defender_lock" <?php checkedProperty($_Door_defender_lock); ?>> Door Defender Lock</label>
                    </div>
                    <div class="col-md-6">
                      <label><input type="checkbox" class="input_checkbox" name="lockable_door" <?php checkedProperty($_lockable_door); ?> > Lockable Door </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                      <label><input type="checkbox" class="input_checkbox" name="on_site_staff" <?php checkedProperty($_on_site_staff); ?> > On-site Staff</label>
                    </div>
                    <div class="col-md-6">
                      <label><input type="checkbox" class="input_checkbox" name="padlock" <?php checkedProperty($_padlock); ?> >Padlock</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                      <label><input type="checkbox" class="input_checkbox" name="roller_shutter_doors" <?php checkedProperty($_roller_shutter_doors); ?> > Roller Shutter Doors </label>
                    </div>
                    <div class="col-md-6">
                      <label><input type="checkbox" class="input_checkbox" name="security_alarm" <?php checkedProperty($_security_alarm); ?> > Security Alarm</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                      <label><input type="checkbox" class="input_checkbox" name="security_bar" <?php checkedProperty($_security_bar); ?> >Security Bar</label>
                    </div>
                    <div class="col-md-6">
                      <label><input type="checkbox" class="input_checkbox" name="security_gate" <?php checkedProperty($_security_gate); ?> > Security Gate </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                      <label><input type="checkbox" class="input_checkbox" name="security_lighting" <?php checkedProperty($_security_lighting); ?> > Security Lighting</label>
                    </div>
                    <div class="col-md-6">
                      <label><input type="checkbox" class="input_checkbox" name="smoke_detector" <?php checkedProperty($_smoke_detector); ?> >Smoke Detector</label>
                    </div>
                </div>
            </div>
            <hr>
            <div class="feature_list feature_list_s">
                <div class="row">
                    <div class="col-md-6">
                      <label><input type="checkbox" class="input_checkbox" name="climate_control" value="Climate Control" <?php checkedProperty($_climate_control); ?> > Climate Control</label>
                    </div>
                    <div class="col-md-6">
                      <label><input type="checkbox" class="input_checkbox" name="dehumidifier" <?php checkedProperty($_dehumidifier); ?> > Dehumidifier </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                      <label><input type="checkbox" class="input_checkbox" name="electricity_car_charging" <?php checkedProperty($_electricity_car_charging); ?> > Electricity - Car Charging</label>
                    </div>
                    <div class="col-md-6">
                      <label><input type="checkbox" class="input_checkbox" name="electricity_normal_socket" <?php checkedProperty($_electricity_normal_socket); ?>> Electricity - Normal Socket</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                      <label><input type="checkbox" class="input_checkbox" name="Electricity_three_phase" <?php checkedProperty($_Electricity_three_phase); ?>> Electricity - Three Phase</label>
                    </div>
                    <div class="col-md-6">
                      <label><input type="checkbox" class="input_checkbox" name="fire_alarm" <?php checkedProperty($_fire_alarm); ?>> Fire Alarm</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                      <label><input type="checkbox" class="input_checkbox" name="ground_door_strip" <?php checkedProperty($_ground_door_strip); ?>> Ground Door Strip</label>
                    </div>
                    <div class="col-md-6">
                      <label><input type="checkbox" class="input_checkbox" name="heating" <?php checkedProperty($_heating); ?>>Heating </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                      <label><input type="checkbox" class="input_checkbox" name="lighting" <?php checkedProperty($_lighting); ?>>Lighting </label>
                    </div>
                    <div class="col-md-6">
                      <label><input type="checkbox" class="input_checkbox" name="private_entrance" <?php checkedProperty($_private_entrance); ?>>Private Entrance</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                      <label><input type="checkbox" class="input_checkbox" name="shelving" <?php checkedProperty($_shelving); ?>>Shelving </label>
                    </div>
                    <div class="col-md-6">
                      <label><input type="checkbox" class="input_checkbox" name="water_supply" <?php checkedProperty($_water_supply); ?>>Water Supply</label>
                    </div>
                </div>

            </div>

            <?php 
               wp_nonce_field("update_listing_action");
            ?>
            <input type="hidden" name="pid"  value="<?php echo $post_id ?>">
            <input type="hidden" name="step_3"  value="step_3">
            <input type="hidden" value="update_listing_action" name="action">
          </form>

        </div>
        <div class="col-md-3">
            <div class="info_box">
                <h4>Upgrade the security of the space</h4>
                <p>The more secure the space is, the more sellable it will be. Install and select more security features to improve your listing.</p>
            </div>
        </div>

    </div>
  </div>
  <br/><br/><br/> <br/><br/><br/>
  <script>

  $('.input_checkbox').on('click',function () {
      if ($(this).is(':checked')) {
          $(this).val(1);
      } else {
          $(this).val(0);
      }
  });
</script>




