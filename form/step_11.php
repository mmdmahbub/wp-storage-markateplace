
<?php

  $post_id = $_GET['step_11'];
    
  global $current_user;
  wp_get_current_user();
  $post   = get_post( $post_id );
  $meta = get_post_meta( $post_id );
  if ($post_id == "" OR !is_user_logged_in() OR $current_user->ID != $post->post_author)  {
      wp_die('Something went wrong!');
  }
  
  function checkAllFields($post_id,$val,$key){
    
    $meta = get_post_meta( $post_id );
    $unser = unserialize($meta[$val][0]);
    return $data = $unser[$key];
  }
 
  
?>
<div class="container"><div class="form_header">
    <div class="row">
            <div class="col-md-8 header_left">
                <h2>Step-11</h2>
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
          <div class="row">
            <div class="col-md-12">
              <div class="well">
                  <?php 
                    /*
                      if(checkAllFields($post_id,'map_info','step_1') != 1){ 
                          echo "<div class='step_error' >Step 1 is not Completed <br/> </div>";
                          $disable = 'disable';
                        }
                        if(checkAllFields($post_id,'storage_info','step_2') != 1){ 
                          echo "<div class='step_error' >Step 2 is not Completed <br/> </div>";
                          $disable = 'disable';
                        }
                        if(checkAllFields($post_id,'feature_info','step_3') != 1){ 
                          echo "<div class='step_error' >Step 3 is not Completed <br/></div>";
                          $disable = 'disable';
                        }
                        if(checkAllFields($post_id,'map_measurment_infoinfo','step_4') != 1){ 
                          echo "<div class='step_error' >Step 4 is not Completed <br/></div>";
                          $disable = 'disable';
                        }
                        if(checkAllFields($post_id,'listingInfo','step_5') != 1){ 
                          echo "<div class='step_error' >Step 5 is not Completed <br/></div>";
                          $disable = 'disable';
                        }
                        if(checkAllFields($post_id,'access_info','step_6') != 1){ 
                          echo "<div class='step_error' >Step 6 is not Completed <br/></div>";
                          $disable = 'disable';
                        }
                        if(checkAllFields($post_id,'minimum_rental','step_7') != 1){ 
                          echo "<div class='step_error' >Step 7 is not Completed <br/></div>";
                          $disable = 'disable';
                        }
                        if(checkAllFields($post_id,'pricing','step_8') != 1){ 
                          echo "<div class='step_error' >Step 8 is not Completed <br/></div>";
                          $disable = 'disable';
                         }
                        if(checkAllFields($post_id,'booking_type','step_9') != 1){ 
                          echo "<div class='step_error' >Step 9 is not Completed <br/></div>";
                          $disable = 'disable';
                        }
                        if(checkAllFields($post_id,'terms_aggreement','step_10') != 1){ 
                          echo "<div class='step_error' >Step 10 is not Completed <br/></div>";
                          $disable = 'disable';
                        }
                        */
                  ?>
              </div>
            </div>
          </div>
          <form action="" id="publishing_form" method="post">
            <div class="text_box">
                <h1>Booking Terms</h1>
                <p>
                  The Booking Terms protect your bookings in case anything goes wrong. Your Guests will sign this before they start a booking.
                </p>
            </div>
            <div class="row" style="margin-bottom: 50px">
              <div class="col-md-12 are_u_using">
                <label>
                    <input type="checkbox" class="input_checkbox"  id="booking_terms" name="booking_terms" 
                    checked required value="1"> I agree to the <a href="">Booking Terms</a>
                </label>
              </div>
            </div>
         
        
           
            <?php 
               wp_nonce_field("publish_post_action");
            ?>
            <input type="hidden" name="pid"  value="<?php echo $post_id ?>">
            <input type="hidden" name="step_11"  value="step_11">
            <input type="hidden" value="publish_post_action" name="action">
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
  $('.input_checkbox').on('click',function () {
      if ($(this).is(':checked')) {
          $(this).val(1);
      } else {
          $(this).val(0);
      }
  });


 
</script>




 




    


</script>



