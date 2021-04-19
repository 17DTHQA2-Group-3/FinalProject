<?php

function EWD_OTP_Add_UWPM_Element_Sections() {
	if (function_exists('uwpm_register_custom_element_section')) {
		uwpm_register_custom_element_section('ewd_otp_uwpm_elements', array('label' => 'Status Tracking Tags'));
	}
}
add_action('uwpm_register_custom_element_section', 'EWD_OTP_Add_UWPM_Element_Sections');

function EWD_OTP_Add_UWPM_Elements() {
	global $wpdb;
	global $EWD_OTP_fields_table_name;

	if (function_exists('uwpm_register_custom_element')) {
		uwpm_register_custom_element('ewd_otp_order_name', 
			array(
				'label' => 'Order Name',
				'callback_function' => 'EWD_OTP_UWPM_Order_Name',
				'section' => 'ewd_otp_uwpm_elements'
			)
		);
		uwpm_register_custom_element('ewd_otp_order_number', 
			array(
				'label' => 'Order Number',
				'callback_function' => 'EWD_OTP_UWPM_Order_Number',
				'section' => 'ewd_otp_uwpm_elements'
			)
		);
		uwpm_register_custom_element('ewd_otp_order_status', 
			array(
				'label' => 'Order Status',
				'callback_function' => 'EWD_OTP_UWPM_Order_Status',
				'section' => 'ewd_otp_uwpm_elements'
			)
		);
		uwpm_register_custom_element('ewd_otp_order_notes', 
			array(
				'label' => 'Order Notes',
				'callback_function' => 'EWD_OTP_UWPM_Order_Notes',
				'section' => 'ewd_otp_uwpm_elements'
			)
		);
		uwpm_register_custom_element('ewd_otp_order_customer_notes', 
			array(
				'label' => 'Order Customer Notes',
				'callback_function' => 'EWD_OTP_UWPM_Order_Customer_Notes',
				'section' => 'ewd_otp_uwpm_elements'
			)
		);
		uwpm_register_custom_element('ewd_otp_order_updated_time', 
			array(
				'label' => 'Order Updated Time',
				'callback_function' => 'EWD_OTP_UWPM_Order_Updated_Time',
				'section' => 'ewd_otp_uwpm_elements'
			)
		);
		uwpm_register_custom_element('ewd_otp_order_updated_time', 
			array(
				'label' => 'Tracking Link',
				'callback_function' => 'EWD_OTP_UWPM_Order_Tracking_Link',
				'section' => 'ewd_otp_uwpm_elements',
				'attributes' => array(
					array(
						'attribute_name' => 'ewd_otp_tracking_page_url',
						'attribute_label' => 'Tracking Page URL',
						'attribute_type' => 'TextBox'
					),
					array(
						'attribute_name' => 'ewd_otp_tracking_link_text_label',
						'attribute_label' => '"Track Your Order!" label',
						'attribute_type' => 'TextBox'
					)
				)
			)
		);

		uwpm_register_custom_element('ewd_otp_order_customer_name', 
			array(
				'label' => 'Customer Name',
				'callback_function' => 'EWD_OTP_UWPM_Order_Customer_Name',
				'section' => 'ewd_otp_uwpm_elements'
			)
		);
		uwpm_register_custom_element('ewd_otp_order_customer_id', 
			array(
				'label' => 'Customer ID',
				'callback_function' => 'EWD_OTP_UWPM_Order_Customer_ID',
				'section' => 'ewd_otp_uwpm_elements'
			)
		);
		uwpm_register_custom_element('ewd_otp_order_sales_rep_name', 
			array(
				'label' => 'Sales Rep Name',
				'callback_function' => 'EWD_OTP_UWPM_Order_Sales_Rep_Name',
				'section' => 'ewd_otp_uwpm_elements'
			)
		);

		$Fields = $wpdb->get_results("SELECT Field_Name, Field_Slug FROM $EWD_OTP_fields_table_name WHERE Field_Function='Orders'");
		foreach ($Fields as $Field) {
			uwpm_register_custom_element('ewd_otp_' . $Field->Field_Slug, 
				array(
					'label' => $Field->Field_Name,
					'callback_function' => 'EWD_OTP_UWPM_Field_Replace_Function',
					'section' => 'ewd_otp_uwpm_elements'
				)
			);
		}
	}
}
add_action('uwpm_register_custom_element', 'EWD_OTP_Add_UWPM_Elements');

function EWD_OTP_UWPM_Order_Name($Params, $User) {
	global $wpdb;
	global $EWD_OTP_orders_table_name;

	if (!isset($Params['order_id'])) {return;}

	return $wpdb->get_var($wpdb->prepare("SELECT Order_Name FROM $EWD_OTP_orders_table_name WHERE Order_ID=%d", $Params['order_id']));
}

function EWD_OTP_UWPM_Order_Number($Params, $User) {
	global $wpdb;
	global $EWD_OTP_orders_table_name;

	if (!isset($Params['order_id'])) {return;}

	return $wpdb->get_var($wpdb->prepare("SELECT Order_Number FROM $EWD_OTP_orders_table_name WHERE Order_ID=%d", $Params['order_id']));
}

