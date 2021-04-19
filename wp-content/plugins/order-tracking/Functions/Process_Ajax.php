<?php
/* Processes the ajax requests being put out in the admin area and the front-end
*  of the OTP plugin */

// AJAX update of the tracking-form shortcode
function EWD_OTP_Update_Orders() {
	
    $Fields = array();
	$Field_Names_Array = explode( ",", sanitize_text_field( $_POST['Field_Labels'] ) );
	
    foreach ($Field_Names_Array as $Field_Name) {
		$Field_Name_Key = trim(substr($Field_Name, 0, strpos($Field_Name, "=")));
		$Field_Name_Value = trim(substr($Field_Name, strpos($Field_Name, "=")+5));
		$Fields[$Field_Name_Key] = $Field_Name_Value;
	}
		
	echo EWD_OTP_Return_Results( sanitize_text_field( $_POST['Tracking_Number'] ), $Fields, sanitize_email( $_POST['Order_Email'] ) );
}
add_action('wp_ajax_ewd_otp_update_orders', 'EWD_OTP_Update_Orders');
add_action( 'wp_ajax_nopriv_ewd_otp_update_orders', 'EWD_OTP_Update_Orders');

function EWD_OTP_Mobile_Order_Status() {
	global $wpdb;
	global $EWD_OTP_orders_table_name;
		
	echo $wpdb->get_var( $wpdb->prepare(" SELECT Order_Status FROM $EWD_OTP_orders_table_name WHERE Order_ID=%d", sanitize_text_field( $_POST['Tracking_Number'] ) ) );
}
add_action('wp_ajax_ewd_otp_order_status_mobile', 'EWD_OTP_Mobile_Order_Status');
add_action( 'wp_ajax_nopriv_ewd_otp_order_status_mobile', 'EWD_OTP_Mobile_Order_Status');

// Update the order of custom fields
function EWD_OTP_Custom_Fields_Save_Order(){
	global $wpdb;
	global $EWD_OTP_fields_table_name;
	
	foreach ( $_POST['custom-field-item'] as $Key => $ID ) {
		$Result = $wpdb->query( $wpdb->prepare( "UPDATE $EWD_OTP_fields_table_name SET Field_Order=%d WHERE Field_ID=%d", intval( $Key ), intval( $ID ) ) );
	}
}
add_action('wp_ajax_ewd_otp_custom_fields_update_order','EWD_OTP_Custom_Fields_Save_Order');

function EWD_OTP_Hide_UWPM_Banner() {   
    $Time = time() + $_POST['hide_length'] * 24*3600;
    update_option("EWD_OTP_UWPM_Ask_Time", $Time);

    die();
}
add_action('wp_ajax_ewd_otp_hide_uwpm_banner','EWD_OTP_Hide_UWPM_Banner');

function EWD_OTP_AJAX_Save_Customer_Note() {
    echo EWD_OTP_Save_Customer_Note();

    die();
}
add_action('wp_ajax_ewd_otp_update_customer_note','EWD_OTP_AJAX_Save_Customer_Note');
add_action( 'wp_ajax_nopriv_ewd_otp_update_customer_note', 'EWD_OTP_AJAX_Save_Customer_Note');

function EWD_OTP_Edit_Statuses() {   
    $Statuses = json_decode(stripslashes($_POST['status_data']));

    $Statuses_Array = array();
    foreach ($Statuses as $Status) {
    	$Statuses_Array[] = array(
    		'Status' => $Status->status,
    		'Percentage' => $Status->percentage,
    		'Message' => $Status->email,
    		'Internal' => $Status->internal
    	);
    }

    update_option("EWD_OTP_Statuses_Array", $Statuses_Array);

    die();
}
add_action('wp_ajax_ewd_otp_update_statuses','EWD_OTP_Edit_Statuses');

function EWD_OTP_Edit_Locations() {   
    $Locations = json_decode(stripslashes($_POST['location_data']));

    $Locations_Array = array();
    foreach ($Locations as $Location) {
    	$Locations_Array[] = array(
    		'Name' => $Location->location,
    		'Latitude' => $Location->location_latitude,
    		'Longitude' => $Location->location_longitude
    	);
    }
    
    update_option("EWD_OTP_Locations_Array", $Locations_Array);

    die();
}
add_action('wp_ajax_ewd_otp_update_locations','EWD_OTP_Edit_Locations');

//REVIEW ASK POP-UP
function EWD_OTP_Hide_Review_Ask(){   
    $Ask_Review_Date = sanitize_text_field($_POST['Ask_Review_Date']);

    if (get_option('EWD_OTP_Ask_Review_Date') < time()+3600*24*$Ask_Review_Date) {
        update_option('EWD_OTP_Ask_Review_Date', time()+3600*24*$Ask_Review_Date);
    }

    die();
}
add_action('wp_ajax_ewd_otp_hide_review_ask','EWD_OTP_Hide_Review_Ask');

