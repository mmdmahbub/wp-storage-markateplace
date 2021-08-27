<?php
add_action('wp_footer', 'ajax_script');
function ajax_script(){
    ?>
    <script>
        function addListing(){
            jQuery(document).ready(function ($) {
                var page = 2;
                //var place_of_delivery = $("#place_of_delivery").text();

                var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
                submitBtn = document.getElementById('submitBtn');
                
                jQuery("#add_listing").submit(function (e) {
                    e.preventDefault();
                    var inputField = $('#pac-input').val();
                    var lat = $('#lat').val();
                    var lng = $('#lng').val();
                  
                    var data = {
                        'action'   : 'add_listing_action',
                        'location' : inputField,
                        'lat'      : lat,
                        'lng'      : lng
                    };

                    $.ajax({ // you can also use $.post here
                        url : "<?php echo admin_url('admin-ajax.php'); ?>", // AJAX handler
                        data : data,
                        type : 'POST',
                        beforeSend : function ( xhr ) {
                            $('#submitBtn').val(''); // change the button text, you can also add a 
                            $('.loader').show();
                        },
                        success : function( data ){
                            $('.loader').hide();
                            if(data == 'not_logged_in'){
                                $('#submitBtn').val('Login Required');
                                window.location.href = "<?php echo site_url();?>/myaccount";
                            }else{
                                $('#submitBtn').val('Listing Added');
                                window.location.href = "<?php echo site_url();?>/add-listing/?step_1="+data;
                            }
                        },
                        error : function (){
                            $('.loader').hide();
                             $('#submitBtn').val('Add Listing');
                            alert('Something went wrong on our end!');
                        }
                    });


                });


                //Update Listing
                //$("#next").click(function(e){ 
                
                $('#form_update').submit(function(e) { // handle the submit event
                     e.preventDefault();

                    //Step 2 validation start 
                    var storage = $("#storage").val();
                    var parking = $("#parking").val();
                    var workspace = $("#workspace").val();
                    var s_type = $("#space_type").val();
                   
                     if(s_type == "Garage"){
                        if(storage == 0 && parking == 0 && workspace == 0){
                            $(".custom_alert").css({'display':'block'});
                            return false;
                        }else{
                            $(".custom_alert").css({'display':'none'});
                        }
                    }
                     var floor_level = $("#floor_level").val();
                     
                     if(floor_level == 0){
                        alert("Please Select Floor Level");
                        return false;
                     }
                     var access_method = $("#access_method").val();
                     if(access_method == 0){
                        alert("Please Choose an Access Method.");
                        return false;
                     }
                     //Step 2 end 

                     //Step 4 start
                        var width = $("#width").val();
                        var depth = $("#depth").val();
                        var height = $("#height").val();
                        var space_amount = $("#space_amount").val();
                        if(width == "" || depth == "" || height == "" || space_amount == ""){
                            alert("Please select all the required option!");
                            return false;
                        }
                     //Step 4 end

                    
                    var fu_action = $("#step_5").val();
                    if(fu_action != ""){
                        var fd = new FormData(this);
                        var files_data = $('#upload_field');
                        var files_input = $("#upload_field").val();
                        //alert(files_input);
                       // return false;
                       if(! $('.attahced_image').find('li').length ){
                            if(files_input == ""){
                                alert("Please upload at-least one file.");
                                return false;
                            }
                    
                       }
                         $.each($(files_data), function(i, obj) {
                            $.each(obj.files,function(j,file){
                                fd.append('files[' + j + ']', file);
                            })
                        });
                        fd.append( "action", 'update_listing_action');      
                    }else{
                        var fd = $(this).serializeArray();
                    }


                    var listing_desc = $("#list_desc").val();
                    
                    if( $("#list_desc").val() < 35){
                        alert("Please describe your space in at least 35 characters");
                        return false;
                    }

                    if($("#step_9").val() != ""){
                        if($("#pricing").val()  == ""){
                            alert("Please set your price!");
                            return false;
                        }
                    }
                    
                   // data = JSON.stringify(formData);
                     $.ajax({ // you can also use $.post here
                        url : "<?php echo admin_url('admin-ajax.php'); ?>", // AJAX handler
                        data : fd,
                        type : 'POST',
                        datatype: 'JSON',
                        processData: false,
                        contentType: false,
                        beforeSend : function ( xhr ) {
                            $('.next_text').text(''); // change the button text, you can also add a 
                            $('.small_loader').show();
                        },
                        success : function( data ){
                            $('.small_loader').hide();
                            $('.next_text').text('Updated...');
                            //alert(data.update_status);
                             var obj = JSON.parse(data);
                             if(obj.exitBtn == 1){
                                window.location.href = "<?php echo site_url();?>";
                             }
                          // alert(data);
                            if(obj.update_status == "_step_1_updated"){
                                window.location.href = "<?php echo site_url();?>/add-listing/?step_2="+obj.post_id;
                            }
                            if(obj.update_status == "_step_2_updated"){
                                window.location.href = "<?php echo site_url();?>/add-listing/?step_3="+obj.post_id;
                            }
                            if(obj.update_status == "_step_3_updated"){
                                window.location.href = "<?php echo site_url();?>/add-listing/?step_4="+obj.post_id;
                            }
                            if(obj.update_status == "_step_4_updated"){
                                window.location.href = "<?php echo site_url();?>/add-listing/?step_5="+obj.post_id;
                            }
                            if(obj.update_status == "_step_5_updated"){
                                //$("#upload_field").val("");
                               $("#form_update").find('[type=file]').val('').trigger('change');
                                window.location.href = "<?php echo site_url();?>/add-listing/?step_6="+obj.post_id;
                            }
                            if(obj.update_status == "_step_6_updated"){
                                window.location.href = "<?php echo site_url();?>/add-listing/?step_7="+obj.post_id;
                            }
                            if(obj.update_status == "_step_7_updated"){
                                window.location.href = "<?php echo site_url();?>/add-listing/?step_8="+obj.post_id;
                            }
                            if(obj.update_status == "_step_8_updated"){
                                window.location.href = "<?php echo site_url();?>/add-listing/?step_9="+obj.post_id;
                            }
                            if(obj.update_status == "_step_9_updated"){
                                window.location.href = "<?php echo site_url();?>/add-listing/?step_10="+obj.post_id;
                            }
                            if(obj.update_status == "_step_10_updated"){
                                window.location.href = "<?php echo site_url();?>/add-listing/?step_11="+obj.post_id;
                            }
                            
                        },
                        error : function (){
                            $('.small_loader').hide();
                            $('.next_text').text('Next');
                            alert('Something went wrong on our end!');
                        }
                    });
                });
                $('#next').click(function(e) {
                    e.preventDefault();
                    $('#form_update').submit(); // trigger the submit event
                });
                $('.save_btn').click(function(e) {
                    e.preventDefault();
                    $("#form_update").submit();
                });
                
                
                $(function(){
                    $(document).on('click','.delete_attach',function(e){
                        e.preventDefault();
                        var conf = confirm("Are you sure?");

                        if(conf == true){
                        var del_id= $(this).attr('id');
                        var attID = jQuery(this).attr('name');

                        $.ajax({
                            type:'POST',
                            url: "<?php echo admin_url('admin-ajax.php'); ?>",
                            dataType: 'JSON',
                            data: {
                            action: 'delete_attachment',
                                att_ID: jQuery(this).attr('name'),
                                _ajax_nonce: jQuery('#nonce').val(),
                                post_type: 'attachment'
                            },
                            beforeSend : function ( xhr ) {
                                $('.next_text').text(''); // change the button text, you can also add a 
                                $('.small_loader').show();
                            },
                            cache: false,
                            success: function(data){
                               //  var obj = JSON.parse(data);
                                $('.small_loader').hide();
                                $('.next_text').text('Deleted');
                                if(data.msg = 1){
                                   location.reload(); 
                                }else{
                                    alert("Couldnt able to perform this action");
                                }

                            }

                            });
                        }
                    });
                });

                $('#publishing_form').submit(function(e) { // handle the submit event
                     e.preventDefault();
                     var fd = $(this).serializeArray();
                     var booking_terms = $("#booking_terms").val();
                     
                     if(booking_terms == 0){
                        alert("Please Accept The Terms & Condiotion To Proceed!");
                        return false;
                     }
                   // data = JSON.stringify(formData);
                     $.ajax({ 
                        url : "<?php echo admin_url('admin-ajax.php'); ?>", // AJAX handler
                        data : fd,
                        type : 'POST',
                        datatype: 'JSON',
                        beforeSend : function ( xhr ) {
                            $('#publish_btn').text('Publishing'); 
                            $('.small_loader').show();
                        },
                        success : function( data ){
                            var obj = JSON.parse(data);
                            $('.small_loader').hide();
                             $('#publish_btn').text('Published...'); 
                            //alert(obj.update_status);
                            if(obj.update_status == "_step_11_updated"){
                                window.location.href = "<?php echo site_url();?>/myaccount/listings/";
                            }
                        },
                        error : function (){
                            $('.small_loader').hide();
                            $('#publish_btn').text('Publish Now');
                            alert("Something went wrong on our end!");
                        }
                    });
                });

                 $('#publish_btn').click(function(e) {
                    e.preventDefault();
                    $('#publishing_form').submit(); // trigger the submit event
                });



                $('#book_listing').submit(function(e) { // handle the submit event
                     e.preventDefault();

                    if($("#booking_date").val() == ""){
                        $('.datepicker').datepicker('show');
                        return false;
                    }
                   
                    if($(".fulfill_by_host").hasClass('active')){
                        if($("#shop_address").val() == "" || $("#prodcut_type").val() == "" ||
						$("#prodcut_type").val() == "" || $("#prodcut_category").val() == "" || 
						$("#quantity").val() == "" || $("#price_per_prodcut").val() == "" ){
							alert("Please fill all the required fields.");
                            return false;
						}
                       
                    }


                     var fd = $(this).serializeArray();
                     
                   // data = JSON.stringify(formData);
                     $.ajax({ 
                        url : "<?php echo admin_url('admin-ajax.php'); ?>", // AJAX handler
                        data : fd,
                        type : 'POST',
                        datatype: 'JSON',
                        beforeSend : function ( xhr ) {
                            $('.custom_btn').val(''); 
                            $('.small_loader_front').show();
                        },
                        success : function( data ){
                            var obj = JSON.parse(data);
                            $('.small_loader_front').hide();
                            $('.custom_btn').val('Book Now'); 
                            if(obj.multiple_found == 1){
                                alert("You have already a booking in this listing.");
                                window.location.href = "<?php echo site_url();?>/myaccount/all-bookings/";
                                return false;
                            }
                            if(obj.login_status == 0) {
                                alert("Login Required");
                                window.location.href = "<?php echo site_url();?>/myaccount";
                                return false;
                            }
                            //alert(obj.update_status);is_avail
                            if(obj.is_avail == 0) {
                                alert("Space is not availbale at this moment");
                                return false;
                            }
                            if(obj.update_status == 1){
                               window.location.href = "<?php echo site_url();?>/checkout";
                            }
                        },
                        error : function (){
                            $('.small_loader').hide();
                            $('#publish_btn').text('Publish Now');
                            alert("Something went wrong on our end!");
                        }
                    });
                });
               
            });

        }
        addListing();
    </script>
    <?php
}
