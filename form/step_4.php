<?php

$post_id = $_GET['step_4'];
    
global $current_user;
wp_get_current_user();
$post   = get_post( $post_id );
$meta = get_post_meta( $post_id );
if ($post_id == "" OR !is_user_logged_in() OR $current_user->ID != $post->post_author)  {
    wp_die('Something went wrong!');
}

$_width = "";
$_depth = "";
$_height = "";
$_measurment_type = ""; 
$space_amount = ""; 
  
if(metadata_exists('post',$post_id,'measurment_info')){
    $unser = unserialize($meta['measurment_info'][0]);
    $_width = $unser['_width'];
    $_depth = $unser['_depth'];
    $_height = $unser['_height'];
    $_measurment_type = $unser['_measurment_type']; 
    $space_amount = $unser['_space_amount']; 
}
  
//echo "<pre>";
//  print_r($unser);
//echo "</pre>";
?>
  
  <div class="container">
    <div class="form_header">
        <div class="row">
            <div class="col-md-8 header_left">
                <h2>Step-4</h2>
            </div>
            <div class="col-md-4 text-right">
                <a href="" class="save_btn">Save & Exit</a>
            </div>    
        </div>

        
    </div>
    <div class="row">
        <div class="col-md-9">
             
            <div class="measerument_area msrnt_ar">
              <div class="text_box">
                  <h1>What are the measurements of the space?</h1>
                  <p>
                    Round up to the nearest whole number if you need to.
                  </p>
              </div>
              <form action="" id="form_update" >
                <div class="row measerument_area_input"  >
                  <div class="col-md-6">
                    <label>Width</label>
                     <div>
                        <input type="text" placeholder="width" id="width" name="width" value="<?= $_width ; ?>" required>
                      
                        <select name="measurment_in_width" id="">
                            <?php 
                            if($_measurment_type != ""){
                                if($_measurment_type == "ft"){
                                  echo "<option value='ft'>ft</option>";
                                  echo "<option value='m'>m</option>";
                                }else{
                                  echo "<option value='m'>m</option>";
                                  echo "<option value='ft'>ft</option>";
                                }
                            }else{
                          ?>
                          <option value="ft">ft</option>
                          <option value="m">m</option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="show_alert">
                        <div class="alert alert-danger">
                          Maximum value is 500
                        </div>
                      </div>
                  </div>
                </div>
                <div class="row measerument_area_input"  >
                  <div class="col-md-6">
                    <label>Depth</label>
                    <div>
                      <input type="text" placeholder="Depth" name="depth" id="depth" value="<?= $_depth ; ?>" required>
                      <select name="measurment_in_depth" id="">
                          <?php 
                            if($_measurment_type != ""){
                                 if($_measurment_type == "ft"){
                                  echo "<option value='ft'>ft</option>";
                                  echo "<option value='m'>m</option>";
                                }else{
                                  echo "<option value='m'>m</option>";
                                  echo "<option value='ft'>ft</option>";
                                }
                            }else{
                          ?>
                          <option value="ft">ft</option>
                          <option value="m">m</option>
                          <?php } ?>
                      </select>
                    </div>
                    <div class="show_alert">
                        <div class="alert alert-danger">
                          Maximum value is 500
                        </div>
                      </div>
                  </div>
                </div>
                <div class="row measerument_area_input"  >
                  <div class="col-md-6">
                    <label>Height</label>
                     <div>
                      <input type="text" placeholder="Height" name="height" id="height" value="<?= $_height ; ?>" required>
                      <select name="measurment_in_height" id="">
                          <?php 
                            if($_measurment_type != ""){
                                 if($_measurment_type == "ft"){
                                  echo "<option value='ft'>ft</option>";
                                  echo "<option value='m'>m</option>";
                                }else{
                                  echo "<option value='m'>m</option>";
                                  echo "<option value='ft'>ft</option>";
                                }
                            }else{
                          ?>
                          <option value="ft">ft</option>
                          <option value="m">m</option>
                          <?php } ?>
                      </select>
                      </div>
                      <div class="show_alert">
                        <div class="alert alert-danger">
                          Maximum value is 500
                        </div>
                      </div>
                      <div class="total_amount" style="margin-top:50px;display: none">
                        <h4 ><strong>Total Area</strong></h4>
                        <p><span class="size_holder"><?php if($_width != "" && $_depth != "" ){ echo $_width * $_depth;}?></span> <span class="sq_ft"><?php if($_measurment_type != "" ){ echo $_measurment_type;}?></span></p>
                         
                      </div>
                      
                  </div>
                </div>
                 <div class="text_box">
                    <h1>How many space of this size do you have?</h1>
                    <p>
                      These should all be at the same location, on the same floor and have the same features.
                    </p>
                </div>
                <div class="row measerument_area_input"  >
                  <div class="col-md-6">
                     <div>
                        <input type="text" placeholder="1" id="space_amount" name="space_amount" value="<?php
                          if($space_amount != ""){
                            echo $space_amount;
                          }else{
                            echo 1;
                          }
                       ?>" required>
                        <label class="space_amount">space</label>
                      </div>
                  </div>
                </div>

                <?php 
                  wp_nonce_field("update_listing_action");
                ?>
                 <input type="hidden" name="measurment_type" id="measurment_type" value="ft">
                 <input type="hidden" name="pid"  value="<?php echo $post_id ?>">
                 <input type="hidden" name="step_4"  value="step_4">
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
      $(document).ready(function () {    
        
          $("#width").keypress(function (e) {  
            var charCode = (e.which) ? e.which : event.keyCode 
            if (String.fromCharCode(charCode).match(/[^0-9]/g))  
            return false;

               $('#width').on('input', function () {
                
                  var value = $(this).val();
                  
                  if ((value !== '') && (value.indexOf('.') === -1)) {
                      
                      $(this).val(Math.max(Math.min(value, 500), -500));
                    
                  }
              });

            }); 

          $("#depth").keypress(function (e) {  
            var charCode = (e.which) ? e.which : event.keyCode 
            if (String.fromCharCode(charCode).match(/[^0-9]/g))    
            return false;   
            $('#depth').on('input', function () {
                
                  var value = $(this).val();
                  
                  if ((value !== '') && (value.indexOf('.') === -1)) {
                      
                      $(this).val(Math.max(Math.min(value, 500), -500));
                    
                  }
            });

            
          }); 

          $("#height").keypress(function (e) {  
            var charCode = (e.which) ? e.which : event.keyCode 
            if (String.fromCharCode(charCode).match(/[^0-9]/g))    
            return false;   
            $('#height').on('input', function () {
                
                  var value = $(this).val();
                  
                  if ((value !== '') && (value.indexOf('.') === -1)) {
                      
                      $(this).val(Math.max(Math.min(value, 500), -500));
                    
                  }
              });
          }); 

          $("#width").keyup(function (e) {  
              var width = $("#width").val();
              var depth = $("#depth").val();
              $math = width * depth; 
               if(width == "" || depth == "" ){
                  $(".total_amount").addClass('hide');
                  $(".total_amount").removeClass('show');
               }else{
                 $(".total_amount").removeClass('hide');
                 $(".total_amount").addClass('show');
               }
               $(".size_holder").text($math);

          }); 
          $("#depth").keyup(function (e) {  
              var width = $("#width").val();
              var depth = $("#depth").val();
              $math = width * depth;
              if(width == "" || depth == "" ){
                  $(".total_amount").css({ 'display' : 'none' });
               }else{
                 $(".total_amount").css({ 'display' : 'block' });
               }
              $(".size_holder").text($math);

          }); 

          $("select").on('change', function(){
              var optionSelected = $("option:selected", this);
              var valueSelected = this.value;
              $("#measurment_type").val(valueSelected);
              

              if( valueSelected == "ft" ){
                  $('select').val('ft').trigger('change');
              }else{
                $('select').val('m').trigger('change');
              }
          });
           


         
  
      });  
 
</script>




