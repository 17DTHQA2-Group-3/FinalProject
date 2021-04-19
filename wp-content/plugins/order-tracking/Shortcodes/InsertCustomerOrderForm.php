<?php
/* The function that creates the HTML on the front-end, based on the parameters
* supplied in the customer-order shortcode */
function Insert_Customer_Order_Form($atts) {
	global $user_message;
	global $wpdb;
	global $EWD_OTP_fields_table_name;
	global $EWD_OTP_sales_reps;
		
	$Custom_CSS = get_option('EWD_OTP_Custom_CSS');
	$Email_Confirmation = get_option("EWD_OTP_Email_Confirmation");

	$Allow_Sales_Rep_Selection = get_option("EWD_OTP_Allow_Sales_Rep_Selection");

	$Order_Name_Label = get_option("EWD_OTP_Customer_Order_Name_Label");
	if ($Order_Name_Label == "") {$Order_Name_Label = __("Order Name", 'order-tracking');}
	$Email_Field_Text = get_option("EWD_OTP_Customer_Order_Email_Label");
	if ($Email_Field_Text == "") {$Email_Field_Text = __("Order Email Address", 'order-tracking');}
	$Customer_Notes_Label = get_option("EWD_OTP_Customer_Order_Notes_Label");
	if ($Customer_Notes_Label == "") {$Customer_Notes_Label = __("Customer Notes", 'order-tracking');}
	$Customer_Order_Button_Label = get_option("EWD_OTP_Customer_Order_Button_Label");
	if($Customer_Order_Button_Label == ""){$Customer_Order_Button_Label = __('Send Order', 'order-tracking');}
	$Customer_Order_Thank_You_Label = get_option("EWD_OTP_Customer_Order_Thank_You_Label");
	if($Customer_Order_Thank_You_Label == ""){$Customer_Order_Thank_You_Label = __('Thank you. Your order number is: ', 'order-tracking');}
	$Customer_Order_Email_Instructions_Label = get_option("EWD_OTP_Customer_Order_Email_Instructions_Label");
	if($Customer_Order_Email_Instructions_Label == ""){$Customer_Order_Email_Instructions_Label = __('The email address to send order updates to, if the site administrator has selected that option.', 'order-tracking');}
	
	$ReturnString = "";
		
	// Get the attributes passed by the shortcode, and store them in new variables for processing
	extract( shortcode_atts( array(
		 		'order_status' => '',
		 		'order_location' => '',
		 		'success_message' => $Customer_Order_Thank_You_Label,
				'customer_name_field_text' => $Order_Name_Label,
				'customer_email_field_text' => $Email_Field_Text,
				'customer_notes_field_text' => $Customer_Notes_Label,
				'submit_text' => $Customer_Order_Button_Label),
		$atts
		)
	);
		
	if (isset($_POST['Customer_Order_Submit'])) {$user_update = EWD_OTP_Save_Customer_Order($success_message, $order_status, $order_location);}

	$ReturnString .= "<style type='text/css'>";
	$ReturnString .= EWD_OTP_Add_Modified_Styles();
	$ReturnString .= $Custom_CSS;
	$ReturnString .= "</style>";

	$ReturnString .= "<div class='ewd-otp-tracking-results pure-g'>";

	if (isset($_POST['Customer_Order_Submit'])) {
		$ReturnString .= "<div class='ewd-otp-user-update ewd-otp-bold pure-u-1'>";
		$ReturnString .= $user_update['Message'];
		$ReturnString .= "</div>";
	}

	$ReturnString .= "<form id='customer_order' method='post' action='#' enctype='multipart/form-data'>";
	$ReturnString .= wp_nonce_field();
	$ReturnString .= wp_referer_field();

	$ReturnString .= "<div class='form-field'>";
	$ReturnString .= "<div id='ewd-otp-customer-order-name-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-5'>";
	$ReturnString .= $customer_name_field_text . ": ";
	$ReturnString .= "</div>";
	$ReturnString .= "<div id='ewd-otp-customer-order-email-label' class='pure-u-4-5'>";
	$ReturnString .= "<input name='Order_Name' id='Order_Name' type='text' value='' size='60' required/>";
	$ReturnString .= "</div>";
	$ReturnString .= "</div>";

	$ReturnString .= "<div class='form-field'>";
	$ReturnString .= "<div id='ewd-otp-customer-order-email-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-5'>";
	$ReturnString .= $customer_email_field_text . ": ";
	$ReturnString .= "</div>";
	$ReturnString .= "<div id='ewd-otp-customer-order-email-label' class='pure-u-4-5'>";
	$ReturnString .= "<input type='email' name='Order_Email_Address' id='Order_Email_Address' required/>";
	$ReturnString .= "</div>";
	$ReturnString .= "<div id='ewd-otp-customer-order-email-label' class='pure-u-1'>";
	$ReturnString .= "<p>" . $Customer_Order_Email_Instructions_Label . "</p>";
	$ReturnString .= "</div>";
	$ReturnString .= "</div>";

	$ReturnString .= "<div id='ewd-otp-customer-notes-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-5'>";
	$ReturnString .= $customer_notes_field_text . ":";
	$ReturnString .= "</div>";
	$ReturnString .= "<div id='ewd-otp-order-notes' class='ewd-otp-order-notes pure-u-4-5'>";
	$ReturnString .= "<textarea name='Customer_Notes'></textarea>";
	$ReturnString .= "</div>";

	if ($Allow_Sales_Rep_Selection == "Yes") {
		$Sales_Reps = $wpdb->get_results("SELECT * FROM $EWD_OTP_sales_reps");

		$ReturnString .= "<div id='ewd-otp-sales-rep-label' class='ewd-otp-order-sales-rep ewd-otp-bold pure-u-1-5'>";
		$ReturnString .= __('Sales Rep', 'order-tracking') . ":";
		$ReturnString .= "</div>";
		$ReturnString .= "<div id='ewd-otp-sales-rep' class='ewd-otp-sales-rep pure-u-4-5'>";
		$ReturnString .= "<select name='Sales_Rep'>";
		foreach ($Sales_Reps as $Sales_Rep) {$ReturnString .= "<option value='" . $Sales_Rep->Sales_Rep_ID . "'>" . $Sales_Rep->Sales_Rep_First_Name . " " . $Sales_Rep->Sales_Rep_Last_Name . "</option>";}
		$ReturnString .= "</select>";
		$ReturnString .= "</div>";
	}

	$Sql = "SELECT * FROM $EWD_OTP_fields_table_name ORDER BY Field_Order";
	$Fields = $wpdb->get_results($Sql);
	$Value = "";
	if (is_array($Fields)) {
		foreach ($Fields as $Field) {
			if ($Field->Field_Front_End_Display == "Yes") {
				if ($Field->Field_Required == "Yes") {$Req_Text = "required";}
				else {$Req_Text = "";}
				$ReturnString .= "<div class='ewd-otp-label ewd-otp-bold pure-u-1-5'><label for='" . $Field->Field_Slug . "'>" . $Field->Field_Name . ":</label></div>";
				$ReturnString .= "<div id='ewd-otp-order-custom-field-" . $Field->Field_ID . "' class='ewd-otp-order-content pure-u-4-5'>";
				if ($Field->Field_Type == "text" or $Field->Field_Type == "mediumint") {
					  $ReturnString .= "<input name='" . $Field->Field_Slug . "' id='ewd-otp-input-" . $Field->Field_ID . "' class='ewd-otp-input' type='text' value='" . $Value . "' " . $Req_Text . " />";
				}
				elseif ($Field->Field_Type == "textarea") {
						$ReturnString .= "<textarea name='" . $Field->Field_Slug . "' id='ewd-otp-input-" . $Field->Field_ID . "' class='ewd-otp-textarea' " . $Req_Text . " >" . $Value . "</textarea>";
				} 
				elseif ($Field->Field_Type == "select") { 
						$Options = explode(",", $Field->Field_Values);
						$ReturnString .= "<select name='" . $Field->Field_Slug . "' id='ewd-otp-input-" . $Field->Field_ID . "' class='ewd-otp-select " . $Req_Text . " '>";
						foreach ($Options as $Option) {
								$ReturnString .= "<option value='" . $Option . "' ";
								if (trim($Option) == trim($Value)) {$ReturnString .= "selected='selected'";}
								$ReturnString .= ">" . $Option . "</option>";
						}
						$ReturnString .= "</select>";
				} 
				elseif ($Field->Field_Type == "radio") {
						$Counter = 0;
						$Options = explode(",", $Field->Field_Values);
						foreach ($Options as $Option) {
								if ($Counter != 0) {$ReturnString .= "<label class='radio'></label>";}
								$ReturnString .= "<input type='radio' name='" . $Field->Field_Slug . "' value='" . $Option . "' class='ewd-otp-radio' " . $Req_Text . " ";
								if (trim($Option) == trim($Value)) {$ReturnString .= "checked";}
								$ReturnString .= ">" . $Option;
								$Counter++;
						}
				} 
				elseif ($Field->Field_Type == "checkbox") {
		  			$Counter = 0;
						$Options = explode(",", $Field->Field_Values);
						$Values = explode(",", $Value);
						foreach ($Options as $Option) {
								if ($Counter != 0) {$ReturnString .= "<label class='radio'></label>";}
								$ReturnString .= "<input type='checkbox' name='" . $Field->Field_Slug . "[]' value='" . $Option . "' class='ewd-otp-checkbox' " . $Req_Text . " ";
								if (in_array($Option, $Values)) {$ReturnString .= "checked";}
								$ReturnString .= ">" . $Option . "</br>";
								$Counter++;
						}
				}
				elseif ($Field->Field_Type == "file" or $Field->Field_Type == "picture") {
						$ReturnString .= "<input name='" . $Field->Field_Slug . "' class='ewd-otp-file-input' type='file' value='' " . $Req_Text . " />";
				}
				elseif ($Field->Field_Type == "date") {
						$ReturnString .= "<input name='" . $Field->Field_Slug . "' class='ewd-otp-date-input ewd-otp-customer-order-datepicker' type='text' value='' " . $Req_Text . " placeholder='Click to choose date' />";
				} 
				elseif ($Field->Field_Type == "datetime") {
						$ReturnString .= "<input name='" . $Field->Field_Slug . "' class='ewd-otp-datetime-input' type='datetime-local' value='' " . $Req_Text . " />";
		  		}
				$ReturnString .= " </div>";
			}
		}
	}
	
	$ReturnString .= "<p class='submit'><input type='submit' name='Customer_Order_Submit' id='submit' class='button-primary' value='" . $submit_text . "'  /></p></form>";
	$ReturnString .= "</div>";

	return $ReturnString;
}
if ($EWD_OTP_Full_Version == "Yes") {add_shortcode("customer-order", "Insert_Customer_Order_Form");}