function EWD_OTP_Send_Feedback() {   
    $headers = 'Content-type: text/html;charset=utf-8' . "\r\n";  
    $Feedback = sanitize_text_field( $_POST['Feedback'] );
    $Feedback .= '<br /><br />Email Address: ';
    $Feedback .= sanitize_email( $_POST['EmailAddress'] );

    wp_mail( 'contact@etoilewebdesign.com', 'OTP Feedback - Dashboard Form', $Feedback, $headers );

    die();
}
add_action('wp_ajax_ewd_otp_send_feedback','EWD_OTP_Send_Feedback');

function EWD_OTP_Dismiss_Pointers() {   
    $uid = get_current_user_id();
    $pointers = explode( ',', (string) get_user_meta( $uid, 'dismissed_wp_pointers', TRUE ) );

    $pointers[] = 'ewd_otp_admin_pointers_tutorial-one';
    $pointers[] = 'ewd_otp_admin_pointers_tutorial-two';
    $pointers[] = 'ewd_otp_admin_pointers_tutorial-three';
    $pointers[] = 'ewd_otp_admin_pointers_tutorial-four';
    $pointers[] = 'ewd_otp_admin_pointers_tutorial-five';
    $pointers[] = 'ewd_otp_admin_pointers_tutorial-six';
    $pointers[] = 'ewd_otp_admin_pointers_tutorial-seven';
    
    $unique_pointers = array_unique($pointers);
    update_usermeta($uid, 'dismissed_wp_pointers', implode(",", $unique_pointers));
    
    die();
}
add_action('wp_ajax_otp-dismiss-wp-pointers','EWD_OTP_Dismiss_Pointers');


/* WELCOME SCREEN AJAX INSTALL FUNCTIONS */
function EWD_OTP_AJAX_Edit_Statuses() {
    $Statuses_Array = isset($_POST['statuses']) ? json_decode(stripslashes($_POST['statuses'])) : '';
    if (is_array($Statuses_Array)) {
        $Statuses_Array_Save = array();
        foreach ($Statuses_Array as $Statuses_Array_Item) {$Statuses_Array_Save[] = array('Status' => $Statuses_Array_Item->status, 'Percentage' => $Statuses_Array_Item->percentage, 'Message' => 'Default', 'Internal' => 'No');}

        usort($Statuses_Array_Save, 'EWD_OTP_Status_Sort');

        update_option("EWD_OTP_Statuses_Array", $Statuses_Array_Save);
    }

    exit();
}
add_action('wp_ajax_ewd_otp_welcome_update_statuses', 'EWD_OTP_AJAX_Edit_Statuses');

function EWD_OTP_AJAX_Add_Tracking_Page() {
    wp_insert_post(array(
        'post_title' => ( isset($_POST['tracking_page_title']) ? sanitize_text_field( $_POST['tracking_page_title'] ) : '' ),
        'post_content' => '<!-- wp:paragraph --><p> [tracking-form] </p><!-- /wp:paragraph -->',
        'post_status' => 'publish',
        'post_type' => 'page'
    ));

    exit();
}
add_action('wp_ajax_ewd_otp_welcome_add_tracking_page', 'EWD_OTP_AJAX_Add_Tracking_Page');

function EWD_OTP_AJAX_Set_Options() {
    update_option( "EWD_OTP_Order_Information", json_decode( stripslashes( $_POST['order_information'] ) ) );
    update_option( "EWD_OTP_Order_Email", sanitize_email( $_POST['order_email'] ) );
    update_option( "EWD_OTP_Form_Instructions", sanitize_text_field( $_POST['form_instructions'] ) );
    update_option( "EWD_OTP_Hide_Blank_Fields", sanitize_text_field( $_POST['hide_blank_fields'] ) );

    exit();
}
add_action('wp_ajax_ewd_otp_welcome_set_options', 'EWD_OTP_AJAX_Set_Options');

function EWD_OTP_AJAX_Add_Order() {
    $Order_Name = isset( $_POST['order_name'] ) ? sanitize_text_field( $_POST['order_name'] ) : '';; 
    $Order_Number = isset( $_POST['order_number'] ) ? sanitize_text_field( $_POST['order_number'] ) : '';;
    $Order_Email = isset( $_POST['order_email'] ) ? sanitize_email( $_POST['order_email'] ) : '';
    $Order_Status = $Order_External_Status = isset( $_POST['order_status'] ) ? sanitize_text_field( $_POST['order_status'] ) : '';
    $Order_Location  = "";
    $Order_Notes_Public = "";
    $Order_Notes_Private = "";
    $Order_Display = "Yes";
    $Order_Status_Updated = date("Y-m-d H:i:s");
    $Customer_ID = 0;
    $Sales_Rep_ID = 0;
    $Order_Payment_Price = 0;
    $Order_Payment_Completed = "No";
    $Order_PayPal_Receipt_Number = "";
    $Order_Internal_Status = "No";

    Add_EWD_OTP_Order($Order_Name, $Order_Number, $Order_Email, $Order_Status, $Order_External_Status, $Order_Location, $Order_Notes_Public, $Order_Notes_Private, $Order_Display, $Order_Status_Updated, $Customer_ID, $Sales_Rep_ID, $Order_Payment_Price, $Order_Payment_Completed, $Order_PayPal_Receipt_Number, $Order_Internal_Status);

    exit();
}
add_action('wp_ajax_ewd_otp_welcome_add_order', 'EWD_OTP_AJAX_Add_Order');