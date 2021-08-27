<?php

  $post_id = $_GET['step_5'];
    
  global $current_user;
  wp_get_current_user();
  $post   = get_post( $post_id );
  $meta = get_post_meta( $post_id );
  
  //$images = get_posts( $attachments );
  if ($post_id == "" OR !is_user_logged_in() OR $current_user->ID != $post->post_author)  {
      wp_die('Something went wrong!');
  }
  function images($post_id){
     $attachments = get_posts( array(
          'post_type' => 'attachment',
          'posts_per_page' => -1,
          'post_parent' => $post_id
      ) );
      foreach ( $attachments as $attachment ) {
          
          //$thumbimg = wp_get_attachment_link( $attachment->ID, 'thumbnail-size', true );
          echo "<li class=''>";
                echo "<img src='".wp_get_attachment_url($attachment->ID)."'>";
            echo "<a href='' name='$attachment->ID' id='pic_$attachment->ID' class='delete_attach'> <i class='fa fa-trash'></i></a>";
            echo "<input type='hidden' name='nonce' id='nonce' value='". wp_create_nonce( 'delete_attachment' )."' />";
          echo  "</li>";
      }
  }

?>
  
  <div class="container">
    <div class="form_header">
        <div class="row">
            <div class="col-md-8 header_left">
                <h2>Step-5</h2>
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
                  <h1>Add Photos</h1>
                  <p>
                    Photos bring your listing to life and help Guests get a feel for your space. Upload as many as you can. You can always add more later on!
                  </p>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="attahced_image">
                    <?php 
                      images($post_id);
                    ?>
                </div>
                </div>
              </div>
              <form action="" id="form_update" enctype="multipart/form-data">
                <div class="row">
                  <div class="picture_upload">
                    <input name="files_to_upload[]" type="file"  id="upload_field" multiple="multiple" >
                    <div class="gallery">or drag & drop them here</div>
                  </div>
                </div>

                <?php 
                  wp_nonce_field("update_listing_action");
                ?>
                 <input type="hidden" name="pid"  value="<?php echo $post_id ?>">
                 <input type="hidden" name="step_5"  value="step_5" id="step_5">
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




