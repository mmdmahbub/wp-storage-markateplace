<?php 

//create form shortcode
function custom_form_func ( $attr ){

   

    //return $form;
}


add_shortcode('custom_form', 'custom_form_func');

add_shortcode('all_bookings', 'all_bookings_func');

add_action('wp_ajax_nopriv_add_listing_action', 'add_listing'); 
add_action('wp_ajax_add_listing_action', 'add_listing');


function add_listing(){
    //check login status
    if(!is_user_logged_in()){
        echo "not_logged_in";
    }else{

        $userid = get_current_user_id();
        $address = $_POST['location'];
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];
        global $current_user;
        wp_get_current_user() ;
        $username = $current_user->user_login;
       
        
        $num_of_post = count_user_posts( $userid , "job_listing" , true );
        $nop = $num_of_post + 1;
        if($username != ""){
            $title = ucfirst($username)."'s listing of ".$address;
        }
       
        // Create post object
        $my_post = array(
            'post_title'    => wp_strip_all_tags(  $title ),
            'post_content'  => '',
            'post_type'     => 'job_listing',
            'post_status'   => 'draft',
            'post_author'   => $userid,
        );
        
        // Insert the post into the database
        $pid = wp_insert_post( $my_post );
        $map_data = array(
            '_map_location' => $address,
            '_lat'          => $lat,
            '_lng'          =>  $lng
        );
        update_post_meta( $pid, 'map_info', $map_data );
        echo $pid;
    }
    wp_die();
}


add_action('wp_ajax_nopriv_update_listing_action', 'update_listing'); 
add_action('wp_ajax_update_listing_action', 'update_listing');

