<?php 
function EWD_OTP_Version_Reversion() {
	if (get_option("EWD_OTP_Trial_Happening") != "Yes" or time() < get_option("EWD_OTP_Trial_Expiry_Time")) {return;}

	if (get_option("EWD_OTP_WooCommerce_Integration") == "Yes" and get_option("EWD_OTP_Replace_WooCommerce_Statuses") == "Yes") {EWD_OTP_Trial_End_WC_Status_Check();}

	update_option("EWD_OTP_Access_Role", "administrator");
	update_option("EWD_OTP_WooCommerce_Integration", "No");
	update_option("EWD_OTP_Display_Graphic", "Default");
	update_option("EWD_OTP_Mobile_Stylesheet", "No");
	update_option("EWD_OTP_Customer_Notes_Email", "None");
	update_option("EWD_OTP_Customer_Order_Email", "None");

	update_option("EWD_OTP_Allow_Order_Payments", "No");

	update_option("EWD_OTP_Tracking_Title_Label", "");
	update_option("EWD_OTP_Tracking_Ordernumber_Label", "");
	update_option("EWD_OTP_Tracking_Email_Label", "");
	update_option("EWD_OTP_Tracking_Button_Label", "");
	update_option("EWD_OTP_Order_Information_Label", "");
	update_option("EWD_OTP_Order_Number_Label", "");
	update_option("EWD_OTP_Order_Name_Label", "");
	update_option("EWD_OTP_Order_Notes_Label", "");
	update_option("EWD_OTP_Customer_Notes_Label", "");
	update_option("EWD_OTP_Order_Status_Label", "");
	update_option("EWD_OTP_Order_Location_Label", "");
	update_option("EWD_OTP_Order_Updated_Label", "");

	update_option("EWD_OTP_Styling_Title_Font", "");
	update_option("EWD_OTP_Styling_Title_Font_Size", "");
	update_option("EWD_OTP_Styling_Title_Font_Color", "");
	update_option("EWD_OTP_Styling_Label_Font", "");
	update_option("EWD_OTP_Styling_Label_Font_Size", "");
	update_option("EWD_OTP_Styling_Label_Font_Color", "");
	update_option("EWD_OTP_Styling_Content_Font", "");
	update_option("EWD_OTP_Styling_Content_Font_Size", "");
	update_option("EWD_OTP_Styling_Content_Font_Color", "");
	update_option("EWD_OTP_Styling_Title_Margin", "");
	update_option("EWD_OTP_Styling_Title_Padding", "");
	update_option("EWD_OTP_Styling_Body_Margin", "");
	update_option("EWD_OTP_Styling_Body_Padding", "");
	update_option("EWD_OTP_Styling_Button_Font_Color", "");
	update_option("EWD_OTP_Styling_Button_Bg_Color", "");
	update_option("EWD_OTP_Styling_Button_Border", "");
	update_option("EWD_OTP_Styling_Button_Margin", "");
	update_option("EWD_OTP_Styling_Button_Padding", "");

	update_option("EWD_OTP_Full_Version", "No");
	update_option("EWD_OTP_Trial_Happening", "No");
	delete_option("EWD_OTP_Trial_Expiry_Time");
}
add_action('admin_init', 'EWD_OTP_Version_Reversion');

function EWD_OTP_Trial_End_WC_Status_Check() {
	global $wpdb;

	$Statuses_Array = get_option("EWD_OTP_Statuses_Array");
	if (!is_array($Statuses_Array)) {$Statuses_Array = array();}

	foreach ($Statuses_Array as $Status_Array_Item) {
		$Sanitized_Title = sanitize_title($Status_Array_Item['Status']);

		$wpdb->query($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_type='shop_order' AND post_status=%s", 'wc-' . $Sanitized_Title));
		if ($wpdb->num_rows) {update_option("EWD_OTP_Trial_End_WooCommerce_Statuses_Maintain", "Yes");}
	}
}

?>