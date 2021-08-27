<?php 
// Creating the widget 
class Booking_widget extends WP_Widget {
  
	function __construct() {
	parent::__construct(
	  
	// Base ID of your widget
	'wpb_widget', 
	  
	// Widget name will appear in UI
	__('Booking Widget (new)', 'ext-listify'), 
	  
	// Widget description
	array( 'description' => __( 'Extending listyfy booking system', 'ext-listify' ), ) 
	);
	}


	// Creating widget front-end
		
	public function widget( $args, $instance ) {

		//Reset all coocie data 
		setcookie("custom_price",'', 0, "/");
        setcookie("listing_info",'', 0, "/");
        setcookie("booking_id",'', 0, "/");


		$postid = get_the_ID();
		$postAuthor = get_post_field( 'post_author', $postid );
		$price = get_post_meta( $postid, 'pricing', true);
		$priceIns = get_post_meta( $postid, 'pricing', true);
		$priceOrg = get_post_meta( $postid, 'pricing', true);
		$msrmnt_info = get_post_meta( $postid, 'measurment_info', true);
		
		$metas = get_post_meta( $postid, 'custom_status_st', true);
		//print_r($msrmnt_info);

		$rental_info = get_post_meta( $postid);
		$rental = unserialize($rental_info['minimum_rental'][0]);
		$storage_info = get_post_meta( $postid);
		$storage = unserialize($storage_info['storage_info'][0]);
		$size = $msrmnt_info['_width'] * $msrmnt_info['_depth'];
		$sizeForOneMeter = $msrmnt_info['_width'] * $msrmnt_info['_depth'];

		
		$price = $price['_pricing'];
		$priceForOne = $priceIns['_pricing'];

		
		if( ! is_array($rental) && !is_array($msrmnt_info) ){
			return false;
		}
		$active = false;
		$show_prev_size = "";
		$booking_metadata_info = get_post_meta( $postid);
		if(metadata_exists('post',$postid,'booking_metadata')){
			$booking_metadata = unserialize($booking_metadata_info['booking_metadata'][0]);
			//echo "<pre>";
			//print_r($booking_metadata);
			//echo "</pre>";
			$size = $booking_metadata['area_left'];
			//$size = $price / $sizeForOneMeter;
			
			$price = floor(($priceForOne / $sizeForOneMeter) * $size) ;

			$active = true;
			//$show_prev_size = "inline-block;";
		}
		
		

		?>
		<div class="booking_form">
			<div class="form_row row_1" style="margin-bottom: 15px;">
				<div class="price_and_month">
					<span id="price_holder" style="display: none"><?php echo $price; ?></span>
					<span class="_price" >
						 <?php 
                          global  $woocommerce;
                          echo get_woocommerce_currency_symbol();
                        ?><span id="price"><?php echo $price; ?>
						</span>
					</span>
					<span class="month"> / Month</span>
				</div>
				<div class="dimension">
					<span  id="only_size_holder" style="display: none"><?php echo $size; ?> </span>
					<span class="" id="dimension_size_inp" style="display: none"><?php echo $size; ?> 
				</span>
					<span class="" id="one_meter" style="display: none"><?php echo $priceForOne / $sizeForOneMeter; ?> </span>
					<span class="dimension_size" id="dimension_size">
							<?php echo $size; ?> 
					</span>
					
					</span> sq <?php echo $msrmnt_info['_measurment_type']; ?></span>
				</div>
			</div>
			<div class="form_row">
				<span class="cal_wrapp">
					<ion-icon name="calendar-outline"></ion-icon>
					<input class="bookling_calender datepicker" id="bookling_calender" value="Select Start Date" readonly/>
				</span>
			</div>
			<div class="form_row">
				<span class="choose_area">
					<?php 
						//if($booking_metadata['booking_type'] == 1 ){
					?>
					<a class="full_space active">Full Space</a>
					<?php //} ?>
					<?php 
						if($storage['_multiple_hosting'] == 1){
					?>
					<a class="partial_space <?php if($active == true){echo "active";}?>">Partial Space</a>
					<?php } ?>
					<?php 
						if($storage['_multiple_hosting'] == 1){
					?>
					<a class="fulfill_by_host">Fulfill By Host</a>
					<?php 
						}
					?>
				</span>
				<div class="partial_window">
					<div class="text_area">
						Move the slider to adjust the amount of space you need
					</div>
					 <main class="slider_wrap">
						<div class="fill-area"></div>
						<label style="display: none" id="range-value" for="range">
						<?php 
							
						?></label>
					</main>
					<input id="range" type="range" name="range" value="100" min="1" max="<?php echo $size; ?>" onmousemove="handleMouseMove(this.value)" onchange="handleMouseMove(this.value)"/>
				</div>
				
			</div>
			<form method="post" action="" id="book_listing" >
				<div class="full_by_host_window">
					
					<div class="modal-content">
						<div class="m_body" style="height: 400px;">
							<div class="form_body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="">E-commerce shop web address(Optional)</label>
											<input type="text" name="shop_address" id="shop_address" placeholder="" class="form-control">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
										<label for="">Weight per product</label>
											<input type="text" name="origin_country" id="origin_country" placeholder="" class="form-control">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
										<label for="">What kind of product?</label>
											<input type="text" name="prodcut_type" id="prodcut_type" placeholder="" class="form-control">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
										<label for="">Quantity</label>
											<input type="text" name="quantity" id="quantity" placeholder="" class="form-control">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="">Price per product</label>
											<input name="price_per_prodcut" id="price_per_prodcut" type="text" placeholder="" class="form-control">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group" style="margin-bottom: 20px;">
											<label for="">Require Packeging
											<input id="require_packeging_pop" name="require_packeging" type="checkbox"  class="form-control input_checkbox" value="0" >
											</label>
										</div>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>

				<input type="hidden" name="_pricing" id="_pricing" value="<?php echo $price; ?>">
				<input type="hidden" name="_size" id="_size" value="<?php echo $size; ?>">
				<input type="hidden" name="_size_total" id="_size_total" value="<?php echo $size; ?>">
				<input type="hidden" name="post_title" value="<?php echo the_title(); ?>">
				<input type="hidden" name="booking_date" id="booking_date" value="">
				<input type="hidden" name="listing_id"  value="<?php echo $postid; ?>">
				<input type="hidden" name="listing_author"  value="<?php echo $postAuthor; ?>">
				<input type="hidden" name="min_rental" id="min_rental" value="<?php echo $rental['_minimum_month_rent']; ?>">
				<input type="hidden" id="booking_type" name="booking_type" value="1">

				<!--  Range value -->
				<input type="hidden" name="range_val" id="range_val" >
			
				
				<img src="<?php echo PluginUrl(); ?>images/spin.gif" class="small_loader_front">
				<input type="hidden" name="action" value="book_listing" />
				<input type="submit" value="Book Now" class="custom_btn">
			</form>
			<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
			<script>
				
		
				$('.fulfill_by_host').on('click', function() {
					
					$(".full_by_host_window").show();
				});
				
				$('.summery_div').on('click', function() {
					var modal = document.getElementById("myModal");
					modal.style.display = "block";
				});
			

				 jQuery(document).ready(function() {
					//jQuery('.datepicker').datepicker();
					jQuery( function() {
						jQuery( ".datepicker" ).datepicker({
							minDate: 0,
							dateFormat: 'yy-mm-dd'
						});
					} );

					jQuery('#bookling_calender').on('change', function(e) {
						e.preventDefault();
   						$("#booking_date").val(this.value);
					});

				});
				
			  $(document).ready(function(){
				
					
					 $('#slider').change(function(){
						document.getElementById('range_val').value=$(this).val();
					});
					

					$('.choose_area a').bind('click', function() {
						// remove the active class from all elements with active class
						$('.active').removeClass('active')
						// add active class to clicked element
						$(this).addClass('active');
						
						
						if($(".full_space").hasClass('active')){
							$("#booking_type").val(1);
							$('.partial_window').removeClass('show');
							var priceHoldr = $("#price_holder").text();
							var only_size_holder = $("#only_size_holder").text();

							$("#price").text(priceHoldr);
							$("#dimension_size_inp").text(only_size_holder);
							$("#dimension_size").text(only_size_holder);
							$("#_pricing").val(priceHoldr);
							$("#_size").val(only_size_holder);

						}


						if($(".partial_space").hasClass('active')){
							$('.partial_window').addClass('show');
							$("#booking_type").val(2);
							$('.full_by_host_window').css({'display': 'none'});
						}else{
							$('.partial_window').removeClass('show');
						}

						if($(".fulfill_by_host").hasClass('active')){
							$("#booking_type").val(3);
							$('.full_by_host_window').css({'display': 'block'});
							$('.partial_window').addClass('show');
						}else{
							$('.full_by_host_window').css({'display': 'none'});
						}

					});

					
					$('#require_packeging_pop').on('click',function () {
						if ($(this).is(':checked')) {
							$(this).val(1);
                            alert("Packeges popup");
						} else {
							$(this).val(0);
						}
                        
					});

                   
								
			  });
			  
			  	function handleMouseMove(value) {
					const rangeValueElement = document.querySelector("#range-value");
					var  dimension_size = document.querySelector("#dimension_size");
					var  only_size_holder = document.querySelector("#only_size_holder");
					const dimension_size_inp = document.querySelector("#dimension_size").textContent;
					const price_holder = document.querySelector("#price_holder").textContent;
					const price = document.querySelector("#price");
					const inputElement = document.querySelector('input[type="range"]');
					const fillAreaElement = document.querySelector(".fill-area");
					const one_meter = document.querySelector("#one_meter").textContent;

					const hueRotate = "hue-rotate(" + value + "deg)";

					rangeValueElement.textContent = value;
					//alert(price_holderInp);
					dimension_size.textContent = value;

					//oneMeter =  dimension_size_inp / price_holder ;
					//alert(oneMeter);
					calcRes = Math.floor(one_meter * value);
					price.textContent =  calcRes;
					//Get the data into the form area 
					document.querySelector('#_pricing').value = calcRes;
					document.querySelector('#_size').value = value;
					rangeValueElement.style.filter = hueRotate;

					retVal = ( 100 * value) / only_size_holder.textContent ;
					//alert(dimension_size.textContent);
					fillAreaElement.style.left = retVal + "%";
					fillAreaElement.style.width = 100 - retVal  + "%";
					//fillAreaElement.style.filter = hueRotate;
				}
			
				
			</script>
		</div>
	
		<?php
	}
          
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
		$title = __( 'New title', 'ext-listify' );
	}
	// Widget admin form
	?>
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
	<?php 
	}
      
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
	$instance = array();
	$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
	return $instance;
	}
	 