function update_listing(){
    //Step 1
    $ret = array();
    $pid = $_POST['pid'];
    $step_1 = $_POST['step_1'];
    $step_2 = $_POST['step_2'];
    $step_3 = $_POST['step_3'];
    $step_4 = $_POST['step_4'];
    $step_5 = $_POST['step_5'];
    $step_6 = $_POST['step_6'];
    $step_7 = $_POST['step_7'];
    $step_8 = $_POST['step_8'];
    $step_9 = $_POST['step_9'];
    $step_10 = $_POST['step_10'];

    if($step_1){
        
        $location = $_POST['_map_location'];
        if(empty($location)){
            echo "_location_empty";
        }

        $map_data = array(
            '_map_location' => $location,
            '_lat' => $_POST['lat'],
            '_lng' => $_POST['lng'],
            'step_1' => 1,
            
        );
        
        update_post_meta( $pid, 'map_info', $map_data );
        
        $ret['update_status'] = "_step_1_updated";
        $ret['post_id'] = $pid;
        
    }

    if($step_2){
        $space_type     = $_POST['space_type'];
        $floor_level    = $_POST['floor_level'];
        $storage        = $_POST['storage'];
        $parking        = $_POST['parking'];
        $workspace      = $_POST['workspace'];
        $multiple_hosting   = $_POST['multiple_hosting'];
        $offer_fullfilment  = $_POST['offer_fullfilment'];
        $map_data = array(
            '_multiple_hosting'   => $multiple_hosting ,
            '_offer_fullfilment'  => $offer_fullfilment,
            '_space_type'  => $space_type,
            '_floor_level' => $floor_level,
            '_storage'     => $storage,
            '_parking'     => $parking,
            '_workspace'   => $workspace,
            'step_2'   => 1,
        );
        update_post_meta( $pid, 'storage_info', $map_data );
        $ret['update_status'] = "_step_2_updated";
        $ret['post_id'] = $pid;
    }

    if($step_3){
        $feature_data = array(
            '_bolt_lock'                   => $_POST['bolt_lock'],
            '_CCTV'                        => $_POST['CCTV'],	
            '_Door_defender_lock'          => $_POST['Door_defender_lock'],	
            '_lockable_door'               => $_POST['lockable_door'],
            '_on_site_staff'               => $_POST['on_site_staff'],
            '_padlock'                     => $_POST['padlock'],
            '_roller_shutter_doors'        => $_POST['roller_shutter_doors'],
            '_security_alarm'              => $_POST['security_alarm'],
            '_security_bar'                => $_POST['security_bar'],
            '_security_gate'               => $_POST['security_gate'],
            '_security_lighting'           => $_POST['security_lighting'],
            '_smoke_detector'              => $_POST['smoke_detector'],
            '_climate_control'             => $_POST['climate_control'],	
            '_dehumidifier'                => $_POST['dehumidifier'],
            '_electricity_car_charging'    => $_POST['electricity_car_charging'],
            '_electricity_normal_socket'   => $_POST['electricity_normal_socket'],
            '_Electricity_three_phase'     => $_POST['Electricity_three_phase'],
            '_fire_alarm'                  => $_POST['fire_alarm'],
            '_ground_door_strip'           => $_POST['ground_door_strip'],
            '_heating'                     => $_POST['heating'],
            '_lighting'                    => $_POST['lighting'],
            '_private_entrance'            => $_POST['private_entrance'],
            '_shelving'                    => $_POST['shelving'],
            '_water_supply'                => $_POST['water_supply'],
            'step_3'                => 1,
        );
        update_post_meta( $pid, 'feature_info', $feature_data );

        $ret['update_status'] = "_step_3_updated";
        $ret['post_id'] = $pid;
    }

    if($step_4){
        $measurment_data = array(
            '_width'                => $_POST['width'],
            '_depth'                => $_POST['depth'],
            '_height'               => $_POST['height'],
            '_measurment_type'      => $_POST['measurment_type'],
            '_space_amount'         => $_POST['space_amount'],
            'step_4' => 1,
        );

        update_post_meta( $pid, 'measurment_info', $measurment_data );
        $ret['update_status'] = "_step_4_updated";
        $ret['post_id'] = $pid;
    }

    if($step_5){

        $uploads = wp_upload_dir();
        $upload_file_url = array();
        
       $data = array();
       
        $parent_post_id = $pid;  // The parent ID of our attachments
        $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg"); // Supported file types
        $max_file_size = 1024 * 500; // in kb
        $max_image_upload = 10; // Define how many images can be uploaded to the current post
        $wp_upload_dir = wp_upload_dir();
        $path = $wp_upload_dir['path'] . '/';
        $count = 0;

        
    $attachments = get_posts( array(
        'post_type'         => 'attachment',
        'posts_per_page'    => -1,
        'post_parent'       => $parent_post_id,
        'exclude'           => get_post_thumbnail_id() // Exclude post thumbnail to the attachment count
    ) );
 
        
 
    // Image upload handler
    if( $_SERVER['REQUEST_METHOD'] == "POST" ){
       
        // Check if user is trying to upload more than the allowed number of images for the current post
        if( ( count( $attachments ) + count( $_FILES['files_to_upload']['name'] ) ) > $max_image_upload ) {
            $upload_message[] = "Sorry you can only upload " . $max_image_upload . " images for each Ad";
        } else {
           
            $md5 = md5( 20 );
            foreach ( $_FILES['files_to_upload']['name'] as $f => $name ) {
                $extension = pathinfo( $name, PATHINFO_EXTENSION );
                // Generate a randon code for each file name
                $new_filename = $md5 . $name . '.' . $extension;
               //$ret['test'][] = $new_filename;
                if ( $_FILES['files_to_upload']['error'][$f] == 4 ) {
                    continue;
                }
                
               
                if ( $_FILES['files_to_upload']['error'][$f] == 0 ) {
                    // Check if image size is larger than the allowed file size
                    if ( $_FILES['files_to_upload']['size'][$f] > $max_file_size ) {
                        $upload_message[] = "$name is too large!.";
                        continue;
                   
                    // Check if the file being uploaded is in the allowed file types
                    } elseif( ! in_array( strtolower( $extension ), $valid_formats ) ){
                        $upload_message[] = "$name is not a valid format";
                        continue;
                   
                    } else{
                        
                        // If no errors, upload the file...
                        if( move_uploaded_file( $_FILES["files_to_upload"]["tmp_name"][$f], $path.$new_filename ) ) {
                           
                            $count++;

                            $filename = $path.$new_filename;
                            $filetype = wp_check_filetype( basename( $filename ), null );
                            $wp_upload_dir = wp_upload_dir();
                            $attachment = array(
                                'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ),
                                'post_mime_type' => $filetype['type'],
                                'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
                                'post_content'   => '',
                                'post_status'    => 'inherit'
                            );
                            
                            // Insert attachment to the database
                            $attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );

                            //print_r($attach_id);


                            require_once( ABSPATH . 'wp-admin/includes/image.php' );
                           
                            // Generate meta data
                           $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
                            wp_update_attachment_metadata( $attach_id, $attach_data );
                           
                            
                            $attach_url[] = wp_get_attachment_url($attach_id);
                            $attach_url = "'".$attach_url."'";
                        }
                    }
                }
                set_post_thumbnail( $pid, $attach_id );
                update_post_meta( $pid, '_gallery_images', $attach_url);

            }
            
           
            
        }
    }
    
        // Loop through each error then output it to the screen
        if ( isset( $upload_message ) ) :
            foreach ( $upload_message as $msg ){       
                $ret['upload_status_f'][] = 0;
            }
        endif;
    
        // If no error, show success message
        if( $count != 0 ){
            $ret['upload_status_s'][] = 1;  
        }

        $ret['update_status'] = "_step_5_updated";
        $ret['post_id'] = $pid;
    }
    if($step_6){
        $listing_info = array(
            '_listing_desc' => $_POST['list_desc'],
            '_security'     => $_POST['security'],
            '_location'     => $_POST['location'],
            '_hosting'      => $_POST['hosting'],
            'step_6'      => 1,
        );

        update_post_meta( $pid, 'listingInfo', $listing_info );
        $ret['update_status'] = "_step_6_updated";
        $ret['post_id'] = $pid;
    }

    if($step_7){ 
        $access_info = array(
            '_access_type'       => $_POST['access_type'],
            '_saturday'          => $_POST['saturday'],
            '_start_saturday'    => $_POST['start_saturday'],
            '_end_saturday'      => $_POST['end_saturday'],

            '_sunday'            => $_POST['sunday'],
            '_start_sunday'      => $_POST['start_sunday'],
            '_end_sunday'        => $_POST['end_sunday'],

            '_monday'            => $_POST['monday'],
            '_start_monday'      => $_POST['start_monday'],
            '_end_monday'        => $_POST['end_monday'],

            '_tuesday'           => $_POST['tuesday'],
            '_start_tuesday'     => $_POST['start_monday'],
            '_end_tuesday'       => $_POST['end_tuesday'],

            '_wednesday'         => $_POST['wednesday'],
            '_start_wednesday'   => $_POST['start_wednesday'],
            '_end_wednesday'     => $_POST['end_wednesday'],

            '_thursday'          => $_POST['thursday'],
            '_start_thursday'   => $_POST['start_thursday'],
            '_end_thursday'     => $_POST['end_thursday'],

            '_friday'           => $_POST['friday'],
            '_start_friday'   => $_POST['start_friday'],
            '_end_friday'     => $_POST['end_friday'],

            '_are_u_using'    => $_POST['are_u_using'],
            '_access_text'    => $_POST['access_text'],
            '_access_method'    => $_POST['access_method'],
            'step_7'    => 7,
        );

        update_post_meta( $pid, 'access_info', $access_info );
        $ret['update_status'] = "_step_7_updated";
        $ret['post_id'] = $pid;
    }
   if($step_8){ 
       
        $minimum_rental = array(
            '_minimum_month_rent' => $_POST['minimum_month_rent'],
            '_booked_within' => $_POST['booked_within'],
            'step_8' => 1,
        );

        update_post_meta( $pid, 'minimum_rental', $minimum_rental );
        $ret['update_status'] = "_step_8_updated";
        $ret['post_id'] = $pid;
   }
   if($step_9){ 
        $booking_type = array(
            '_pricing' => $_POST['pricing'],
            'step_9'   => 1,
        );
        update_post_meta( $pid, 'pricing', $booking_type );
        $ret['update_status'] = "_step_9_updated";
        $ret['post_id'] = $pid;
   }
   if($step_10){ 
        $booking_type = array(
            '_instant_booking' => $_POST['instant_booking'],
            'step_10' => 1,
        );
        update_post_meta( $pid, 'booking_type', $booking_type );
        $ret['update_status'] = "_step_10_updated";
        $ret['post_id'] = $pid;
   }
   if($step_11){ 
        $terms_aggreement = array(
            '_terms_aggreement' => $_POST['terms_aggreement'],
            'step_11' => 1,
        );
        update_post_meta( $pid, 'terms_aggreement', $terms_aggreement );
        $ret['update_status'] = "_step_11_updated";
        $ret['post_id'] = $pid;
   }
   $ret['exitBtn'] = $_POST['exitBtn'];
    echo json_encode($ret);
    exit;
   wp_die();
}


