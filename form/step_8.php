
<?php

  $post_id = $_GET['step_8'];
    
  global $current_user;
  wp_get_current_user();
  $post   = get_post( $post_id );
  $meta = get_post_meta( $post_id );
  if ($post_id == "" OR !is_user_logged_in() OR $current_user->ID != $post->post_author)  {
      wp_die('Something went wrong!');
  }
  $minimum_month_rent   = "";
  $booked_within        = "";
  
  if(metadata_exists('post', $post_id, 'minimum_rental')){
    $unser = unserialize($meta['minimum_rental'][0]);
    $minimum_month_rent   = $unser['_minimum_month_rent'];
    $booked_within        = $unser['_booked_within'];
  }

//echo "<pre>";
//print_r($unser);
//echo "</pre>";


?>
<div class="container"><div class="form_header">
    <div class="row">
            <div class="col-md-8 header_left">
                <h2>Step-8</h2>
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
                <h1>What’s the shortest booking you’d be happy to take?</h1>
                <p>
                   A shorter booking duration means you’ll appear in more Guest searches, which increases your chances of getting a booking.
                </p>
            </div>
            <div class="custom-select" style="width:200px;">
                <select name="minimum_month_rent" id="minimum_month_rent" required>
                    <?php 
                      if($minimum_month_rent == ""){
                    ?>
                    <option value="0">Select Months</option>
                    <?php 
                      }else{
                        echo "<option value='$minimum_month_rent'>".$minimum_month_rent."</option>" ; 
                      }
                    ?>
                    <option value="1">1 Month</option>
                    <option value="2">2 Months</option>
                    <option value="3">3 Months</option>
                    <option value="6">6 Months</option>
                    <option value="12">12 Months</option>
                </select>
            </div>
            <div class="text_box">
                <h1>How soon in advance can your space be booked?</h1>
                <p>
                   Guests will usually make a booking ahead of their start date, so we need to know the minimum amount of time you'll need before bookings can start.
                </p>
            </div>
          <div class="custom-select" style="width:200px;">
                <select name="booked_within" id="booked_within" required>
                    <?php 
                      if($booked_within == ""){
                    ?>
                    <option value="0">Select </option>
                    <?php 
                      }else{
                        echo "<option value='$booked_within'>".$booked_within."</option>" ; 
                      }
                    ?>
                    <option value="1 Day">1 Day</option>
                    <option value="2 Days">2 Days</option>
                    <option value="3 Days">3 Days</option>
                    <option value="7 days">7 days</option>
                </select>
            </div>
           
           
            <?php 
               wp_nonce_field("update_listing_action");
            ?>
            <input type="hidden" name="pid"  value="<?php echo $post_id ?>">
            <input type="hidden" name="step_8"  value="step_8">
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



