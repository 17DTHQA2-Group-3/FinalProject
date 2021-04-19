<?php
function EWD_OTP_Zendesk_Integration() {
	$Zendesk_Integration = get_option("EWD_OTP_Zendesk_Integration");

	if ($Zendesk_Integration == "Yes" and isset($_GET['Action'])) {
		if ($_GET['Action'] == "Zendesk_Order_Created") {EWD_OTP_Create_Zendesk_Order();}
		if ($_GET['Action'] == "Zendesk_Order_Updated") {EWD_OTP_Update_Zendesk_Order();}
	}
}
add_action("init", "EWD_OTP_Zendesk_Integration");

function EWD_OTP_Create_Zendesk_Order() {
	global $wpdb;
	global $EWD_OTP_orders_table_name;

	$API_Key = get_option("EWD_OTP_Zendesk_API_Key");
	if (isset($_GET['API_Key']) and $_GET['API_Key'] != $API_Key) {exit();}
	
	$Zendesk_ID = sanitize_text_field( $_GET['zendeskID'] );
	$Order_ID = $wpdb->get_var( $wpdb->prepare( "SELECT Order_ID FROM $EWD_OTP_orders_table_name WHERE Zendesk_ID=%d", $Zendesk_ID ) );
	if ($Order_ID != "") {exit();}

	$Order_Name = sanitize_text_field( $_GET['title'] );
	$Order_Number = sanitize_text_field( $_GET['zendeskID'] ) . " - " . sanitize_text_field( $_GET['title'] );
	$Order_Email = sanitize_text_field( $_GET['email'] );
	$Order_Status = sanitize_text_field( $_GET['status'] );
	$Order_External_Status = sanitize_text_field( $_GET['status'] );
	$Order_Status_Updated = date("Y-m-d H:i:s");

	$Order_Location = "";
	$Order_Notes_Public = "Ticket created via Zendesk";
	$Order_Notes_Private = "";
	$Order_Display = "Yes";
	$Customer_ID = 0;
	$Sales_Rep_ID = 0;
	$Order_Payment_Price = 0;
	$Order_Payment_Completed = "No";
	$Order_PayPal_Receipt_Number = "";
	$Order_Internal_Status = "No";
	$WooCommerce_ID = 0;

	Add_EWD_OTP_Order($Order_Name, $Order_Number, $Order_Email, $Order_Status, $Order_External_Status, $Order_Location, $Order_Notes_Public, $Order_Notes_Private, $Order_Display, $Order_Status_Updated, $Customer_ID, $Sales_Rep_ID, $Order_Payment_Price, $Order_Payment_Completed, $Order_PayPal_Receipt_Number, $Order_Internal_Status, $WooCommerce_ID, $Zendesk_ID);
}

function EWD_OTP_Update_Zendesk_Order() {
	global $wpdb;
	global $EWD_OTP_orders_table_name;

	$API_Key = get_option("EWD_OTP_Zendesk_API_Key");
	if (isset($_GET['API_Key']) and $_GET['API_Key'] != $API_Key) {exit();}
	
	$Zendesk_ID = sanitize_text_field( $_GET['zendeskID'] );
	$Order_ID = $wpdb->get_var($wpdb->prepare("SELECT Order_ID FROM $EWD_OTP_orders_table_name WHERE Zendesk_ID=%d", $Zendesk_ID));
	
	$Order_Name = sanitize_text_field( $_GET['title'] );
	$Order_Number = sanitize_text_field( $_GET['zendeskID'] ) . " - " . sanitize_text_field( $_GET['title'] );
	$Order_Email = sanitize_text_field( $_GET['email'] );
	$Order_Status = sanitize_text_field( $_GET['status'] );
	$Order_External_Status = sanitize_text_field( $_GET['status'] );
	$Order_Status_Updated = date("Y-m-d H:i:s");

	$Order_Location = "";
	$Order_Notes_Public = "Ticket created via Zendesk";
	$Order_Notes_Private = "";
	$Order_Display = "Yes";
	$Customer_ID = 0;
	$Sales_Rep_ID = 0;
	$Order_Payment_Price = 0;
	$Order_Payment_Completed = "No";
	$Order_PayPal_Receipt_Number = "";
	$Order_Internal_Status = "No";
	$WooCommerce_ID = 0;

	Edit_EWD_OTP_Order($Order_ID, $Order_Name, $Order_Number, $Order_Email, $Order_Status, $Order_External_Status, $Order_Location, $Order_Notes_Public, $Order_Notes_Private, $Order_Display, $Order_Status_Updated, $Customer_ID, $Sales_Rep_ID, $Order_Payment_Price, $Order_Payment_Completed, $Order_PayPal_Receipt_Number, $Order_Internal_Status);
}
?>