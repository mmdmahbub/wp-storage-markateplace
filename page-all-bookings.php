<?php /* Template Name: All bookinfgs */ ?>
<?php 


if (!is_user_logged_in())  {
    wp_die('Something went wrong!');
}
get_header();
//the_content();

if(isset($_GET['delete'])){
    $del_id = $_GET['delete'];
    wp_delete_post($del_id);
    wp_redirect(site_url().'/myaccount/all-bookings/');
}


//update_post_meta( 2588, 'booking_metadata', '' );
//delete_post_meta(2533, 'booking_metadata');
if(isset($_POST['accept'])){
    //echo "<h1>Hello</h1>";
    $booking_id   = $_POST['booking_id'];
    $listing_id   = $_POST['listing_id'];
    $booking_type = $_POST['booking_type'];
    
    
    $listing_info = array(
		"is_avail" => 1
	);

    update_post_meta( $booking_id, 'booking_status', $listing_info );

 
        $_size_total     = $_POST['_size_total'];
        $size_selected   = $_POST['size_selected'];
        $area_left        = $_size_total - $size_selected;

        $meta = get_post_meta( $listing_id );
        $unser = unserialize($meta['booking_metadata'][0]);
        print_r($unser);
        $checkLimit = $unser['size_booked'] +  $size_selected;

        if($checkLimit == $_size_total){
           $status = 0;
        }else{
            $status = 1;
        }
        
        $booking_metadata = array(
            "booking_type" => $booking_type,
            "area_left" => $area_left,
            "status"      => $status,
        );

        update_post_meta( $listing_id, 'booking_metadata', $booking_metadata );
    


   wp_redirect(site_url().'/myaccount/all-bookings/');
}
if(isset($_POST['deny'])){
    echo "<h1>Hello</h1>";
    echo $booking_id = $_POST['booking_id'];
    $listing_info = array(
		"is_avail" => 2
	);
    update_post_meta( $booking_id, 'booking_status', $listing_info );
    
    //wp_redirect(site_url().'/myaccount/all-bookings/');
}
?>
	<div 
	<?php
	echo apply_filters(
		'listify_cover',
		'page-cover',
		array( // WPCS: XSS ok.
			'size' => 'full',
		)
	);
	?>
	>
		<h1 class="page-title cover-wrapper">
		<?php
		the_post();
		the_title();
		rewind_posts();
		?>
