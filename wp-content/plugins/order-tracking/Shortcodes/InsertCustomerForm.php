<?php 
function OTP_Customer_Form_Block() {
    if(function_exists('render_block_core_block')){  
		wp_register_script( 'ewd-otp-blocks-js', plugins_url( '../blocks/ewd-otp-blocks.js', __FILE__ ), array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-editor' ) );
		wp_register_style( 'ewd-otp-blocks-css', plugins_url( '../blocks/ewd-otp-blocks.css', __FILE__ ), array( 'wp-edit-blocks' ), filemtime( plugin_dir_path( __FILE__ ) . '../blocks/ewd-otp-blocks.css' ) );
		register_block_type( 'order-tracking/ewd-otp-customer-form-block', array(
			'editor_script'   => 'ewd-otp-blocks-js',
			'editor_style'  => 'ewd-otp-blocks-css',
			'render_callback' => 'Insert_Customer_Form',
		) );
	}
	// Define our shortcode, too, using the same render function as the block.
	add_shortcode("customer-form", "Insert_Customer_Form");
}
add_action( 'init', 'OTP_Customer_Form_Block' );

function Insert_Customer_Form($atts) {
	global $user_message;
	global $wpdb;
	global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name, $EWD_OTP_customers;
		
	$Custom_CSS = get_option('EWD_OTP_Custom_CSS');
	$New_Window = get_option("EWD_OTP_New_Window");
	$Email_Confirmation = get_option("EWD_OTP_Email_Confirmation");
	$Order_Instructions = get_option("EWD_OTP_Customer_Form_Description_Label");
	if($Order_Instructions == ""){$Order_Instructions = __('Enter your customer ID in the form below to track your orders.', 'order-tracking');}
	$Order_Form_Title = get_option("EWD_OTP_Customer_Form_Title_Label");
	if($Order_Form_Title == ""){$Order_Form_Title = __('Track Your Orders', 'order-tracking');}
	$Order_Field_Text = get_option("EWD_OTP_Customer_Form_Number_Label");
	if($Order_Field_Text == ""){$Order_Field_Text = __('Customer Number', 'order-tracking');}
	$Email_Field_Text = get_option("EWD_OTP_Customer_Form_Email_Label");
	if($Email_Field_Text == ""){$Email_Field_Text = __('Customer Email', 'order-tracking');}
	$Submit_Text = get_option("EWD_OTP_Customer_Form_Button_Label");
	if($Submit_Text == ""){$Submit_Text = __('Track', 'order-tracking');}
	$Customer_Form_Number_Placeholder_Label = get_option("EWD_OTP_Customer_Form_Number_Placeholder_Label");
	if($Customer_Form_Number_Placeholder_Label == ""){$Customer_Form_Number_Placeholder_Label = __('Customer Number', 'order-tracking');}
	$Customer_Form_Email_Placeholder_Label = get_option("EWD_OTP_Customer_Form_Email_Placeholder_Label");	
	if($Customer_Form_Email_Placeholder_Label == ""){$Customer_Form_Email_Placeholder_Label = __('Customer Email', 'order-tracking');}
	
	$ReturnString = "";
		
	// Get the attributes passed by the shortcode, and store them in new variables for processing
	extract( shortcode_atts( array(
		 		'order_form_title' => $Order_Form_Title,
				'order_field_text' => $Order_Field_Text,
				'email_field_text' => $Email_Field_Text,
				'email_field_shortcode' => '',
				'email_field_shortcode_attribute' => '',
				'email_field_attribute_value' => '',
				'order_instructions' => $Order_Instructions,
				'field_names' => '',
				'submit_text' => $Submit_Text),
		$atts
		)
	);
		
	$ReturnString .= "<style type='text/css'>";
	$ReturnString .= EWD_OTP_Add_Modified_Styles();
	$ReturnString .= $Custom_CSS;
	$ReturnString .= "</style>";
		
	$Fields = array();
	$Field_Names_Array = explode(",", $field_names);
	foreach ($Field_Names_Array as $Field_Name) {
		$Field_Name_Key = trim(substr($Field_Name, 0, strpos($Field_Name, "=>")));
		$Field_Name_Value = trim(substr($Field_Name, strpos($Field_Name, "=>")+2));
		$Fields[$Field_Name_Key] = $Field_Name_Value;
	}
		
	//If there's a tracking number that's already been submitted, display the results
	$FEUP_Installed = false;

	$WP_User = wp_get_current_user();
	if (function_exists('EWD_FEUP_Get_All_Users')) {
		$FEUP_Installed = true;
		$FEUP_User = new FEUP_User();
	}

	$Customer_ID = '';
	$Customer_Email = '';
	if (isset($_POST['Customer_ID'])) {
		$Customer_ID = intval( $_POST['Customer_ID'] );
		$Customer_Email = isset( $_POST['Customer_Email'] ) ? sanitize_email( $_POST['Customer_Email'] ): '';
	}
	elseif ($FEUP_Installed and $FEUP_User->Is_Logged_In()) {
		$Customer = $wpdb->get_row($wpdb->prepare("SELECT Customer_ID, Customer_Email FROM $EWD_OTP_customers WHERE Customer_FEUP_ID=%d", $FEUP_User->Get_User_ID()));
		if (is_object($Customer)) {$Customer_ID = $Customer->Customer_ID;}
		if (is_object($Customer)) {$Customer_Email = $Customer->Customer_Email;}
	}
	elseif ($WP_User->ID != 0) {
		$Customer = $wpdb->get_row($wpdb->prepare("SELECT Customer_ID, Customer_Email FROM $EWD_OTP_customers WHERE Customer_WP_ID=%d", $WP_User->ID));
		if (is_object($Customer)) {$Customer_ID = $Customer->Customer_ID;}
		if (is_object($Customer)) {$Customer_Email = $Customer->Customer_Email; }
	}

	if ($Customer_ID != '') {
		$ReturnString .= "<div class='ewd-otp-tracking-results pure-g'>";
		$ReturnString .= "<div class='pure-u-1'><h3>" . __("Order Information", 'order-tracking') . "</h3></div>";
		$ReturnString .= EWD_OTP_Return_Customer_Results($Customer_ID, $Fields, $Customer_Email);
		$ReturnString .= "</div>";
	}
		
	//Put in the tracking form
	$ReturnString .= "<div id='ewd-otp-tracking-form-div' class='mt-12'>";
	$ReturnString .= "<h3>" . $order_form_title . "</h3>";
	$ReturnString .= "<div class='ewd-otp-message mb-6'>";
	$ReturnString .= $user_message;
	$ReturnString .= $Order_Instructions;
	$ReturnString .= "</div>";
	if ($New_Window == "Yes") {$ReturnString .= "<form action='#' method='post' target='_blank' id='ewd-otp-tracking-form' class='pure-form pure-form-aligned'>";}
	else {$ReturnString .= "<form action='#' method='post' id='ewd-otp-tracking-form' class='pure-form pure-form-aligned'>";}
	$ReturnString .= "<input type='hidden' name='ewd-otp-action' value='customer-track'>";
	$ReturnString .= "<div class='pure-control-group'>";
	$ReturnString .= "<label for='Order_Number' id='ewd-otp-order-number-div' class='ewd-otp-field-label ewd-otp-bold'>" . $order_field_text . ": </label>";
	$ReturnString .= "<input type='text' class='ewd-otp-text-input' name='Customer_ID' placeholder='" . $Customer_Form_Number_Placeholder_Label . "...'>";
	$ReturnString .= "</div>";
	if ($Email_Confirmation == "Order_Email") {
		$ReturnString .= "<div class='pure-control-group'>";
		$ReturnString .= "<label for='Order_Email' id='ewd-otp-order-number-div' class='ewd-otp-field-label ewd-otp-bold'>" . $email_field_text . ": </label>";
		$ReturnString .= "<input type='email' class='ewd-otp-text-input' name='Customer_Email' placeholder='" . $Customer_Form_Email_Placeholder_Label . "...'>";
		$ReturnString .= "</div>";
	}
	if ($Email_Confirmation == "Auto_Entered") {
		$ReturnString .= "<input type='hidden' class='ewd-otp-text-input' name='Customer_Email' value='[" . $email_field_shortcode . " " . $email_field_shortcode_attribute . "=" . $email_field_attribute_value . "]'>";
	}
	$ReturnString .= "<div class='pure-control-group'>";
	$ReturnString .= "<label for='Submit'></label><input type='submit' class='ewd-otp-submit pure-button pure-button-primary' name='Login_Submit' value='" . $submit_text . "'>";
	$ReturnString .= "</div>";
	$ReturnString .= "</form>";
	$ReturnString .= "</div>";
		
	return $ReturnString;
}