// Class Booking_widget ends here
} 

class Listing_details extends WP_Widget {
  
	function __construct() {
	parent::__construct(
	  
	// Base ID of your widget
	'listing_details_ID', 
	  
	// Widget name will appear in UI
	__('Listing Details(new)', 'ext-listify'), 
	  
	// Widget description
	array( 'description' => __( 'Listify description area', 'ext-listify' ), ) 
	);
	}



	// Creating widget front-end
		
	public function widget( $args, $instance ) {
		$postid = get_the_ID();
		$meta  = get_post_meta( $postid );
		//echo "<pre>";
		//print_r(unserialize($meta['_gallery_images'][0]));
		//echo "</pre>";
		function getFieldData($post_id,$key,$val){
			$meta  = get_post_meta( $post_id );
			$unser = unserialize($meta[$key][0]);
			echo $unser[$val];
		}
		?>
		<div class="description">
			<h1>Details</h1>
			<div class="custom_table" width="">
			
				<div class="table_rows">
					<div class="table_row">
						<div>Type</div>
						<div>
							<strong>
							<?php 
								getFieldData($postid,'storage_info','_space_type');
							?>
							</strong>
						</div>
					</div>
					<div class="table_row">
						<div>Price</div>
						<div>
							<strong>
							<?php 
								getFieldData($postid,'pricing','_pricing');
							?>
							</strong>
							<small> / Month</small>
						</div>
					</div>
					<div class="table_row">
						<div>Space Size</div>
						<div>
							<strong>
							<?php 
								
								$dimension = unserialize($meta['measurment_info'][0]);
								$width = $dimension['_width'];
								$depth = $dimension['_depth'];
								$height = $dimension['_height'];
								$ms_type = $dimension['_measurment_type'];
								if($width != "" && $depth != ""){
									echo $width * $depth;
								}
							?>
							</strong>
							<small>
								<?php 
								if($ms_type  == 'ft') {
									echo 'sq ft';
								}else{
									echo 'sq meter';
								}
								?>
							</small>
						</div>
					</div>
					<div class="table_row">
						<div>Dimensions</div>
						<div>
							<small>w</small>
							<strong>
							<?php 
								echo $width;
							?>
							</strong>
							<small><?php echo $ms_type; ?></small>
							<small>x</small>
							<small>d</small>
							<strong>
							<?php 
								echo $depth;
							?>
							</strong>
							<small><?php echo $ms_type; ?></small>
							<small>x</small>
							<small>h</small>
							<strong>
							<?php 
								getFieldData($postid,'measurment_info','_height');
							?>
							</strong>
							<small><?php echo $ms_type; ?></small>
						</div>
					</div>
					<div class="table_row">
						<div>Minimum Rental</div>
						<div>
							<strong>
							<?php 
								getFieldData($postid,'minimum_rental','_minimum_month_rent');
							?> Month
							</strong>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		<?php
	}
          
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
		$title = __( 'New title', 'ext-listify' );
	}
	// Widget admin form
	?>
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
	<?php 
	}
      
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
	 