</h1>
	</div>

 <div class="custom-container" >
        <?php 
            do_action( 'listify_page_before' ); 
            global $current_user;
            $userID = wp_get_current_user();
            
        ?>

    <div>
        <br><br><br>
            <p>Your bookings are shown in the table below. </p>
            <h2 style='color: #000'>Booked By You</h2>
            <table class='job-manager-jobs'>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Date Booked</th>
                        <th>Subscription Info</th>
                        <th>Booking Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                                    
                        $args = array(
                            'post_type' => 'bookings',
                            'post_status' => 'any',
                            'author' => $current_user->ID,
                        );
                        $bookings =  get_posts( $args );
                        if(!empty($bookings)){
                       foreach($bookings as $bookings){

                           $meta = get_post_meta( $bookings->ID );
                           $unser = unserialize($meta['booking_status'][0]);
                           $b_info = unserialize($meta['booking_info'][0]);
                        //echo "<pre>"; 
                      // print_r($unser);
                     //echo "</pre>"; 
                    ?>
                    <tr>
                        <td ><?php echo $bookings->post_title; ?></td>
                        <td><?php  echo $bookings->post_date; ?></td>
                        <td>
                            <?php  
                                //if($bookings->post_status == "publish"){
                            ?>
                                 <span>Booking Type: <strong>
                                     <?php
                                    $btype =  $b_info['booking_type'];  
                                    if($btype == 1){
                                        echo "Full Space";
                                    }elseif($btype == 2){
                                        echo "Partial Space";
                                    }elseif($btype == 3){
                                        echo "FulFill By Host";
                                    }
                                 ?>
                                 </strong></span><br/>
                                  <span>Starting Date: <strong><?php  echo $b_info['starting_date']; ?></strong></span><br>
                                  <span>Ending Date: <strong><?php  echo $b_info['ending_date']; ?></strong></span>
                            
                            <?php 
                               // }
                             ?>
                        </td>
                        <td>
                            <?php 
                            
                                if($bookings->post_status != "draft"){
                                    if($unser['is_avail'] == 0){
                                        echo "<span style='color:blue'>Waiting to be accepted by host.</span>";
                                    }elseif($unser['is_avail'] == 2){
                                        echo "<span style='color:red'>Rejected</span>";
                                    }elseif($unser['is_avail'] == 1){
                                        echo "<span style='color:green'>Activated</span>";
                                    }
                                    
                                }else{
                                    echo $bookings->post_status;
                                }
                            ?>
                        </td>
                        <td>
                            <?php if($bookings->post_status != "publish"){ ?>
                            <a href="<?php site_url();?>/myaccount/all-bookings/?delete=<?php echo $bookings->ID; ?>">Delete</a>
                            <?php } ?>
                        </td>
                    </tr>
                
                <?php               
                    }}else{
                        echo "<tr><td><br><br><br>There is no booking currently available.<br><br><br></td></tr>";
                    }
                ?>

        </tbody>
            </table>

    </div>
    <h2 style='color: #000'>Your listing booked by people.</h2>
	<table class='job-manager-jobs'>
		<thead>
			<tr>
				<th>Listing Name</th>
				<th>Booked By</th>
				<th>Booking Info</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
        <?php  
               // global $bookings;
               $userid = wp_get_current_user();
                $params = array(
                    'post_type'   => 'bookings',
                    'post_status' => 'any',
                   
                    
                    //'post_author' => $userID,
                );
                $bookings   = get_posts( $params );
                
                foreach($bookings as $booking){

                    $meta = get_post_meta( $booking->ID );
                    $unser = unserialize($meta['booking_info'][0]);
                    $b_status = unserialize($meta['booking_status'][0]);

                  // echo "<pre>";
                  //  print_r($b_status);
                 //  echo "</pre>";
                   if($unser['listing_author'] == $current_user->ID && $booking->post_status == "publish"){
                //print_r($unser);
            ?>
                <tr>
                    <td><?php echo $booking->post_title; ?></td>
                    <td>
                        <?php $author_id=$booking->post_author; ?>
                        <?php the_author_meta( 'user_nicename' , $author_id ); ?> 
                    </td>
                    <td class="booking_info">
                        <span>Booking Type: <strong>
                        <?php 
                              $btype = $unser['booking_type'];  
                                if($btype == 1){
                                    echo "Full Space";
                                }elseif($btype == 2){
                                    echo "Partial Space";
                                }elseif($btype == 3){
                                    echo "FulFill By Host";
                                }
                         
                         ?></strong></span>
                        <span>Price: <strong><?php  echo $unser['price_for_booking']; ?></strong> & Size: <strong><?php  echo $unser['size_selected']; ?></strong></span>
                         <span>Starting Date: <strong><?php  echo $unser['starting_date']; ?></strong> & Ending Date: <strong><?php  echo $unser['ending_date']; ?></strong></span>
                    </td>
                    <td class="action_listing">
                        <?php  if($b_status['is_avail'] == 1){ 
                            echo "<span style='color: green'>Activated</span>";    
                        ?>
                       
                        <?php  }elseif($b_status['is_avail'] == 2){ 
                            echo "<span style='color: red'>Rejected</span>";   
                        ?>
                  
                        <?php  }else{
                            //echo "<span style='color: blue'>Waiting to be accepted by you!.</span>";  
                        ?>
                            <form action="" method="post">
                                <?php wp_nonce_field("update_listing_action"); ?>
                                <input type="hidden" name="booking_id" value="<?php echo $booking->ID; ?>">
                                <input type="hidden" name="booking_type" value="<?php echo $unser['booking_type']; ?>">
                                <input type="hidden" name="listing_id" value="<?php echo $unser['listing_id']; ?>">
                                <input type="hidden" name="size_selected" value="<?php  echo $unser['size_selected']; ?>">
                                <input type="hidden" name="_size_total" value="<?php  echo $unser['_size_total']; ?>">
                                <input type="hidden" name="accept" value="accept">
                                <input type="submit" value="Accept">
                            </form> <br>
                             <form action="" method="post">
                                <?php wp_nonce_field("update_listing_action"); ?>
                                <input type="hidden" name="booking_id" value="<?php echo $booking->ID; ?>">
                                <input type="hidden" name="deny" value="deny">
                                <input type="submit"  value="Deny">
                            </form>
                        <?php } ?>
                    </td>
                </tr>
            
            <?php   
                               
                }}
            ?>

        </tbody>
	</table>
                <br><br><br><br><br>
</div>
<?php
    get_footer();