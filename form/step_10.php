
<?php

  $post_id = $_GET['step_10'];
    
  global $current_user;
  wp_get_current_user();
  $post   = get_post( $post_id );
  $meta = get_post_meta( $post_id );
  if ($post_id == "" OR !is_user_logged_in() OR $current_user->ID != $post->post_author)  {
      wp_die('Something went wrong!');
  }
  $instant_booking   = "";
  if(metadata_exists('post',$post_id, 'booking_type')){
    $unser = unserialize($meta['booking_type'][0]);
    $instant_booking   = $unser['_instant_booking'];
  }
  
 
//echo "<pre>";
//print_r($unser);
//echo "</pre>";


?>
<div class="container"><div class="form_header">
    <div class="row">
            <div class="col-md-8 header_left">
                <h2>Step-10</h2>
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
          
          <form action="" id="form_update" >
            <div class="text_box">
                <h1>Instant Book</h1>
                <p>Turning on Instant Book will automatically confirm your bookings. This means Guests won't have to wait for you to confirm before they can book the space.</p>
            </div>
            <div class="row measerument_area_input instant_booking"  >
                <div class="col-md-12">
                     <label>
                       <input type="radio" class="input_checkbox"  id="instant_booking" name="instant_booking" value="0" <?php if($instant_booking == 0){ echo "checked='checked'"; }?>
                       > Instant Book On
                      </label>
                       <label>
                       <input type="radio" class="input_checkbox"  id="instant_booking" name="instant_booking" value="1" <?php if($instant_booking == 1){ echo "checked='checked'"; }?>
                       > All bookings must be confirmed by you  
                      </label>
                </div>
            </div>
           
            <?php 
               wp_nonce_field("update_listing_action");
            ?>
            <input type="hidden" name="pid"  value="<?php echo $post_id ?>">
            <input type="hidden" name="step_10"  value="step_10" id="step_10">
            <input type="hidden" value="update_listing_action" name="action">
          </form> 

        </div>
        <div class="col-md-3">
            <div class="info_box">
                <h4>Access Instructions</h4>
                <p>Write access instructions to give Guests all the information they need to access the space. Clear access instructions will help your bookings run smoothly, so try to be as specific as possible.</p>
            </div>
            
        </div>

    </div>
  </div>
  <br/><br/><br/> <br/><br/><br/>




<script>
   


  $('input.input_checkbox').on('change', function() {
    $('input.input_checkbox').not(this).prop('checked', false); 
  });

</script>