// Class Booking_widget ends here
} 
class Listing_features extends WP_Widget {
  
	function __construct() {
	parent::__construct(
	  
	// Base ID of your widget
	'Listing_features_ID', 
	  
	// Widget name will appear in UI
	__('Listing Features(new)', 'ext-listify'), 
	  
	// Widget description
	array( 'description' => __( 'Listify features area', 'ext-listify' ), ) 
	);
	}


	// Creating widget front-end
		
	public function widget( $args, $instance ) {
		$postid = get_the_ID();
		$data = get_post_meta( $postid, 'feature_info',true);
		//echo "<pre>";
		//print_r($data);
		//echo "</pre>";
	
		?>
		<div class="description">
			<h1>Features</h1>
			<div class="featues_list" width="">
				<?php 
					if( is_array($data) ){
					if($data['_bolt_lock'] == 1){
						echo "<li class='icon_class _bolt_lock'>";
						echo "Bolt Lock";
						echo "</li>";
					}                  
					if($data['_CCTV'] == 1){
						echo "<li class='icon_class _cctv'>";
						echo "CCTV";
						echo "</li>";
					}
					if($data['_Door_defender_lock'] == 1){
						echo "<li class='icon_class _Door_defender_lock'>";
						echo "Door Defender Lock";
						echo "</li>";
					}
					if($data['_lockable_door'] == 1){
						echo "<li class='icon_class _lockable_door'>";
						echo "Lockable Door ";
						echo "</li>";
					}
					if($data['_on_site_staff'] == 1){
						echo "<li class='icon_class _on_site_staff'>";
						echo "On Site Stuff";
						echo "</li>";
					}
					if($data['_padlock'] == 1){
						echo "<li class='icon_class _padlock'>";
						echo "Padlock";
						echo "</li>";
					}
					if($data['_roller_shutter_doors'] == 1){
						echo "<li class='icon_class _roller_shutter_doors'>";
						echo "Roller Shutter Doors";
						echo "</li>";
					}
					if($data['_security_alarm'] == 1){
						echo "<li class='icon_class _security_alarm'>";
						echo "Security Alarm";
						echo "</li>";
					}
					if($data['_security_bar'] == 1){
						echo "<li class='icon_class _security_bar'>";
						echo "Security Bar";
						echo "</li>";
					} 
					if($data['_security_gate'] == 1){
						echo "<li class='icon_class _security_gate'>";
						echo "Security Gate";
						echo "</li>";
					} 
					if($data['_security_lighting'] == 1){
						echo "<li class='icon_class _security_lighting'>";
						echo "Security Lighting";
						echo "</li>";
					}
					if($data['_smoke_detector'] == 1){
						echo "<li class='icon_class _smoke_detector'>";
						echo "Smoke Detector";
						echo "</li>";
					}
					if($data['_climate_control'] == 1){
						echo "<li class='icon_class _climate_control'>";
						echo "Climate Control";
						echo "</li>";
					}	
					if($data['_dehumidifier'] == 1){
						echo "<li class='icon_class _dehumidifier'>";
						echo "Dehumidifier";
						echo "</li>";
					}
					if($data['_electricity_car_charging'] == 1){
						echo "<li class='icon_class _electricity_car_charging'>";
						echo "Electricity Car Charging";
						echo "</li>";
					}
					if($data['_electricity_normal_socket'] == 1){
						echo "<li class='icon_class _electricity_normal_socket'>";
						echo "Electricity Normal Socket";
						echo "</li>";
					}
					if($data['_Electricity_three_phase'] == 1){
						echo "<li class='icon_class _Electricity_three_phase'>";
						echo "Electricity Three Phase";
						echo "</li>";
					}
					if($data['_fire_alarm'] == 1){
						echo "<li class='icon_class _fire_alarm'>";
						echo "Fire Alarm";
						echo "</li>";
					}
					if($data['_ground_door_strip'] == 1){
						echo "<li class='icon_class _ground_door_strip'>";
						echo "Ground Door Strip";
						echo "</li>";
					}
					if($data['_heating'] == 1){
						echo "<li class='icon_class _heating'>";
						echo "Heating";
						echo "</li>";
					} 
					if($data['_lighting'] == 1){
						echo "<li class='icon_class _lighting'>";
						echo "Lighting";
						echo "</li>";
					} 
					if($data['_private_entrance'] == 1){
						echo "<li class='icon_class _private_entrance'>";
						echo "Private Entrance";
						echo "</li>";
					} 
					if($data['_shelving'] == 1){
						echo "<li class='icon_class _shelving'>";
						echo "Shelving";
						echo "</li>";
					}
					if($data['_water_supply'] == 1){
						echo "<li class='icon_class _water_supply'>";
						echo "Water Supply";
						echo "</li>";
					}
					
				}
					
					
				?>
			</div>
		</div>
		<?php
	}
          
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
		$title = __( 'New title', 'ext-listify' );
	}
	// Widget admin form
	?>
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
	<?php 
	}
      
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
	 