add_action( 'wp_ajax_delete_attachment', 'delete_attachment' );
function delete_attachment( $post ) {
    //echo $_POST['att_ID'];
    $ret = array();
    //$msg = 'Attachment ID [' . $_POST['att_ID'] . '] has been deleted!';
    if( wp_delete_attachment( $_POST['att_ID'], true )) {
       $ret['msg'] = 1;
    }else{
        $ret['msg'] = 0;
    }
    echo json_encode($ret);
    exit;
   wp_die();
}

add_action('wp_ajax_nopriv_publish_post_action', 'publish_post'); 
add_action('wp_ajax_publish_post_action', 'publish_post');

function publish_post(){
    $pid = $_POST['pid'];
    $step = $_POST['step_11'];
    $ret = array();
    // Change from draft to published
    $my_post = array(
        'ID'           => $pid,
        'post_type' => 'job_listing',
        'post_status'   => 'publish',
    );
    // Update the post into the database
    wp_update_post( $my_post );
    $custom_status = array(
        'ready_to_publish' => 1
    );
    update_post_meta( $pid, 'custom_status', $custom_status );
    
    update_post_meta( $pid, 'full_space', 1 );
    update_post_meta( $pid, 'partial_space', 1 );
    update_post_meta( $pid, 'fulfill_by_host', 1 );

    $ret['update_status'] = "_step_11_updated";
    $ret['post_id'] = $pid;
    echo json_encode($ret);
    exit;
   wp_die();
}


