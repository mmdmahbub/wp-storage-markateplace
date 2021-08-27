<?php 
/*
	* Plugin Name: WP Storage Markateplace
	* Description: This wordpress plugin will help host to list there space to provide a seamless storage service to the guest.
	* Author: Mahbuhb Ansary
	* Version:1.0
*/
defined( 'ABSPATH' ) || exit;

// register style on initialization


function ext_listify_register_script(){
    wp_enqueue_style( 'ext_listify_styles', plugins_url('style.css', __FILE__)); 
    
	wp_enqueue_script( 'ext_listify_jquery_script', 'https://code.jquery.com/jquery-1.12.4.js', array(),true);	
	//Add jQuery ui css
	wp_enqueue_style( 'jquery-ui-css',  'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', array(), '1.12.1', false);
	wp_enqueue_script( 'jquery-ui-js',  'https://code.jquery.com/ui/1.12.1/jquery-ui.js', array(), '1.12.0', true );
	wp_enqueue_script( 'moments-js',  plugins_url(). '/simplified/assets/js/moments.js','',true);
	//wp_enqueue_script( 'ext_listify_axios', 'https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js' );
   //wp_enqueue_script( 'ext_listify_ui_script', 'http://code.jquery.com/ui/1.11.0/jquery-ui.js');
	
	wp_enqueue_script( 'ext_listify_custom_script', plugins_url('assets/script.js', __FILE__) );
	
	//wp_script_add_data( 'ext_listify_google_map_script', 'async' , true );
	//wp_script_add_data( 'ext_listify_custom_script', 'async' , true );
}
add_action('wp_enqueue_scripts','ext_listify_register_script');

//Set Plugin URL
function PluginUrl() {

        //Try to use WP API if possible, introduced in WP 2.6
        if (function_exists('plugins_url')) return trailingslashit(plugins_url(basename(dirname(__FILE__))));

        //Try to find manually... can't work if wp-content was renamed or is redirected
        $path = dirname(__FILE__);
        $path = str_replace("\\","/",$path);
        $path = trailingslashit(get_bloginfo('wpurl')) . trailingslashit(substr($path,strpos($path,"wp-content/")));
        return $path;
}

// Register and load the widget
require_once( 'inc/widgets.php');

//Include form shortcode
require_once('all_bookings.php');
include( plugin_dir_path( __FILE__ ) . 'form.php');
include( plugin_dir_path( __FILE__ ) . 'ajax.php');

//Register Bookings Post Type

function ext_listify_bookings_cpt_init() {
    $labels = array(
        'name'                  => _x( 'Bookings', 'Bookings', 'bookings' ),
        'singular_name'         => _x( 'Booking', 'Booking', 'booking' ),
        'menu_name'             => _x( 'Bookings', 'Admin Menu text', 'bookings' ),
        'name_admin_bar'        => _x( 'Bookings', 'bookings', 'bookings' ),
        'add_new'               => __( 'Add New', 'bookings' ),
        'add_new_item'          => __( 'Add New recipe', 'bookings' ),
        'new_item'              => __( 'New bookings', 'bookings' ),
        'edit_item'             => __( 'Edit bookings', 'bookings' ),
        'view_item'             => __( 'View bookings', 'bookings' ),
        'all_items'             => __( 'All bookings', 'bookings' ),
        'search_items'          => __( 'Search bookings', 'bookings' ),
        'parent_item_colon'     => __( 'Parent bookings:', 'bookings' ),
        'not_found'             => __( 'No recipes found.', 'bookings' ),
        'not_found_in_trash'    => __( 'No bookings found in Trash.', 'bookings' ),
    );     
    $args = array(
        'labels'             => $labels,
        'description'        => 'Bookings',
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'bookings' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail' ),
        'taxonomies'         => array( 'category', 'post_tag' ),
        'show_in_rest'       => true
    );
      
    register_post_type( 'Bookings', $args );
}
add_action( 'init', 'ext_listify_bookings_cpt_init' );

// Customize product price based on booking area input
add_action( 'woocommerce_before_calculate_totals', 'ext_listify_add_custom_price');
function ext_listify_add_custom_price( $cart_object ) {
 // $custom_price = 10; // This will be your custome price  
 if(is_checkout() or is_cart()){
	  foreach ( $cart_object->cart_contents as $key => $value ) {
	   $custom_price = 10;
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			//if($cart_item['data']->id == 282 || $cart_item['data']->id == 360){
                if($_COOKIE['custom_price'] != ""){
                    $cart_item['data']->set_price($_COOKIE['custom_price']);
                }
				
			//}
		}
	}
 }
}
//This function will fire after successfull payment 
add_action('woocommerce_payment_complete','this_is_custom_function');
 function this_is_custom_function($order_id){
    
	$listing_info = array(
		"payment_status" => 1
	);
    $data = unserialize(base64_decode(($_COOKIE['listing_info'])));

    //update_post_meta( $_COOKIE['booking_id'], $data['payment_status'], $listing_info);

    function change_post_status($post_id,$status){
        $current_post = get_post( $post_id, 'ARRAY_A' );
        $current_post['post_status'] = $status;
        wp_update_post($current_post);
    }
    //wp_delete_post($del_id);
    change_post_status($_COOKIE['booking_id'],'publish');
   
 }


