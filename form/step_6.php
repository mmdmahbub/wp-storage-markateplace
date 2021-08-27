<?php

  $post_id = $_GET['step_6'];
    
  global $current_user;
  wp_get_current_user();
  $post   = get_post( $post_id );
  $meta = get_post_meta( $post_id );
  
//$images = get_posts( $attachments );
if ($post_id == "" OR !is_user_logged_in() OR $current_user->ID != $post->post_author)  {
    wp_die('Something went wrong!');
}

$_listing_desc = "";
$_security = "";
$_location = "";
$_hosting =  "";

if(metadata_exists('post',$post_id,'listingInfo')){
    $unser = unserialize($meta['listingInfo'][0]);
    $_listing_desc = $unser['_listing_desc'];
    $_security = $unser['_security'];
    $_location = $unser['_location'];
    $_hosting = $unser['_hosting'];
}



?>
  
  <div class="container">
    <div class="form_header">
        <div class="row">
            <div class="col-md-8 header_left">
                <h2>Step-6</h2>
            </div>
            <div class="col-md-4 text-right">
                <a href="" class="save_btn">Save & Exit</a>
            </div>    
        </div>

        
    </div>
    <div class="row">
        <div class="col-md-9">
             
            <div class="measerument_area">
              <div class="text_box">
                  <h1>Describe the Space</h1>
                  <p>
                    Give a detailed summary of the space, highlighting everything you want potential Guests to know.
                  </p>
              </div>
              <form action="" id="form_update" >
                <div class="row description_area">
                  <div class="col-md-12">
                       <div class="list_description">
                        <textarea name="list_desc" id="list_desc" ><?php if($_listing_desc != ""){ echo $_listing_desc; } ?>
                        </textarea>
                      </div>
                      <div class="description_small">
                          <label for="">Security</label>
                          <p>Highlight the security features of the space and point out anything that makes it more secure.</p>
                        <textarea name="security" id="security" ><?php if($_security != ""){ echo $_security; } ?>
                        </textarea>
                      </div>
                      <div class="description_small">
                          <label for="">Location</label>
                          <p>Give some information about where the space is located. Include details about safety and transport links.</p>
                        <textarea name="location" id="location" ><?php if($_location != ""){ echo $_location; } ?> </textarea>
                      </div>
                      <div class="description_small">
                          <label for="">Hosting</label>
                          <p>Explain how you'll be willing to help as a Host. This could include help with the move-in or how often you'll be at the space.</p>
                        <textarea name="hosting" id="hosting" ><?php if($_hosting != ""){ echo $_hosting; } ?> </textarea>
                      </div>
                  </div>
                </div>
                  

                <?php 
                  wp_nonce_field("update_listing_action");
                ?>
                 <input type="hidden" name="pid"  value="<?php echo $post_id ?>">
                 <input type="hidden" name="step_6"  value="step_6" id="step_6">
                <input type="hidden" value="update_listing_action" name="action">
              </form>
            </div>
            

        </div>
        <div class="col-md-3">
            <div class="info_box">
                <h4>Getting It Right</h4>
                <p>Measure your space using a measuring tape or an app (we like RoomScan!) to make sure your measurements are accurate. This will help Guests to know if their stuff or vehicle will fit, and helps us to give you accurate pricing recommendations.</p>
            </div>
        </div>

    </div>
  </div>
  <br/><br/><br/> <br/><br/><br/>


<script>

 
</script>