add_action('wp_ajax_nopriv_book_listing', 'book_listing'); 
add_action('wp_ajax_book_listing', 'book_listing');

function book_listing(){
    //check login status
    if(!is_user_logged_in()){
       $ret['login_status'] = 0;
       echo json_encode($ret);
        exit;
       return false;
    }
        setcookie("custom_price",'', 0, "/");
        setcookie("listing_info",'', 0, "/");
        setcookie("booking_id",'', 0, "/");
        
        $listing_id      = $_POST['listing_id'];
        $listing_author  = $_POST['listing_author'];
        $booking_type    = $_POST['booking_type'];
        $userid          = wp_get_current_user();
        $price           = $_POST['_pricing'];
        $_size_total     = $_POST['_size_total'];
        $_size           = $_POST['_size'];
        $post_title      = $_POST['post_title'];
        $starting_date   = $_POST['booking_date'];
        $min_rental      = $_POST['min_rental'];

        // Calculating the price with min rental settings
        //$price = $price * $min_rental;

        if($min_rental == 1){
            $days = 30;
        }elseif($min_rental ==  2){
            $days = 60;
        }elseif($min_rental ==  3){
            $days = 90;
        }elseif($min_rental ==  6){
            $days = 180;
        }elseif($min_rental ==  12){
            $days = 360;
        }else{
            $days = 30;
        }

  
        //Add months to the subscription
        $date = new DateTime($booking_date); // Y-m-d
        $date->add(new DateInterval('P'.$days.'D'));
        $ending_date = $date->format('Y-m-d');
     
        //Check if this user already have any entry in this lisitng
        $args = array(
            'post_type'   => 'bookings',
            'post_status' => 'any',
            'author' => $current_user->ID,
        );


        $checkAvail = false;
        $listing_meta          = get_post_meta( $listing_id );
        $full_space            = $listing_meta['full_space'][0];
        $partial_space         = $listing_meta['partial_space'][0];
        $fulfill_by_host       = $listing_meta['fulfill_by_host'][0];

         
       //print_r($full_space);
       //return false; 
        //$checkAvail = false;
        //echo $booking_type;
       
        if($booking_type == 1){
            if($full_space != 1 ){
                $ret['is_avail'] = 0;
                echo json_encode($ret);
                exit;
                return false;
                wp_die();
            }
        }
        if($booking_type == 2){
            if($partial_space != 1 ){
                $ret['is_avail'] = 0;
                echo json_encode($ret);
                exit;
                return false;
                wp_die();
            }
        }
        if($booking_type == 3){
            if($fulfill_by_host != 1 ){
                $ret['is_avail'] = 0;
                echo json_encode($ret);
                exit;
                return false;
                wp_die();
            }
        }
      


        $checkBokings  = get_posts( $args ); 
        global $current_user;
       
        // print_r($checkBokings);
        foreach($checkBokings as $booking){
            $listing_id      = $_POST['listing_id'];
            $meta            = get_post_meta( $booking->ID );
            $booking_info    = unserialize($meta['booking_info'][0]);
           
           // print_r($listing_meta);
            $user_id =  $current_user->ID;
            if($booking->post_author ==  $user_id && $booking_info['listing_id'] == $listing_id && $booking_type == $booking_info['booking_type']){
            
                $ret['multiple_found'] = 1;
                echo json_encode($ret);
                exit;
                wp_die();
                return false;
            }
        }
            /*
            $calc = $booking_info['size_selected'] - $_size;
            if($calc < 0){
                $ret['space_not_avail'] = 1;
                echo json_encode($ret);
                exit;
                //wp_die();
                return false;
            }*/
        
            $lng = $_POST['lng'];
            global $current_user;
            wp_get_current_user();
            $username = $current_user->user_login;
        
            // Create post object
            $my_post = array(
                'post_title'    => wp_strip_all_tags(  $post_title ),
                'post_content'  => '',
                'post_type'     => 'bookings',
                'post_status'   => 'draft',
                'post_author'   => $current_user->ID,
            );
            
            // Insert the post into the database
            $booking_id = wp_insert_post( $my_post );
            $b_info = array(
                'starting_date' => $starting_date,
                'ending_date' => $ending_date,
                'listing_id' => $listing_id,
                'listing_author' => $listing_author,
                'price_for_booking' => $price,
                'size_selected' => $_size,
                '_size_total' => $_size_total,
                'payment_status' => 0,
                'booking_type'   =>  $_POST['booking_type'],
            );

           update_post_meta( $booking_id, 'booking_info', $b_info );
            $status = array(
                'is_avail' => 0,
            );
           update_post_meta( $booking_id, 'booking_status', $status );
            //If Booking type is fullfillment by host
            

            if($_POST['booking_type'] == "Fulfill By Host"){
                    $fulfill_data = array(
                    'shop_address' => $_POST['shop_address'],
                    'prodcut_type' => $_POST['prodcut_type'],
                    'prodcut_category' => $_POST['prodcut_category'],
                    'quantity' => $_POST['quantity'],
                    'price_per_prodcut' => $_POST['price_per_prodcut'],
                    'shop_address' => $_POST['shop_address'],
                    'require_packeging' => $_POST['require_packeging'],
                );
                update_post_meta( $booking_id, 'fulfill_info', $fulfill_data );
            }

            

            $product_id = 2596;
            $quantity = 1;
            global $woocommerce;
            global $product;

            // If cart is not empty it will remove other product from cart
            if( ! WC()->cart->is_empty() )
            WC()->cart->empty_cart();
            //Add to cart
            $woocommerce->cart->add_to_cart($product_id);

      
            $listing_info = array(
                'listing_id'    => $listing_id,
                'starting_date' => $starting_date,
                'ending_date'   => $ending_date,
                'post_title'    => $post_title,
                'price'         => $price."/Month",
                'size'          => $_size,
                'meter_name'    => 'sq meter'
            );

            setcookie("custom_price",$price, 0, "/");
            setcookie("listing_info",base64_encode(serialize($listing_info)), 0, "/");
            setcookie("booking_id",$booking_id, 0, "/");

            $ret['update_status'] = 1;
            $ret['post_id'] = $pid;

        
    echo json_encode($ret);
    exit;
    wp_die();
}

