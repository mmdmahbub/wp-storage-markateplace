<?php
  $post_id = $_GET['step_2'];
    
  global $current_user;
  wp_get_current_user();
  
  $post   = get_post( $post_id );
  $meta = get_post_meta( $post_id );
  if ($post_id == "" OR !is_user_logged_in() OR $current_user->ID != $post->post_author)  {
      wp_die('Something went wrong!');
  }

  $_space_type = "";
  $_storage = "";
  $_parking = "";
  $_workspace = "";
  $_floor_level = "";
  $multiple_hosting = "";
  $offer_fullfilment = "";

  if(metadata_exists('post', $post_id, 'storage_info')){
      $unser = unserialize($meta['storage_info'][0]);
      $_space_type = $unser['_space_type'];
      $_storage = $unser['_storage'];
      $_parking = $unser['_parking'];
      $_workspace = $unser['_workspace'];
      $_floor_level = $unser['_floor_level'];
      $multiple_hosting = $unser['_multiple_hosting'];
      $offer_fullfilment = $unser['_offer_fullfilment'];
  
  }
  

  function CheckBoxData($val){
    if($val == 1){ 
       echo "value='1' checked='checked'";
    } 
  }

  function space_type($val){
    if($val == "Garage"){ 
        echo "block";
    }else{
      echo "none";
    }
  }
  function space_type_option($val){
    if($val != ""){ 
        echo "<option value='$val'>$val</option>";
    }else{
       echo "<option value='0'>Space Type</option>";
    }
  }
  function floor_level($val){
    if($val != ""){ 
        echo "<option value='$val'>$val</option>";
    }else{
       echo "<option value='0'>Floor Level</option>";
    }
  }

?>


<div class="container"><div class="form_header">
    <div class="row">
            <div class="col-md-8 header_left">
                <h2>Step-2</h2>
            </div>
            <div class="col-md-4 text-right">
                <a href="" class="save_btn">Save & Exit</a>
            </div>    
        </div>
    </div>
</div>
<div class="container">
  
    <div class="row">
        <div class="col-md-9">
           <div class="text_box">
                <h1>Multiple Hosting?</h1>
            </div>
             <form action="" id="form_update" >
             <div class="row" style="margin-bottom: 50px">
              <div class="col-md-12 are_u_using">
                <label>
                    <input type="checkbox" class="input_checkbox"  id="multiple_hosting" name="multiple_hosting" 
                    <?php  CheckBoxData($multiple_hosting); ?>>Guests can book part of my space <a href="">Learn More</a>
                    
                </label>
              </div>
            </div>
            <div class="text_box">
                <h1> Offer Fulfillement?</h1>
                <p>Do you want to offer Fulfillement option for E-commerce merchants? <a href="">Learn More</a></p>
            </div>
             <div class="row" style="margin-bottom: 50px">
              <div class="col-md-12 are_u_using">
                <label>
                    <input type="checkbox" class="input_checkbox"  id="offer_fullfilment" name="offer_fullfilment"  <?php  CheckBoxData($offer_fullfilment); ?>>Yes, I want to offer Storage & Fulfillement
                  
                </label>
              </div>
            </div>
            
           <div class="text_box">
                <h1>What type of space is it?</h1>
                <p>
                    Spaces come in all shapes and sizes, so just select whichever describes yours best. 
                </p>
            </div>
           
         
            <div class="custom-select custom_select_1" style="width:200px;">
                <select name="space_type" id="space_type" required>
                    <?php space_type_option($_space_type); ?>
                    <option value="Garage">Garage</option>
                    <option value="Parking Space">Parking Space</option>
                    <option value="Shed">Shed</option>
                    <option value="Loft">Loft</option>
                    <option value="Basement">Basement</option>
                    <option value="Lock-up">Lock-up</option>
                    <option value="Outhouse">Outhouse</option>
                    <option value="Warehouse">Warehouse</option>
                    <option value="Self Storage Facility">Self Storage Facility</option>
                    <option value="Shipping Container">Shipping Container</option>
                    <option value="Spare Room">Spare Room</option>
                    <option value="Office">Office</option>
                </select>
            </div>
            

            
            <div class="text_box">
                <h1>What floor is the space on?</h1>
                <p>
                    Select the floor based on how many flights of stairs lead to the space. 
                </p>
            </div>
            <div class="custom-select" style="width:200px;">
                <select name="floor_level" id="floor_level" required> 
                    <?php floor_level($_floor_level);  ?>
                    <option value="Ground Level">Ground Level</option>
                    <option value="1st Floor">1st Floor</option>
                    <option value="2nd Floor">2nd Floor</option>
                    <option value="3rd Floor or Higher">3rd Floor or Higher</option>
                    <option value="Below Ground">Below Ground</option>
                    <option value="Multiple Floors">Multiple Floors</option>
                </select>
            </div>
        
            <div class="space_using" style="display: <?php space_type($_space_type); ?> ">

              <div class="text_box">
                  <h1>How can the space be used?</h1>
                  <p>
                    Select the options that are suitable for the space. Pick a few if you like!
                  </p>
              </div>
              <div class="row"  class="space_checkboxes">
                <div class="custom_alert" style="display: none">Make sure you select how the space can be used</div>
                <div class="col-md-4">
                  <label><input type="checkbox" class="input_checkbox"  id="storage" name="storage"  <?php  CheckBoxData($_storage); ?>
                   > Storage</label>
                </div>
                <div class="col-md-4">
                  <label><input type="checkbox" class="input_checkbox" id="parking" name="parking" <?php  CheckBoxData($_parking); ?>
                > Parking</label>
                </div>
                <div class="col-md-4">
                  <label><input type="checkbox"  class="input_checkbox" id="workspace" name="workspace" <?php  CheckBoxData($_workspace); ?>
               > Workspace</label>
                </div>
              </div>
            </div>
           
            
            <input type="hidden" name="pid"  value="<?php echo $post_id; ?>">
            <input type="hidden" name="step_2"  value="step_2">
            <input type="hidden" value="update_listing_action" name="action">
          </form> 

        </div>
        <div class="col-md-3">
            <div class="info_box">
                <h4>Enjoy smooth cashless payments</h4>
                <p>We'll make sure you always get paid on time with our secure, cashless payment system.</p>
            </div>
            
        </div>

    </div>
  </div>
  <br/><br/><br/> <br/><br/><br/>




<script src="<?php echo PluginUrl(); ?>assets/step_2.js"></script>