// Class Booking_widget ends here
} 

class Listing_access extends WP_Widget {
  
	function __construct() {
	parent::__construct(
	  
	// Base ID of your widget
	'Listing_access_ID', 
	  
	// Widget name will appear in UI
	__('Listing Access (new)', 'ext-listify'), 
	  
	// Widget description
	array( 'description' => __( 'Listify access area', 'ext-listify' ), ) 
	);
	}


	// Creating widget front-end
		
	public function widget( $args, $instance ) {
		$postid = get_the_ID();
		$data = get_post_meta( $postid, 'storage_info',true);
		$access_type = get_post_meta( $postid, 'access_info',true);
		//print_r($access_type);
	
		?>
		<div class="description">
			<h1>Access</h1>
			<div class="featues_list access_sepc" width="">
				<?php 
					//Hosting type
				if( is_array($data) ){
					if($data['_multiple_hosting'] == 1 ){
						echo "<li class='icon_class full_space'>";
						echo "<h5>Full Space</h5>";
						echo "<p>You'll be the only Guest using this space. Happy days! </p>";
						echo "</li>";
					}else{
						echo "<li class='icon_class partial_space'>";
						echo "<h5>Partial Access</h5>";
						echo "<p>Place will be shared by multiple user! </p>";
						echo "</li>";
					} 
					//Floor Level
					if($data['_floor_level'] == "Ground Level" ){
						echo "<li class='icon_class ground'>";
						echo "<h5>Ground Level</h5>";
						echo "<p>This location is ground level</p>";
						echo "</li>";
					}elseif($data['_floor_level'] == "1st Floor" ){
						echo "<li class='icon_class first_floor'>";
						echo "<h5>1st Floor</h5>";
						echo "<p>This location is 1st Floor</p>";
						echo "</li>";
					}elseif($data['_floor_level'] == "2nd Floor" ){
						echo "<li class='icon_class scnd_floors'>";
						echo "<h5>2nd Floor</h5>";
						echo "<p>This location is 2nd Floor</p>";
						echo "</li>";
					}elseif($data['_floor_level'] == "3rd Floor or Higher" ){
						echo "<li class='icon_class third_floors'>";
						echo "<h5>3rd Floor or Higher</h5>";
						echo "<p>This location is 3rd Floor or Higher</p>";
						echo "</li>";
					}elseif($data['_floor_level'] == "Below Ground" ){
						echo "<li class='icon_class below_ground'>";
						echo "<h5>Below Ground</h5>";
						echo "<p>This location is Below Ground</p>";
						echo "</li>";
					}elseif($data['_floor_level'] == "Multiple Floors" ){
						echo "<li class='icon_class multiple_floors'>";
						echo "<h5>Multiple Floors</h5>";
						echo "<p>This location is Multiple Floors</p>";
						echo "</li>";
					}

					// Access Method
					if($access_type['_access_method'] == "With a Fob" ){
						echo "<li class='icon_class With_a_Fob'>";
						echo "<h5>Fob Provided </h5>";
						echo "<p>The Host will provide you a fob to access the space.  </p>";
						echo "</li>";
					}elseif($access_type['_access_method'] == "With a Key" ){
						echo "<li class='icon_class With_a_Key'>";
						echo "<h5>With a Key</h5>";
						echo "<p>The Host will provide you a key to access the space.  </p>";
						echo "</li>";
					}elseif($access_type['_access_method'] == "With a Pin Coder" ){
						echo "<li class='icon_class With_a_Pin'>";
						echo "<h5>With a Pin Coder</h5>";
						echo "<p>The Host will provide you pin code to access the space.  </p>";
						echo "</li>";
					}elseif($access_type['_access_method'] == "With a Fingerprint Scanner" ){
						echo "<li class='icon_class With_a_Finger_Scanner'>";
						echo "<h5>With a Fingerprint Scanner</h5>";
						echo "<p>The Host will provide fingerprint scanner to access the space.  </p>";
						echo "</li>";
					}elseif($access_type['_access_method'] == "Access is granted each time" ){
						echo "<li class='icon_class grantEach_time'>";
						echo "<h5>Access is granted each time </h5>";
						echo "<p>The Host will grant you access to the space each time you need to access it.</p>";
						echo "</li>";
					}

					//Acces Time  
					
					if($access_type['_access_type'] == "Specific Hours" ){
						echo "<li class='icon_class specific_hours'>";
						echo "<h5>Specific Hours</h5>";
						echo "<p>You can only access the space during the specified hours below. </p>";

						?>
						
							<table class='table custom_table' width='300px'>
								<tr><th>Monday</th><td> 
									<?php 
										echo $access_type['_start_saturday'];
										echo " > ";
										echo $access_type['_end_saturday'];
									?>
								</td></tr>
								<tr><th>Tuesday</th>
									<td>
										<?php 
										echo $access_type['_start_saturday'];
										echo " > ";
										echo $access_type['_end_tuesday'];
									?>
									</td>
								</tr>
								<tr><th>Wednesday</th>
									<td>
										<?php 
										echo $access_type['_start_wednesday'];
										echo " > ";
										echo $access_type['_end_wednesday'];
									?>
									</td>	
								</tr>
								<tr><th>Thursday</th>
									<td>
										<?php 
										echo $access_type['_start_saturday'];
										echo " > ";
										echo $access_type['_end_saturday'];
									?>
									</td>	
								</tr>
								<tr><th>Friday</th>
									<td>
										<?php 
										echo $access_type['_start_friday'];
										echo " > ";
										echo $access_type['_end_friday'];
									?>
									</td>	
								</tr>
								<tr><th>Saturday</th>
									<td>
										<?php 
										echo $access_type['_start_saturday'];
										echo " > ";
										echo $access_type['_end_saturday'];
									?>
									</td>	
								</tr>
								<tr><th>Sunday</th>
									<td>
										<?php 
										echo $access_type['_start_sunday'];
										echo " > ";
										echo $access_type['_end_sunday'];
									?>
									<t/d>	
								</tr>
							</table>
						
						<?php
						echo "</li>";
					}elseif($access_type['_access_type'] == "Anytime" ){
						echo "<li class='icon_class anytime'>";
						echo "<h5>Anytime</h5>";
						echo "<p>You can access the space anytime. </p>";
						echo "</li>";
					}elseif($access_type['_access_type'] == "Prior Notice Only" ){
						echo "<li class='icon_class prior_notice_only'>";
						echo "<h5>Prior Notice Only</h5>";
						echo "<p>Get in touch with the host whenever you need to access the space. </p>";
						
						echo "</li>";
					}elseif($access_type['_access_type'] == "Drop-off Only" ){
						echo "<li class='icon_class drop_off_only'>";
						echo "<h5>Drop-off Only</h5>";
						echo "<p>You can only access the space to pick up & drop off your stuff.  </p>";
						echo "</li>";
					}
				}
				?>
			</div>
		</div>
		<?php
	}
          
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
		$title = __( 'New title', 'ext-listify' );
	}
	// Widget admin form
	?>
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
	<?php 
	}
      
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
	 