add_action( 'woocommerce_before_checkout_form', 'checkout_custom_alert', 10 );

function checkout_custom_alert() {
    $data = unserialize(base64_decode(($_COOKIE['listing_info'])));
 	?>
	<h2 class="custom_alert">
		<img src="<?php echo PluginUrl(); ?>/images/clock.png" alt="">
		By making a payment, you're requesting to book (<?php echo $data['post_title'];?>).
host will have 24 hours to respond and confirm your booking

	</h2>

<?php
}


add_action('woocommerce_review_order_before_payment', 'fields_before_order_details');
//function
function fields_before_order_details(){
 	?>
	<ul class="after_order_details">
		<li>Payment will be credited to your account as store credits. Store credits will only be deducted
after product is sold & fulfilled and/or you are failing to hit your total monthly quota</li>
<li>If you fail to hit your total monthly quota, FulFLL will use your store credits to make
sure the host receives his minimum monthly rent</li>
<li>If there is a balance on your store credits after the contract expired, FulFLL will refund it.</li>
	</ul>

<?php
}
function simplified_order_item_name( $product_name, $item ) {

 $product_name .= sprintf(
 '<ul><li>%s: %s</li></ul>',
 __( 'Your name', 'simplified' ),
 esc_html( $item['Tsty_val'] )
 );
 
 return $product_name;
}

add_filter( 'woocommerce_order_item_name', 'simplified_order_item_name', 10, 2 );

add_filter( 'woocommerce_checkout_fields' , 'custom_remove_woo_checkout_fields' );
 
function custom_remove_woo_checkout_fields( $fields ) {

    // remove billing fields
    unset($fields['billing']['billing_first_name']);
	unset($fields['billing']['billing_last_name']);
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_phone']);
   unset($fields['billing']['billing_email']);
   
    // remove shipping fields 
    unset($fields['shipping']['shipping_first_name']);    
    unset($fields['shipping']['shipping_last_name']);  
    unset($fields['shipping']['shipping_company']);
    unset($fields['shipping']['shipping_address_1']);
    unset($fields['shipping']['shipping_address_2']);
    unset($fields['shipping']['shipping_city']);
    unset($fields['shipping']['shipping_postcode']);
    unset($fields['shipping']['shipping_country']);
    unset($fields['shipping']['shipping_state']);
    
    // remove order comment fields
    unset($fields['order']['order_comments']);
    
    return $fields;
}
add_filter('woocommerce_enable_order_notes_field', '__return_false');
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 60 );
add_filter( 'page_template', 'ext_create_page_template' );
function ext_create_page_template( $page_template )
{
    if ( is_page( 'add-listing' ) ) {
        $page_template = dirname( __FILE__ ) . '/page-add-listing.php';
    }

    return $page_template;
}

add_filter( 'page_template', 'ext_create_page_template_Bookings' );
function ext_create_page_template_Bookings( $page_template )
{
    if(is_page( 'all-bookings' ) ){
        $page_template = dirname( __FILE__ ) . '/page-all-bookings.php';
    }

    return $page_template;
}


function load_on_register(){
   //Create the page on plugin register

	$add_listing_page = get_page_by_title('Add Listing', 'OBJECT', 'page');
	$bookings = get_page_by_title('All Bookings', 'OBJECT', 'page');
	// Check if the page already exists
	if(empty($add_listing_page)) {
		$page_id = wp_insert_post(
			array(
			'comment_status' => 'close',
			'ping_status'    => 'close',
			'post_author'    => 1,
			'post_title'     => ucwords('Add Listing'),
			'post_content'		 => '[custom_form]',
			'post_name'      => strtolower(str_replace(' ', '-', trim('Add Listing'))),
			'post_status'    => 'publish',
			'post_type'      => 'page',
			)
		);
	}
	if(empty($bookings)) {
		$page_id = wp_insert_post(
			array(
			'comment_status' => 'close',
			'ping_status'    => 'close',
			'post_author'    => 1,
			'post_title'     => ucwords('All Bookings'),
			'post_content'		 => '[all_bookings]',
			'post_name'      => strtolower(str_replace(' ', '-', trim('All Bookings'))),
			'post_status'    => 'publish',
			'post_type'      => 'page',
			)
		);
	}

}

register_activation_hook(__FILE__, 'load_on_register');
