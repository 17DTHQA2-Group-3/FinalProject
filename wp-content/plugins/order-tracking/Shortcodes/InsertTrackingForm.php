<?php 
function OTP_Tracking_Form_Block() {
    if(function_exists('render_block_core_block')){  
		wp_register_script( 'ewd-otp-blocks-js', plugins_url( '../blocks/ewd-otp-blocks.js', __FILE__ ), array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-editor' ) );
		wp_register_style( 'ewd-otp-blocks-css', plugins_url( '../blocks/ewd-otp-blocks.css', __FILE__ ), array( 'wp-edit-blocks' ), filemtime( plugin_dir_path( __FILE__ ) . '../blocks/ewd-otp-blocks.css' ) );
		register_block_type( 'order-tracking/ewd-otp-tracking-form-block', array(
			'attributes'      => array(
				'show_orders' => array(
					'type' => 'string',
				),
			),
			'editor_script'   => 'ewd-otp-blocks-js',
			'editor_style'  => 'ewd-otp-blocks-css',
			'render_callback' => 'Insert_Tracking_Form',
		) );
	}
	// Define our shortcode, too, using the same render function as the block.
	add_shortcode("tracking-form", "Insert_Tracking_Form");
}
add_action( 'init', 'OTP_Tracking_Form_Block' );

function Insert_Tracking_Form($atts) {
	global $user_message;
	global $wpdb;
	global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name;
		
	$Custom_CSS = get_option('EWD_OTP_Custom_CSS');
	$New_Window = get_option("EWD_OTP_New_Window");
	$AJAX_Reload = get_option("EWD_OTP_AJAX_Reload");
	$Order_Instructions = get_option("EWD_OTP_Form_Instructions");
	$Order_Form_Title = get_option("EWD_OTP_Tracking_Title_Label");
	$Order_Field_Text = get_option("EWD_OTP_Tracking_Ordernumber_Label");
	$Email_Field_Text = get_option("EWD_OTP_Tracking_Email_Label");
	$Submit_Text = get_option("EWD_OTP_Tracking_Button_Label");
	$Email_Confirmation = get_option("EWD_OTP_Email_Confirmation");

	$Tracking_Links_Checked = get_option("EWD_OTP_Tracking_Links_Checked");
	$Current_Date = date("Y-m-d");

	$Order_Information_Label = get_option("EWD_OTP_Order_Information_Label");
	if ($Order_Information_Label == "") {$Order_Information_Label = __("Order Information", 'order-tracking');}
	$ReturnString = "";

	$Order_Add_Note_Button_Label = get_option("EWD_OTP_Order_Add_Note_Button_Label");
	if($Order_Add_Note_Button_Label == ''){$Order_Add_Note_Button_Label = __('Add Note', 'order-tracking');}
		
	// Get the attributes passed by the shortcode, and store them in new variables for processing
	extract( shortcode_atts( array(
		 		'show_orders' => 'No',
		 		'order_form_title' => __('Track an Order', 'order-tracking'),
				'order_field_text' => __('Order Number', 'order-tracking'),
				'email_field_text' => __('Order E-mail Address', 'order-tracking'),
				'email_field_shortcode' => '',
				'email_field_shortcode_attribute' => '',
				'email_field_attribute_value' => '',
				'order_instructions' => __('Enter the order number you would like to track in the form below.', 'order-tracking'),
				'field_names' => '',
				'submit_text' => __('Track', 'order-tracking'),
				'notes_submit' => $Order_Add_Note_Button_Label),
		$atts
		)
	);

	if (isset($_POST['Status_Update_Submit'])) {EWD_OTP_Front_End_Status_Update();}
		
	if (isset($_POST['Notes_Submit'])) {EWD_OTP_Save_Customer_Note();}
	
	if ($order_instructions != __('Enter the order number you would like to track in the form below.', 'order-tracking') or $Order_Instructions == "") {$Order_Instructions = $order_instructions;}
	if ($order_form_title != __('Track an Order', 'order-tracking') or $Order_Form_Title == "") {$Order_Form_Title = $order_form_title;}
	if ($order_field_text != __('Order Number', 'order-tracking') or $Order_Field_Text == "") {$Order_Field_Text = $order_field_text;}
	if ($email_field_text != __('Order E-mail Address', 'order-tracking') or $Email_Field_Text == "") {$Email_Field_Text = $email_field_text;}
	if ($submit_text != __('Track', 'order-tracking') or $Submit_Text == "") {$Submit_Text = $submit_text;}
		
	$ReturnString .= "<style type='text/css'>";
	$ReturnString .= EWD_OTP_Add_Modified_Styles();
	$ReturnString .= $Custom_CSS;
	$ReturnString .= "</style>";

		
	$Fields = array();
	$Field_Names_Array = explode(",", $field_names);
	foreach ($Field_Names_Array as $Field_Name) {
		$Field_Name_Key = trim(substr($Field_Name, 0, strpos($Field_Name, "=")));
		$Field_Name_Value = trim(substr($Field_Name, strpos($Field_Name, "=")+5));
		$Fields[$Field_Name_Key] = $Field_Name_Value;
	}
		
	//If there's a tracking number that's already been submitted, display the results
	if (!isset($_REQUEST['Order_Email'])) { $_REQUEST['Order_Email'] = "";}
	if (isset($_REQUEST['Tracking_Number'])) {
		if (isset($_GET['TL_Code'])) {
			if ($wpdb->query($wpdb->prepare("UPDATE $EWD_OTP_orders_table_name SET Order_Tracking_Link_Clicked='Yes' WHERE Order_Number=%s AND Order_Tracking_Link_Code=%s", sanitize_text_field( $_GET['Tracking_Number'] ), sanitize_text_field( $_GET['TL_Code'] ) ) ) !== false) {
				$Tracking_Links_Checked[$Current_Date][$_GET['Tracking_Number']]++;
				update_option("EWD_OTP_Tracking_Links_Checked", $Tracking_Links_Checked);
			}

		}

		$ReturnString .= "<div class='ewd-otp-tracking-results pure-g'>";
		$ReturnString .= "<div class='pure-u-1'><h3 class='ewd-otp-main-title'>" . $Order_Information_Label . "</h3></div>";
		$ReturnString .= EWD_OTP_Return_Results( sanitize_text_field( $_REQUEST['Tracking_Number'] ), $Fields, sanitize_email( $_REQUEST['Order_Email'] ), $notes_submit);
		$ReturnString .= "</div>";
	}
		
	if ($AJAX_Reload == "Yes") {
		$ReturnString .= "<div class='ewd-otp-tracking-results pure-g'>";
		$ReturnString .= "<div class='pure-u-1'><h3 class='ewd-otp-main-title'>" . $Order_Information_Label . "</h3></div>";
		$ReturnString .= "<div class='ewd-otp-ajax-results'></div>";
		$ReturnString .= "</div>";
	}
	
	if ($AJAX_Reload == "Yes") {$Form_Class = 'ewd-otp-ajax-form';}
	else {$Form_Class = 'ewd-otp-non-ajax-form';}

	$Tracking_Ordernumber_Placeholder_Label = get_option("EWD_OTP_Tracking_Ordernumber_Placeholder_Label");
	if($Tracking_Ordernumber_Placeholder_Label == ""){$Tracking_Ordernumber_Placeholder_Label = $Order_Field_Text;}
	$Tracking_Email_Placeholder_Label = get_option("EWD_OTP_Tracking_Email_Placeholder_Label");
	if($Tracking_Email_Placeholder_Label == ""){$Tracking_Email_Placeholder_Label = $Email_Field_Text;}

	if ($show_orders != "Yes" ) {
		//Put in the tracking form
		$ReturnString .= "<div id='ewd-otp-tracking-form-div' class='mt-12'>";
		$ReturnString .= "<h3>" . $Order_Form_Title . "</h3>";
		$ReturnString .= "<div class='ewd-otp-message mb-6'>";
		$ReturnString .= $user_message;
		$ReturnString .= $Order_Instructions;
		$ReturnString .= "</div>";
		if ($New_Window == "Yes") {$ReturnString .= "<form action='#' method='post' target='_blank' id='ewd-otp-tracking-form' class='pure-form pure-form-aligned'>";}
		else {$ReturnString .= "<form action='#' method='post' id='ewd-otp-tracking-form' class='pure-form pure-form-aligned ewd-otp-tracking-form " . $Form_Class . "'>";}
		$ReturnString .= "<input type='hidden' name='ewd-otp-action' value='track' />";
		$ReturnString .= "<input type='hidden' id='ewd-otp-field-labels' name='field-labels' value='" . $field_names . "' />";
		$ReturnString .= "<div class='pure-control-group'>";
		$ReturnString .= "<label for='Order_Number' id='ewd-otp-order-number-div' class='ewd-otp-field-label ewd-otp-bold'>" . $Order_Field_Text . ": </label>";
		$ReturnString .= "<input type='text' class='ewd-otp-text-input' id='ewd-otp-tracking-number' name='Tracking_Number' placeholder='" . $Tracking_Ordernumber_Placeholder_Label . "...'>";
		$ReturnString .= "</div>";
		if ($Email_Confirmation == "Order_Email") {
			$ReturnString .= "<div class='pure-control-group'>";
			$ReturnString .= "<label for='Order_Email' id='ewd-otp-order-number-div' class='ewd-otp-field-label ewd-otp-bold'>" . $Email_Field_Text . ": </label>";
			$ReturnString .= "<input type='email' class='ewd-otp-text-input' id='ewd-otp-email' name='Order_Email' placeholder='" . $Tracking_Email_Placeholder_Label . "...'>";
			$ReturnString .= "</div>";
		}
		if ($Email_Confirmation == "Auto_Entered") {
			$ReturnString .= "<input type='hidden' class='ewd-otp-text-input' id='ewd-otp-email' name='Order_Email' value='[" . $email_field_shortcode . " " . $email_field_shortcode_attribute . "=" . $email_field_attribute_value . "]'>";
		}
		$ReturnString .= "<div class='pure-control-group'>";
		$ReturnString .= "<label for='Submit'></label><input type='submit' class='ewd-otp-submit pure-button pure-button-primary' name='Login_Submit' value='" . $Submit_Text . "'>";
		$ReturnString .= "</div>";
		$ReturnString .= "</form>";
		$ReturnString .= "</div>";
	}
	else {
		$ReturnString .= "<div id='ewd-otp-tracking-form-div' class='mt-12'>";
		$ReturnString .= "<h3>" . $order_form_title . "</h3>";
		$ReturnString .= "<div class='ewd-otp-message mb-6'>";
		$ReturnString .= $user_message;
		$ReturnString .= $Order_Instructions;
		$ReturnString .= "</div>";
		$Orders = $wpdb->get_results("SELECT Order_Number FROM $EWD_OTP_orders_table_name");
		if (is_array($Orders)) {
			foreach ($Orders as $Order) {
				$ReturnString .= "<div class='ewd-otp-order-list-order'>";
				$ReturnString .= "<a href='?Tracking_Number=" . $Order->Order_Number . "'>";
				$ReturnString .= $Order->Order_Number;
				$ReturnString .= "</a>";
				$ReturnString .= "</div>";
			}
		}
		$ReturnString .= "</div>";
	}
		
	return $ReturnString;
}