// Class Booking_widget ends here
}

class Listing_location extends WP_Widget {
  
	function __construct() {
	parent::__construct(
	  
	// Base ID of your widget
	'Listing_location_ID', 
	  
	// Widget name will appear in UI
	__('Listing Location(new)', 'ext-listify'), 
	  
	// Widget description
	array( 'description' => __( 'Listify Location area', 'ext-listify' ), ) 
	);
	}


	// Creating widget front-end
		
	public function widget( $args, $instance ) {
		$postid = get_the_ID();
		$data = get_post_meta( $postid, '_general_feature',true);
		//print_r($data);
	
		?>
		<div class="description">
			<h1>Location</h1>
			<div class="featues_list" width="">
				<?php 
				
					
				?>
			</div>
		</div>
		<?php
	}
          
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
		$title = __( 'New title', 'ext-listify' );
	}
	// Widget admin form
	?>
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
	<?php 
	}
      
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
	 
// Class Booking_widget ends here
} 
class CheckoutContent extends WP_Widget {
  
	function __construct() {
	parent::__construct(
	  
	// Base ID of your widget
	'Checkout_content_ID', 
	  
	// Widget name will appear in UI
	__('Checkout Content(new)', 'ext-listify'), 
	  
	// Widget description
	array( 'description' => __( 'Listify Checkout area sidebar', 'ext-listify' ), ) 
	);
	}