function EWD_OTP_UWPM_Order_Status($Params, $User) {
	global $wpdb;
	global $EWD_OTP_orders_table_name;

	if (!isset($Params['order_id'])) {return;}

	return $wpdb->get_var($wpdb->prepare("SELECT Order_External_Status FROM $EWD_OTP_orders_table_name WHERE Order_ID=%d", $Params['order_id']));
}

function EWD_OTP_UWPM_Order_Notes($Params, $User) {
	global $wpdb;
	global $EWD_OTP_orders_table_name;

	if (!isset($Params['order_id'])) {return;}

	return $wpdb->get_var($wpdb->prepare("SELECT Order_Notes_Public FROM $EWD_OTP_orders_table_name WHERE Order_ID=%d", $Params['order_id']));
}

function EWD_OTP_UWPM_Order_Customer_Notes($Params, $User) {
	global $wpdb;
	global $EWD_OTP_orders_table_name;

	if (!isset($Params['order_id'])) {return;}

	return $wpdb->get_var($wpdb->prepare("SELECT Order_Customer_Notes FROM $EWD_OTP_orders_table_name WHERE Order_ID=%d", $Params['order_id']));
}

function EWD_OTP_UWPM_Order_Updated_Time($Params, $User) {
	global $wpdb;
	global $EWD_OTP_orders_table_name;

	if (!isset($Params['order_id'])) {return;}

	return $wpdb->get_var($wpdb->prepare("SELECT Order_Status_Updated FROM $EWD_OTP_orders_table_name WHERE Order_ID=%d", $Params['order_id']));
}

function EWD_OTP_UWPM_Order_Tracking_Link($Params, $User) {
	global $wpdb;
	global $EWD_OTP_orders_table_name;

	if (!isset($Params['order_id'])) {return;}

	$Track_Your_Order = __('Track your order!', 'order-tracking');

	if (is_array($Params['attributes'])) {
		foreach ($Params['attributes'] as $Attribute_Name => $Attribute_Value) {
			if ($Attribute_Name == 'ewd_otp_tracking_link_text_label') {$Track_Your_Order = $Attribute_Value;}
			if ($Attribute_Name != 'ewd_otp_tracking_page_url') {continue;}

			$Tracking_URL = $Attribute_Value;

			$Order = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE Order_ID=%d", $Params['order_id']));

			$Tracking_Link_Confirmation_Code = EWD_OTP_RandomString();
			$Tracking_Link = $Tracking_URL . "?Tracking_Number=" . $Order->Order_Number . "&Order_Email=" . $Order->Order_Email . "&TL_Code=" . $Tracking_Link_Confirmation_Code;

			$wpdb->query($wpdb->prepare("UPDATE $EWD_OTP_orders_table_name SET Order_Tracking_Link_Code=%s WHERE Order_ID=%d", $Tracking_Link_Confirmation_Code, $Order->Order_ID));
		}
	}

	return "<a href='" . $Tracking_Link . "'>" . $Track_Your_Order . '</a>';
}

function EWD_OTP_UWPM_Order_Customer_Name($Params, $User) {
	global $wpdb;
	global $EWD_OTP_orders_table_name;
	global $EWD_OTP_customers;

	if (!isset($Params['order_id'])) {return;}

	$Customer_ID = $wpdb->get_var($wpdb->prepare("SELECT Customer_ID FROM $EWD_OTP_orders_table_name WHERE Order_ID=%d", $Params['order_id']));

	return $wpdb->get_var($wpdb->prepare("SELECT Customer_Name FROM $EWD_OTP_customers WHERE Customer_ID=%d", $Customer_ID));
}

function EWD_OTP_UWPM_Order_Customer_ID($Params, $User) {
	global $wpdb;
	global $EWD_OTP_orders_table_name;
	global $EWD_OTP_customers;

	if (!isset($Params['order_id'])) {return;}

	return $wpdb->get_var($wpdb->prepare("SELECT Customer_ID FROM $EWD_OTP_orders_table_name WHERE Order_ID=%d", $Params['order_id']));
}

function EWD_OTP_UWPM_Order_Sales_Rep_Name($Params, $User) {
	global $wpdb;
	global $EWD_OTP_orders_table_name;
	global $EWD_OTP_sales_reps;

	if (!isset($Params['order_id'])) {return;}

	$Sales_Rep_ID = $wpdb->get_var($wpdb->prepare("SELECT Sales_Rep_ID FROM $EWD_OTP_orders_table_name WHERE Order_ID=%d", $Params['order_id']));

	return $wpdb->get_var($wpdb->prepare("SELECT CONCAT(Sales_Rep_First_Name, ' ', Sales_Rep_Last_Name) FROM $EWD_OTP_sales_reps WHERE Sales_Rep_ID=%d", $Sales_Rep_ID));
}

function EWD_OTP_UWPM_Field_Replace_Function($Params, $User) {
	global $wpdb;
	global $EWD_OTP_fields_table_name;
	global $EWD_OTP_fields_meta_table_name;
	
	if (!isset($Params['order_id']) or !isset($Params['replace_slug'])) {return;}

	$Field = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_fields_table_name WHERE Field_Slug=%s", substr($Params['replace_slug'], 8)));

	return $wpdb->get_var($wpdb->prepare("SELECT Meta_Value FROM $EWD_OTP_fields_meta_table_name WHERE Field_ID=%d AND Order_ID=%d", $Field->Field_ID, $Params['order_id']));
}
?>