function EWD_OTP_Premium_Display() {
	echo 'You must have the premium version of the Status Tracking plugin to display the customer order form.';
}

function OTP_Customer_Order_Block() {
	$EWD_OTP_Full_Version = get_option("EWD_OTP_Full_Version");
	if($EWD_OTP_Full_Version == "Yes"){ $blockRender = 'Insert_Customer_Order_Form'; }
	else{ $blockRender = 'EWD_OTP_Premium_Display'; }
    if(function_exists('render_block_core_block')){  
        wp_register_script( 'ewd-otp-blocks-js', plugins_url( '../blocks/ewd-otp-blocks.js', __FILE__ ), array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-editor' ) );
        wp_register_style( 'ewd-otp-blocks-css', plugins_url( '../blocks/ewd-otp-blocks.css', __FILE__ ), array( 'wp-edit-blocks' ), filemtime( plugin_dir_path( __FILE__ ) . '../blocks/ewd-otp-blocks.css' ) );
        register_block_type( 'order-tracking/ewd-otp-customer-order-block', array(
            'editor_script'   => 'ewd-ufaq-blocks-js', // The script name we gave in the wp_register_script() call.
            'editor_style'  => 'ewd-ufaq-blocks-css',
            'render_callback' => $blockRender,
        ) );
    }
    // Define our shortcode, too, using the same render function as the block.
    if ($EWD_OTP_Full_Version == "Yes") { add_shortcode("customer-order", "Insert_Customer_Order_Form"); }
}
add_action( 'init', 'OTP_Customer_Order_Block' );





