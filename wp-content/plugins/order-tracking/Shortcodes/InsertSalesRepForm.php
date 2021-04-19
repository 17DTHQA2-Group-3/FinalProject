<?php 
function OTP_Sales_Rep_Form_Block() {
    if(function_exists('render_block_core_block')){  
		wp_register_script( 'ewd-otp-blocks-js', plugins_url( '../blocks/ewd-otp-blocks.js', __FILE__ ), array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-editor' ) );
		wp_register_style( 'ewd-otp-blocks-css', plugins_url( '../blocks/ewd-otp-blocks.css', __FILE__ ), array( 'wp-edit-blocks' ), filemtime( plugin_dir_path( __FILE__ ) . '../blocks/ewd-otp-blocks.css' ) );
		register_block_type( 'order-tracking/ewd-otp-sales-rep-form-block', array(
			'editor_script'   => 'ewd-otp-blocks-js',
			'editor_style'  => 'ewd-otp-blocks-css',
			'render_callback' => 'Insert_Sales_Rep_Form',
		) );
	}
	// Define our shortcode, too, using the same render function as the block.
	add_shortcode("sales-rep-form", "Insert_Sales_Rep_Form");
}
add_action( 'init', 'OTP_Sales_Rep_Form_Block' );

function Insert_Sales_Rep_Form($atts) {
	global $user_message;
	global $wpdb;
	global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name, $EWD_OTP_sales_reps;
		
	$Custom_CSS = get_option('EWD_OTP_Custom_CSS');
	$New_Window = get_option("EWD_OTP_New_Window");
	$Email_Confirmation = get_option("EWD_OTP_Email_Confirmation");
	$Order_Instructions = get_option("EWD_OTP_Sales_Rep_Form_Description_Label");
	if($Order_Instructions == ""){$Order_Instructions = __('Enter your sales rep number in the form below to track your orders.', 'order-tracking');}
	$Sales_Rep_Form_Title_Label = get_option("EWD_OTP_Sales_Rep_Form_Title_Label");
	if($Sales_Rep_Form_Title_Label == ""){$Sales_Rep_Form_Title_Label = __('Track Your Orders', 'order-tracking');}
	$Sales_Rep_Form_Number_Label = get_option("EWD_OTP_Sales_Rep_Form_Number_Label");
	if($Sales_Rep_Form_Number_Label == ""){$Sales_Rep_Form_Number_Label = __('Sales Rep Number', 'order-tracking');}
	$Sales_Rep_Form_Number_Placeholder_Label = get_option("EWD_OTP_Sales_Rep_Form_Number_Placeholder_Label");
	if($Sales_Rep_Form_Number_Placeholder_Label == ""){$Sales_Rep_Form_Number_Placeholder_Label = __('Sales Rep Number', 'order-tracking');}
	$Sales_Rep_Form_Email_Label = get_option("EWD_OTP_Sales_Rep_Form_Email_Label");
	if($Sales_Rep_Form_Email_Label == ""){$Sales_Rep_Form_Email_Label = __('Sales Rep Email', 'order-tracking');}
	$Sales_Rep_Form_Email_Placeholder_Label = get_option("EWD_OTP_Sales_Rep_Form_Email_Placeholder_Label");
	if($Sales_Rep_Form_Email_Placeholder_Label == ""){$Sales_Rep_Form_Email_Placeholder_Label = __('Sales Rep Email', 'order-tracking');}
	$Sales_Rep_Form_Button_Label = get_option("EWD_OTP_Sales_Rep_Form_Button_Label");
	if($Sales_Rep_Form_Button_Label == ""){$Sales_Rep_Form_Button_Label = __('Track', 'order-tracking');}

	$ReturnString = "";
		
	// Get the attributes passed by the shortcode, and store them in new variables for processing
	extract( shortcode_atts( array(
		 		'order_form_title' => $Sales_Rep_Form_Title_Label,
				'order_field_text' => $Sales_Rep_Form_Number_Label,
				'email_field_text' => $Sales_Rep_Form_Email_Label,
				'email_field_shortcode' => '',
				'email_field_shortcode_attribute' => '',
				'email_field_attribute_value' => '',
				'order_instructions' => $Order_Instructions,
				'field_names' => '',
				'submit_text' => $Sales_Rep_Form_Button_Label),
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

	$WP_User = wp_get_current_user();

	$Sales_Rep_ID = '';
	$Sales_Rep_Email = '';
	if (isset($_POST['Sales_Rep_ID'])) {
		$Sales_Rep_ID = intval( $_POST['Sales_Rep_ID'] );
		$Sales_Rep_Email = isset( $_POST['Sales_Rep_Email'] ) ? sanitize_email( $_POST['Sales_Rep_Email'] ): '';
	}
	elseif ($WP_User->ID != 0) {
		$Sales_Rep = $wpdb->get_row($wpdb->prepare("SELECT Sales_Rep_ID, Sales_Rep_Email FROM $EWD_OTP_sales_reps WHERE Sales_Rep_WP_ID=%d", $WP_User->ID));
		if ( is_object( $Sales_Rep ) ) { $Sales_Rep_ID = $Sales_Rep->Sales_Rep_ID; }
		if ( is_object( $Sales_Rep ) ) { $Sales_Rep_Email = $Sales_Rep->Sales_Rep_Email; }
	}
		
	//If there's a tracking number that's already been submitted, display the results
	if ($Sales_Rep_ID != "") {
		$ReturnString .= "<div class='ewd-otp-tracking-results pure-g'>";
		$ReturnString .= "<div class='pure-u-1'><h3>" . __("Order Information", 'order-tracking') . "</h3></div>";
		$ReturnString .= EWD_OTP_Return_Sales_Rep_Results($Sales_Rep_ID, $Fields, $Sales_Rep_Email);
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
	$ReturnString .= "<input type='hidden' name='ewd-otp-action' value='sales-rep-track'>";
	$ReturnString .= "<div class='pure-control-group'>";
	$ReturnString .= "<label for='Order_Number' id='ewd-otp-order-number-div' class='ewd-otp-field-label ewd-otp-bold'>" . $order_field_text . ": </label>";
	$ReturnString .= "<input type='text' class='ewd-otp-text-input' name='Sales_Rep_ID' placeholder='" . $Sales_Rep_Form_Number_Placeholder_Label . "...'>";
	$ReturnString .= "</div>";
	if ($Email_Confirmation == "Order_Email") {
		$ReturnString .= "<div class='pure-control-group'>";
		$ReturnString .= "<label for='Order_Email' id='ewd-otp-order-number-div' class='ewd-otp-field-label ewd-otp-bold'>" . $email_field_text . ": </label>";
		$ReturnString .= "<input type='email' class='ewd-otp-text-input' name='Sales_Rep_Email' placeholder='" . $Sales_Rep_Form_Email_Placeholder_Label . "...'>";
		$ReturnString .= "</div>";
	}
	if ($Email_Confirmation == "Auto_Entered") {
		$ReturnString .= "<input type='hidden' class='ewd-otp-text-input' name='Sales_Rep_Email' value='[" . $email_field_shortcode . " " . $email_field_shortcode_attribute . "=" . $email_field_attribute_value . "]'>";
	}
	$ReturnString .= "<div class='pure-control-group'>";
	$ReturnString .= "<label for='Submit'></label><input type='submit' class='ewd-otp-submit pure-button pure-button-primary' name='Login_Submit' value='" . $submit_text . "'>";
	$ReturnString .= "</div>";
	$ReturnString .= "</form>";
	$ReturnString .= "</div>";
		
	return $ReturnString;
}



