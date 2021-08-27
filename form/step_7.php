<?php
  $post_id = $_GET['step_7'];
    
  global $current_user;
  wp_get_current_user();
  $post   = get_post( $post_id );
  $meta = get_post_meta( $post_id );
  if ($post_id == "" OR !is_user_logged_in() OR $current_user->ID != $post->post_author)  {
      wp_die('Something went wrong!');
  }

$access_type      = "";
$_saturday        = "";
$_start_saturday  = "";
$_end_saturday    = "";
$_sunday          = "";
$_start_sunday    = "";
$_end_sunday      = "";
$_monday          = "";
$_start_monday    = "";
$_end_monday      = "";
$_tuesday         = "";
$_start_tuesday   = "";
$_end_tuesday     = "";
$_wednesday       = "";
$_start_wednesday = "";
$_end_wednesday   = "";
$_thursday        = "";
$_start_thursday  = "";
$_end_thursday    = "";
$_friday          = "";
$_start_friday    = "";
$_end_friday      = "";
$_access_method   = "";
$_are_u_using     = "";
$_access_text     = "";

if(metadata_exists('post',$post_id,'access_info')){
    $unser = unserialize($meta['access_info'][0]);
    $access_type      = $unser['_access_type'];
    $_saturday        = $unser['_saturday'];
    $_start_saturday  = $unser['_start_saturday'];
    $_end_saturday    = $unser['_end_saturday'];
    $_sunday          = $unser['_sunday'];
    $_start_sunday    = $unser['_start_sunday'];
    $_end_sunday      = $unser['_end_sunday'];
    $_monday          = $unser['_monday'];
    $_start_monday    = $unser['_start_monday'];
    $_end_monday      = $unser['_end_monday'];
    $_tuesday         = $unser['_tuesday'];
    $_start_tuesday   = $unser['_start_tuesday'];
    $_end_tuesday     = $unser['_end_tuesday'];
    $_wednesday       = $unser['_wednesday'];
    $_start_wednesday = $unser['_start_wednesday'];
    $_end_wednesday   = $unser['_end_wednesday'];
    $_thursday        = $unser['_thursday'];
    $_start_thursday  = $unser['_start_thursday'];
    $_end_thursday    = $unser['_end_thursday'];
    $_friday          = $unser['_friday'];
    $_start_friday    = $unser['_start_friday'];
    $_end_friday      = $unser['_end_friday'];
    $_access_method   = $unser['_access_method'];
    $_are_u_using     = $unser['_are_u_using'];
    $_access_text     = $unser['_access_text'];
}
  function timeSelector(){
      echo "<option value='Any Time'>Any Time</option>";
      $range=range(strtotime("0:00"),strtotime("24:00"),30*60);
      foreach($range as $time){
        echo "<option>" . date("H:i",$time)."</option>";
      }
  }
  function hideShow($dayName){
    if($dayName == 0){
      echo "block";
    }else{
       echo "none";
    }
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
<div class="container"><div class="form_header">
    <div class="row">
            <div class="col-md-8 header_left">
                <h2>Step-7</h2>
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
                <h1>When will Guests be able to access the space?</h1>
                <p style="margin-bottom:0px;">
                   Guests might need to access the space during their booking. Just select the option that suits you best.
                </p>
            </div>
          <form action="" id="form_update" >
            <div class="custom-select custom_select_1" style="width:200px;margin-bottom: 10px">
                <select name="access_type" id="access_type" required>
                    <option <?php if($access_type == ""){echo 0;}?> value="<?php 
                      if($access_type != ""){echo $access_type;}else{ echo 0;}?>" >
                        <?php 
                          if($access_type != ""){
                            echo $access_type;
                          }else{
                            echo "Select Access Type";
                          }
                        ?>
                        
                    </option>
                    <option value="Anytime">Anytime</option>
                    <option value="Prior Notice Only">Prior Notice Only</option>
                    <option value="Specific Hours">Specific Hours</option>
                    <option value="Drop-off Only">Drop-off Only</option>
                </select>
            </div>
             <div class="space_using" style="display: <?php 
              if($access_type == "Specific Hours"){ 
                  echo "block";
              }else{
                echo "none";
              }
              ?>;margin-bottom:20px">
              
              <div class="row"  class="space_checkboxes">
               
                    <div class="col-md-8 hours_row saturday_box">
                      <label>
                          <input type="checkbox" class="input_checkbox"  id="saturday" name="saturday" <?php checkedProperty($_saturday); ?>>Saturday 
                          
                      </label>
                        <div class="select_filds sat" style="<?php if($_saturday == 1){ echo "display: block"; }?>">
                            <select name="start_saturday" id="start_saturday">
                                <?php 
                                  if($_start_saturday != ""){
                                    echo "<option>$_start_saturday</option>";
                                  }
                                  timeSelector(); 
                                ?>
                            </select>
   
                            <select name="end_saturday" id="end_saturday">
                                <?php 
                                  if($_end_saturday != ""){
                                    echo "<option>$_end_saturday</option>";
                                  }
                                  timeSelector(); 
                                ?>
                            </select>
                        </div>
                  </div>
                  <div class="col-md-8 hours_row sunday_box" style="<?php if($_sunday == 1){ echo "display: block"; }?>">
                      <label>
                          <input type="checkbox" class="input_checkbox"  id="sunday" name="sunday" <?php checkedProperty($_sunday); ?>>Sunday 
                          
                      </label>
                        <div class="select_filds sun" style="<?php if($_sunday == 1){ echo "display: block"; }?>">
                            <select name="start_sunday" id="start_sunday">
                                <?php 
                                  if($_start_sunday != ""){
                                    echo "<option>$_start_sunday</option>";
                                  }
                                  timeSelector(); 
                                ?>
                            </select>
   
                            <select name="end_sunday" id="end_sunday">
                                <?php 
                                  if($_end_sunday != ""){
                                    echo "<option>$_end_sunday</option>";
                                  }
                                  timeSelector(); 
                                ?>
                            </select>
                        </div>
                  </div>
                  <div class="col-md-8 hours_row monday_box" style="<?php if($_monday == 1){ echo "display: block"; }?>">
                      <label>
                          <input type="checkbox" class="input_checkbox"  id="monday" name="monday" <?php checkedProperty($_monday); ?>>Monday 
                          
                      </label>
                        <div class="select_filds mon">
                            <select name="start_monday" id="start_monday">
                                <?php 
                                  if($_start_monday != ""){
                                    echo "<option>$_start_monday</option>";
                                  }
                                  timeSelector(); 
                                ?>
                            </select>
   
                            <select name="end_monday" id="end_monday">
                                <?php 
                                  if($_end_monday != ""){
                                    echo "<option>$_end_monday</option>";
                                  }
                                  timeSelector(); 
                                ?>
                            </select>
                        </div>
                  </div>
                  <div class="col-md-8 hours_row tuesday_box" style="<?php if($_tuesday == 1){ echo "display: block"; }?>">
                      <label>
                          <input type="checkbox" class="input_checkbox"  id="tuesday" name="tuesday"  <?php checkedProperty($_tuesday); ?>>Tuesday 
                          
                      </label>
                        <div class="select_filds mon">
                            <select name="start_tuesday" id="start_tuesday">
                                <?php 
                                  if($_start_tuesday != ""){
                                    echo "<option>$_start_tuesday</option>";
                                  }
                                  timeSelector(); 
                                ?>
                            </select>
   
                            <select name="end_tuesday" id="end_tuesday">
                                <?php 
                                  if($_end_tuesday != ""){
                                    echo "<option>$_end_tuesday</option>";
                                  }
                                  timeSelector(); 
                                ?>
                            </select>
                        </div>
                  </div>
                  <div class="col-md-8 hours_row tuesday_box" style="<?php if($_wednesday == 1){ echo "display: block"; }?>">
                      <label>
                          <input type="checkbox" class="input_checkbox"  id="wednesday" name="wednesday" <?php checkedProperty($_wednesday); ?>>Wednesday 
                          
                      </label>
                        <div class="select_filds tue">
                            <select name="start_wednesday" id="start_wednesday">
                                <?php 
                                  if($_start_wednesday != ""){
                                    echo "<option>$_start_wednesday</option>";
                                  }
                                  timeSelector(); 
                                ?>
                            </select>
   
                            <select name="end_wednesday" id="end_wednesday">
                                <?php 
                                  if($_end_wednesday != ""){
                                    echo "<option>$_end_wednesday</option>";
                                  }
                                  timeSelector(); 
                                ?>
                            </select>
                        </div>
                  </div>
                   <div class="col-md-8 hours_row thursday_box" style="<?php if($_thursday == 1){ echo "display: block"; }?>">
                      <label>
                          <input type="checkbox" class="input_checkbox"  id="thursday" name="thursday" <?php checkedProperty($_thursday); ?>>Thursday 
                          
                      </label>
                        <div class="select_filds thu">
                            <select name="start_thursday" id="start_thursday">
                                <?php 
                                  if($_start_thursday != ""){
                                    echo "<option>$_start_thursday</option>";
                                  }
                                  timeSelector(); 
                                ?>
                            </select>
   
                            <select name="end_thursday" id="end_thursday">
                                <?php 
                                  if($_end_thursday != ""){
                                    echo "<option>$_end_thursday</option>";
                                  }
                                  timeSelector(); 
                                ?>
                            </select>
                        </div>
                  </div>
                   <div class="col-md-8 hours_row friday_box" style="<?php if($_friday == 1){ echo "display: block"; }?>">
                      <label>
                          <input type="checkbox" class="input_checkbox"  id="friday" name="friday" <?php checkedProperty($_friday); ?>>Friday 
                          
                      </label>
                        <div class="select_filds fri" <?php if($_friday == 1){ echo "display: block"; }?>>
                            <select name="start_friday" id="start_friday">
                                <?php 
                                  if($_start_friday != ""){
                                    echo "<option>$_start_friday</option>";
                                  }
                                  timeSelector(); 
                                ?>
                            </select>
   
                            <select name="end_friday" id="end_friday">
                                <?php 
                                  if($_end_friday != ""){
                                    echo "<option>$_end_friday</option>";
                                  }
                                  timeSelector(); 
                                ?>
                            </select>
                        </div>
                  </div>
              </div>
            </div>

            
            <div class="text_box">
                <h1>How will Guests access the space?</h1>
                <p>
                   Some Guests will have specific requirements, so only select the option you can provide.
                </p>
            </div>
            <div class="custom-select" style="width:200px;">
                <select name="access_method" id="access_method" required>
                    <?php 
                      if($_access_method == ""){
                    ?>
                    <option value="0">Select Access Method</option>
                    <?php 
                      }else{
                        echo "<option value='$_access_method'>".$_access_method."</option>" ; 
                      }
                    ?>
                    <option value="With a Key">With a Key</option>
                    <option value="With a Fob">With a Fob</option>
                    <option value="With a Pin Coder">With a Pin Code</option>
                    <option value="With a Fingerprint Scanner">With a Fingerprint Scanner</option>
                    <option value="Access is granted each time">Access is granted each time</option>
                </select>
            </div>
            <div class="text_box">
                <h1>Are you using the space to store your own items?</h1>
                <p>
                   Select this option only if you’re using any of the space for your own stuff. Be sure to exclude any space you’re using from the listing measurements.
                </p>
            </div>
            <div class="row" style="margin-bottom: 50px">
              <div class="col-md-12 are_u_using">
                <label>
                    <input type="checkbox" class="input_checkbox"  id="are_u_using" name="are_u_using" <?php 
                if($_are_u_using == 1){ 
                  echo "value='1'";
                  echo "checked='checked'";
                } ?>>I am using part of the space 
                    
                </label>
              </div>
            </div>
            <div class="text_box">
                  <h1>Access Instructions</h1>
                  <p>
                   Write access instructions to give Guests all the information they need to access the space. Clear access instructions will help your bookings run smoothly, so try to be as specific as possible.
Write access instructions to give Guests all the information they need to access the space. Clear access instructions will help your bookings run smoothly, so try to be as specific as possible.
                  </p>
                   <div class="description_small">
                      <textarea name="access_text" id="access_text" ><?php if($_access_text != ""){ echo $_access_text; } ?>
                      </textarea>
                    </div>
              </div>
        
           
            <?php 
               wp_nonce_field("update_listing_action");
            ?>
            <input type="hidden" name="pid"  value="<?php echo $post_id ?>">
            <input type="hidden" name="step_7"  value="step_7">
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
   
var x, i, j, l, ll, selElmnt, a, b, c;
/*look for any elements with the class "custom-select":*/
x = document.getElementsByClassName("custom-select");
l = x.length;
for (i = 0; i < l; i++) {
  selElmnt = x[i].getElementsByTagName("select")[0];
  ll = selElmnt.length;
  /*for each element, create a new DIV that will act as the selected item:*/
  a = document.createElement("DIV");
  a.setAttribute("class", "select-selected");
  a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
  x[i].appendChild(a);
  /*for each element, create a new DIV that will contain the option list:*/
  b = document.createElement("DIV");
  b.setAttribute("class", "select-items select-hide");
  for (j = 1; j < ll; j++) {
    /*for each option in the original select element,
    create a new DIV that will act as an option item:*/
    c = document.createElement("DIV");
    c.innerHTML = selElmnt.options[j].innerHTML;
    c.addEventListener("click", function(e) {
        /*when an item is clicked, update the original select box,
        and the selected item:*/
        var y, i, k, s, h, sl, yl;
        s = this.parentNode.parentNode.getElementsByTagName("select")[0];
        sl = s.length;
        h = this.parentNode.previousSibling;
        for (i = 0; i < sl; i++) {
          if (s.options[i].innerHTML == this.innerHTML) {
            s.selectedIndex = i;
            h.innerHTML = this.innerHTML;
            y = this.parentNode.getElementsByClassName("same-as-selected");
            yl = y.length;
            for (k = 0; k < yl; k++) {
              y[k].removeAttribute("class");
            }
            this.setAttribute("class", "same-as-selected");
            break;
          }
        }
        h.click();
    });
    b.appendChild(c);
  }
  x[i].appendChild(b);
  a.addEventListener("click", function(e) {
      /*when the select box is clicked, close any other select boxes,
      and open/close the current select box:*/
      e.stopPropagation();
      closeAllSelect(this);
      this.nextSibling.classList.toggle("select-hide");
      this.classList.toggle("select-arrow-active");
    });
}
function closeAllSelect(elmnt) {
  /*a function that will close all select boxes in the document,
  except the current select box:*/
  var x, y, i, xl, yl, arrNo = [];
  x = document.getElementsByClassName("select-items");
  y = document.getElementsByClassName("select-selected");
  xl = x.length;
  yl = y.length;
  for (i = 0; i < yl; i++) {
    if (elmnt == y[i]) {
      arrNo.push(i)
    } else {
      y[i].classList.remove("select-arrow-active");
    }
  }
  for (i = 0; i < xl; i++) {
    if (arrNo.indexOf(i)) {
      x[i].classList.add("select-hide");
    }
  }
}
/*if the user clicks anywhere outside the select box,
then close all select boxes:*/
document.addEventListener("click", closeAllSelect);

$(".custom_select_1").click(function(){
  var c_select = $("#access_type").val();
  if(c_select == "Specific Hours"){
    //alert(1);
    $(".space_using").css({"display":"block"});
  }else{
    $(".space_using").css({"display":"none"});
    $(".input_checkbox").val("");
    $('.input_checkbox').prop('checked', false);
  }

});

function timeSettins(dayName, dayClass){
  $(dayName).on('click',function () {
      if ($(this).is(':checked')) {
          $(this).val(1);
          $(dayClass).css({ 'display' : 'block' });
      } else {
          $(this).val(0);
          $(dayClass).css({ 'display' : 'none' });
      }
  });
}
timeSettins(".saturday_box input",".sat");
timeSettins(".sunday_box input",".sun");
timeSettins(".monday_box input",".mon");
timeSettins(".tuesday_box input",".tue");
timeSettins(".wednesday_box input",".wed");
timeSettins(".thursday_box input",".thu");
timeSettins(".friday_box input",".fri");
timeSettins(".are_u_using input","");


 




    


</script>



