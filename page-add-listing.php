<?php /* Template Name: Example Template */ ?>
<?php 


get_header(); ?>
    <div class="custom-container">
        <?php 
          
             if(isset($_GET['intro']) ){
                require_once( plugin_dir_path( __FILE__ ) . 'form/intro.php');
            }
            if(isset($_GET['step_1'])){
            require_once( plugin_dir_path( __FILE__ ) . 'form/step_1.php');
            }elseif(isset($_GET['step_2'])){
                require_once( plugin_dir_path( __FILE__ ) . 'form/step_2.php');
            }elseif(isset($_GET['step_3'])){
                require_once( plugin_dir_path( __FILE__ ) . 'form/step_3.php');
            }elseif(isset($_GET['step_4'])){
                require_once( plugin_dir_path( __FILE__ ) . 'form/step_4.php');
            }elseif(isset($_GET['step_5'])){
                require_once( plugin_dir_path( __FILE__ ) . 'form/step_5.php');
            }elseif(isset($_GET['step_6'])){
                require_once( plugin_dir_path( __FILE__ ) . 'form/step_6.php');
            }elseif(isset($_GET['step_7'])){
                require_once( plugin_dir_path( __FILE__ ) . 'form/step_7.php');
            }elseif(isset($_GET['step_8'])){
                require_once( plugin_dir_path( __FILE__ ) . 'form/step_8.php');
            }elseif(isset($_GET['step_9'])){
                require_once( plugin_dir_path( __FILE__ ) . 'form/step_9.php');
            }elseif(isset($_GET['step_10'])){
                require_once( plugin_dir_path( __FILE__ ) . 'form/step_10.php');
            }elseif(isset($_GET['step_11'])){
                require_once( plugin_dir_path( __FILE__ ) . 'form/step_11.php');
            }else{
                require_once('form/intro.php');
            }
        
            
            if(!isset($_GET['intro']) && false !== strpos($_SERVER['REQUEST_URI'], '?') ){
                
                if(isset($_GET['step_11'])){
                    $post_id = $_GET['step_11'];
                    $btnhide = "";
                    $btnhide = "btnHide";
                    $btn = "<a href=".site_url()."/add-listing/?publish=".$post_id."' id='publish_btn' class='publish_btn'>Publish Now</a>";
                }else{
                     $btn = "";
                     $btnhide = "";
                }
                $btnURL = wp_get_referer();
                ?>
                        <div class="fixed_control_box">
                    <div class="container">
                        <div class="row">
                            <div class="has-drop-shadow">
                                <a href="<?php echo $btnURL; ?>" class="back_btn <?php $btnhide; ?>"> < </a>
                                <?php echo $btn; ?>
                                <a href="" class="next_btn <?php echo $btnhide; ?>" id="next"><img src="<?php echo PluginUrl(); ?>images/spin.gif" class="small_loader"> <span class="next_text">Next</span>  </a>
                            </div>
                        </div>
                    </div>
                </div>
               

                <?php
            
            }
   
        ?>
    </div>
<?php
    get_footer();