	// Creating widget front-end
		
	public function widget( $args, $instance ) {
		$postid = get_the_ID();
		$data = get_post_meta( $postid, '_general_feature',true);
		//print_r($data);
		if(isset($_COOKIE['listing_info'])){
			//$data = unserialize($_COOKIE['listing_info']);
			$data = unserialize(base64_decode(($_COOKIE['listing_info'])));
			//print_r($data);
			global  $woocommerce;
			$moneySymb =  get_woocommerce_currency_symbol();
	
		?>
		<div class="check_description">
			<div class="lisinting_thumbnail">
				<?php echo get_the_post_thumbnail( $data['listing_id'] ); ?>
			</div>
			<h1><?php echo $data['post_title'];?></h1>
			<div class="featues_list" width="">
				<div class="price_table">
					<div class="check_price"><strong>Price:</strong> <?php echo $data['price']; ?></div>
					<div class="cehck_size"><strong>Size:</strong> <?php echo $data['size'];echo $data['meter_name']; ?> </div>
				</div>
				<div class="duration">
					<div class=""><strong>Starting date:</strong><?php echo $data['starting_date']; ?></div>
					<div class=""><strong>Ending date:</strong><?php echo $data['ending_date']; ?></div>
				</div>
			</div>
		</div>
		<?php
		} ?>

		<div class="discalimer">
			<h2>Cancellation and refunds policy</h2>
			<p>Full refund minus and <?php echo $moneySymb; ?>25 cancellation fee applies if cancelled before 15th july </p>
			<a href="">Read More</a>

		</div>
		

		<?php 


	}
          
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
		$title = __( 'New title', 'ext-listify' );
	}
	// Widget admin form
	?>
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
	<?php 
	}
      
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
	 
// Class Booking_widget ends here
} 

function ext_listify_load_widget() {
	register_widget( 'Booking_widget' );
	register_widget( 'Listing_details' );
	register_widget( 'Listing_location' );
	register_widget( 'Listing_features' );
	register_widget( 'Listing_access' );
	register_widget( 'CheckoutContent' );
}
add_action( 'widgets_init', 'ext_listify_load_widget' );
