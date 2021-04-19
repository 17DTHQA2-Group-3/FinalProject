<?php
$WooCommerce_Integration = get_option("EWD_OTP_WooCommerce_Integration");
$Enabled_Locations_For_WooCommerce = get_option("EWD_OTP_Enabled_Locations_For_WooCommerce");
$Replace_WooCommerce_Statuses = get_option("EWD_OTP_Replace_WooCommerce_Statuses");
$WooCommerce_Show_On_Order_Page = get_option("EWD_OTP_WooCommerce_Show_On_Order_Page");

$Trial_End_WooCommerce_Statuses_Maintain = get_option("EWD_OTP_Trial_End_WooCommerce_Statuses_Maintain");

if ($WooCommerce_Integration == "Yes") {
	add_action('woocommerce_checkout_order_processed', 'Add_WooCommerce_Order');
	add_action('woocommerce_order_status_changed', 'Update_WooCommerce_Order');

	//Use OTP Statuses instead of WC Default Statuses
	if ($Replace_WooCommerce_Statuses == 'Yes') {
		add_filter('wc_order_statuses', 'EWD_OTP_Filter_WC_Statuses');
		add_filter('bulk_actions-edit-shop_order', 'EWD_OTP_Add_Custom_Status_Bulk_Actions', 99);
		add_filter('woocommerce_payment_complete_order_status', 'EWD_OTP_Get_WC_Equivalent_Status');
		add_filter('woocommerce_valid_order_statuses_for_order_again', 'EWD_OTP_Get_WC_Equivalent_Status');
		add_filter('woocommerce_valid_order_statuses_for_cancel', 'EWD_OTP_Get_WC_Equivalent_Status');
		add_filter('woocommerce_bacs_process_payment_order_status', 'EWD_OTP_Get_WC_Equivalent_Status');
		add_filter('woocommerce_default_order_status', 'EWD_OTP_Get_WC_Equivalent_Status');
		add_filter('woocommerce_valid_order_statuses_for_payment', 'EWD_OTP_Get_WC_Equivalent_Status');
		add_filter('woocommerce_valid_order_statuses_for_payment_complete', 'EWD_OTP_Get_WC_Equivalent_Status');
		add_filter('woocommerce_valid_order_statuses_for_cancel', 'EWD_OTP_Get_WC_Equivalent_Status');
		add_filter('woocommerce_reports_order_statuses', 'EWD_OTP_Get_WC_Equivalent_Status');
		add_filter('woocommerce_reports_get_order_report_data_args', 'EWD_OTP_Filter_Report_Parent_Statuses');
	}

	//Add OTP tracking information to the WC Order page
	if ($WooCommerce_Show_On_Order_Page == 'Yes') {
		add_action('woocommerce_order_details_after_order_table', 'EWD_OTP_Add_Tracking_To_WC_Order_Page');
	}

	//Add OTP Location to WC order editing screen
	if ($Enabled_Locations_For_WooCommerce == 'Yes') {
		add_action('woocommerce_admin_order_data_after_order_details', 'EWD_OTP_Add_Order_Location');
		add_action('save_post_shop_order', 'EWD_OTP_Save_WC_Location', 1);
	}
}
if ($Trial_End_WooCommerce_Statuses_Maintain == "Yes") {
	add_filter('wc_order_statuses', 'EWD_OTP_Filter_WC_Statuses');
}

function Update_WooCommerce_Order($post_id, $old_status = "", $new_status = "") {
	global $wpdb, $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name;

	$Order_Email = get_option("EWD_OTP_Order_Email");
	$Timezone = get_option("EWD_OTP_Timezone");
	date_default_timezone_set($Timezone);

	$Post_Type = get_post_type($post_id); 
	if ($Post_Type == "shop_order") {
		$Post_Status = get_post_status($post_id);
		$Order_Status = Return_WC_Order_Status($Post_Status);

		$Order = $wpdb->get_row($wpdb->prepare("SELECT Order_ID, Order_Status, Order_Location FROM $EWD_OTP_orders_table_name WHERE WooCommerce_ID='%d'", $post_id));
		$Order_ID = $Order->Order_ID;
		$Order_Status_Updated = date("Y-m-d H:i:s");

		if ($Order_Status != $Order->Order_Status and $Order_ID != "") {
			Update_EWD_OTP_Order_Status($Order_ID, $Order_Status, $Order_Status_Updated, "", "", (!empty($Order->Location) ? $Order->Location : ''));
			if ($Order_Email == "Change" and $Order_Email[0]) {EWD_OTP_Send_Email($Order_Email[0], $Order_Number, $Order_Status, $Order_Notes_Public, $Order_Status_Updated, $Order_Name);}
		}
	}

}

function Add_WooCommerce_Order($post_id) {
	global $wpdb, $EWD_OTP_customers, $EWD_OTP_fields_table_name, $EWD_OTP_fields_meta_table_name, $Order_ID;

	$Order_Email = get_option("EWD_OTP_Order_Email");
	$Timezone = get_option("EWD_OTP_Timezone");
	date_default_timezone_set($Timezone);

	$WooCommerce_Prefix = get_option("EWD_OTP_WooCommerce_Prefix");
	$WooCommerce_Random_Suffix = get_option("EWD_OTP_WooCommerce_Random_Suffix");

	$Post_Type = get_post_type($post_id); 
	if ($Post_Type == "shop_order") {
		$order = new WC_Order($post_id);
		$WP_ID = $order->get_customer_id();
		$Post_Status = get_post_status($post_id);
		$Order_Status = Return_WC_Order_Status($Post_Status);
		$Order_External_Status = $Order_Status;
		$Order_Internal_Status = $Order_Status;

		$Order_Key = get_post_meta($post_id, "_order_key", true);
		$Order_Email = get_post_meta($post_id, "_billing_email", true);

		$Customer_First_Name = get_post_meta($post_id, "_billing_first_name", true);
		$Customer_Last_Name = get_post_meta($post_id, "_billing_last_name", true);
		$Customer_Name = $Customer_First_Name . " " . $Customer_Last_Name;
		if ($WP_ID == 0) {$Customer_ID = $wpdb->get_var($wpdb->prepare("SELECT Customer_ID FROM $EWD_OTP_customers WHERE Customer_Name='%s'", $Customer_Name));}
		else {$Customer_ID = $wpdb->get_var($wpdb->prepare("SELECT Customer_ID FROM $EWD_OTP_customers WHERE Customer_WP_ID=%d", $WP_ID));}
		if ($Customer_ID == "") {$Customer_ID = 0;}

		$Order_Name = "WooCommerce Order #" . $post_id;
		$Order_Number = $WooCommerce_Prefix . $post_id . ($WooCommerce_Random_Suffix == "Yes" ? "_" . substr($Order_Key, -4) : '');

		$Order_Location = "";
		$Order_Notes_Public = "";
		$Order_Notes_Private = "";
		$Order_Display = "Yes";
		$Order_Status_Updated = date("Y-m-d H:i:s");
		$Sales_Rep_ID = 0;
		$Order_Payment_Price = 0;
		$Order_Payment_Completed = "Yes";
		$Order_PayPal_Receipt_Number = "";
		$Order_Internal_Status;

		$Message = Add_EWD_OTP_Order($Order_Name, $Order_Number, $Order_Email, $Order_Status, $Order_External_Status, $Order_Location, $Order_Notes_Public, $Order_Notes_Private, $Order_Display, $Order_Status_Updated, $Customer_ID, $Sales_Rep_ID, $Order_Payment_Price, $Order_Payment_Completed, $Order_PayPal_Receipt_Number, $Order_Internal_Status, $post_id);
		if (($Order_Email == "Change" or $Order_Email == "Creation") and $Order_Email != "") {EWD_OTP_Send_Email($Order_Email, $Order_Number, $Order_Status, $Order_Notes_Public, $Order_Status_Updated, $Order_Name, "Yes");}

		$Fields = $wpdb->get_results("SELECT Field_ID, Field_Equivalent FROM $EWD_OTP_fields_table_name WHERE Field_Equivalent!='' AND Field_Equivalent!='None'");
		foreach ($Fields as $Field) {$wpdb->query($wpdb->prepare("INSERT INTO $EWD_OTP_fields_meta_table_name (Field_ID, Order_ID, Meta_Value) VALUES (%d, %d, %s)", $Field->Field_ID, $Order_ID, get_post_meta($post_id, $Field->Field_Equivalent, true)));}
	}
}

function EWD_OTP_Filter_WC_Statuses($WC_Statuses) {
	global $wp_post_statuses;

	$Statuses_Array = get_option("EWD_OTP_Statuses_Array");
	if (!is_array($Statuses_Array)) {return $WC_Statuses;}

	$Statuses = array();
	foreach ($Statuses_Array as $Status_Array_Item) {
		$Sanitized_Title = sanitize_title($Status_Array_Item['Status']);
		$Statuses['wc-' . $Sanitized_Title] = $Status_Array_Item['Status'];

		if (!isset($wp_post_statuses['wc-' . $Sanitized_Title])) {
			$args = array(
					'name' => 'wc-' . $Sanitized_Title,
					'label' => $Status_Array_Item['Status'],
					'label_count' => false,
					'exclude_from_search' => null,
					'_builtin' => false,
					'internal' => null,
					'protected' => null,
					'private' => null,
					'publicly_queryable' => null,
					'show_in_admin_status_list' => null,
					'show_in_admin_all_list' => true,
					'post_type' => array('shop_order')
			);

			$wp_post_statuses['wc-' . $Sanitized_Title] = (object) $args;
		}
	}

	return $Statuses;
}

function EWD_OTP_Add_Custom_Status_Bulk_Actions($Actions) {
	$Statuses_Array = get_option("EWD_OTP_Statuses_Array");
	if (!is_array($Statuses_Array)) {$Statuses_Array = array();}

	if (isset($Actions['mark_processing'])) {unset($Actions['mark_processing']);}
	if (isset($Actions['mark_on-hold'])) {unset($Actions['mark_on-hold']);}
	if (isset($Actions['mark_completed'])) {unset($Actions['mark_completed']);}

	foreach ($Statuses_Array as $Status_Array_Item) {
		$Sanitized_Title = sanitize_title($Status_Array_Item['Status']);
		$Actions['mark_' . $Sanitized_Title] = __('Change status to ', 'order-tracking') . $Status_Array_Item['Status'];
	}

	return $Actions;
}

function EWD_OTP_Get_WC_Equivalent_Status($Statuses) {
	$Equivalent_Statuses = EWD_OTP_Get_WC_Status_Equivalents();

	$Is_String = (is_array($Statuses) ? false : true);
	if ($Is_String) {$Statuses = array($Statuses);}

	$Return_Statuses = array();
	foreach ($Statuses as $Status) {
		$Return_Statuses[] = $Equivalent_Statuses[$Status];
	}

	if ($Is_String) {return reset($Return_Statuses);}
	else {return $Return_Statuses;}
}

function EWD_OTP_Filter_Report_Parent_Statuses($Query_Params) {
	if (isset($Query_Params['parent_order_status'])) {
		$Equivalent_Status = EWD_OTP_Get_WC_Equivalent_Status($Query_Params['parent_order_status']);
		$Query_Params['parent_order_status'] = $Equivalent_Status;
	}

	return $Query_Params;
}

function EWD_OTP_Add_Tracking_To_WC_Order_Page($order) {
	global $wpdb;
	global $EWD_OTP_orders_table_name;
	global $EWD_OTP_order_statuses_table_name;

	$Tracking_Page = get_option("EWD_OTP_Tracking_Page");

	$OTP_Order = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE WooCommerce_ID=%d", $order->get_order_number()));
	if (!is_object($OTP_Order)) {return;}

	$Statuses = $wpdb->get_results($wpdb->prepare("SELECT * FROM $EWD_OTP_order_statuses_table_name WHERE Order_ID=%d ORDER BY Order_Status_Created DESC", $OTP_Order->Order_ID));

	echo "<h2>" . __('Tracking Information', 'order-tracking') . $Tracking_Link . "</h2>";
	echo "<table class='shop_table shop_table_responsive'>";
	echo "<thead><tr>";
	echo "<th>" . __('Order Status', 'order-tracking') . "</th>";
	echo "<th>" . __('Order Location', 'order-tracking') . "</th>";
	echo "<th>" . __('Updated', 'order-tracking') . "</th>";
	echo "</tr></thead>";
	echo "<tbody>";
	foreach ($Statuses as $Status) {
		echo "<tr>";
		echo "<td>" . $Status->Order_Status . "</td>";
		echo "<td>" . $Status->Order_Location . "</td>";
		echo "<td>" . $Status->Order_Status_Created . "</td>";
		echo "</tr>";
	}
	echo "</tbody>";
	echo "</table>";

	if ($Tracking_Page != '') {
		echo "<p><a href='" . rtrim($Tracking_Page, "/") . "/?Tracking_Number=$OTP_Order->Order_Number&Order_Email=$OTP_Order->Order_Email'>" . __('View Detailed Tracking Information', 'order-tracking') . "</a></p>";
	}
}

function EWD_OTP_Add_Order_Location($order) {
	global $wpdb;
	global $EWD_OTP_orders_table_name;

	$Locations_Array = get_option("EWD_OTP_Locations_Array");
	if (!is_array($Locations_Array)) {$Locations_Array = array();}

	$OTP_Order_Location = $wpdb->get_var($wpdb->prepare("SELECT Order_Location FROM $EWD_OTP_orders_table_name WHERE WooCommerce_ID=%d", $order->get_order_number()));
	
	echo '<p class="form-field form-field-wide wc-order-status">';
	echo '<label for="order_location">' . __( 'Location:', 'order-tracking' ) . '</label>';
	echo '<select id="order_location" name="order_location" class="wc-enhanced-select">';
	foreach ($Locations_Array as $Location_Array_Item ) {
			echo '<option value="' . $Location_Array_Item['Name'] . '" ' . ($OTP_Order_Location == $Location_Array_Item['Name'] ? 'selected' : '') . '>' . $Location_Array_Item['Name'] . '</option>';
	}
	echo '</select>';
	echo '</p>';
}

function EWD_OTP_Save_WC_Location($post_id) {
	global $wpdb;
	global $EWD_OTP_orders_table_name;
	global $EWD_OTP_order_statuses_table_name;

	$Order_Email = get_option("EWD_OTP_Order_Email");

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, it's safe for us to save the data now. If there's no order location, don't save any other information.*/
	if ( ! isset( $_POST['order_location'] ) ) {
		return;
	}

	$Current_Location = $wpdb->get_var($wpdb->prepare("SELECT Order_Location FROM $EWD_OTP_orders_table_name WHERE WooCommerce_ID=%d", $post_id));

	if ($_POST['order_location'] == $Current_Location) {return;}

	$Order = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE WooCommerce_ID=%d", $post_id));

	$Date = date("Y-m-d H:i:s");

	$wpdb->update( $EWD_OTP_orders_table_name, 
		array('Order_Location' => sanitize_text_field( $_POST['order_location'] ),
			'Order_Status_Updated' => $Date),
		array( 'Order_ID' => $Order->Order_ID)
	);

	$Order_Status = Return_WC_Order_Status($_POST['order_status']);
	
	if ($Order_Status == $Order->Order_Status) {
		$wpdb->insert( $EWD_OTP_order_statuses_table_name, 
			array( 'Order_ID' => $Order->Order_ID,
				'Order_Status' => $Order->Order_Status,
				'Order_Location' => sanitize_text_field( $_POST['order_location'] ),
				'Order_Internal_Status' => ($Order->Order_Internal_Status ? $Order->Order_Internal_Status : 'No'),
				'Order_Status_Created' => $Date)
		);

		if ($Order_Email == "Change" and $Order_Email[0]) {EWD_OTP_Send_Email($Order_Email[0], $Order->Order_Number, $Order->Order_Status, $Order->Order_Notes_Public, $Order->Order_Status_Updated, $Order->Order_Name);}
	}
}

function Return_WC_Order_Status($WC_Status) {
	$Statuses_Array = get_option("EWD_OTP_Statuses_Array");
	if (!is_array($Statuses_Array)) {$Statuses_Array = array();}

	switch ($WC_Status) {
		case 'wc-pending':
			$OTP_Status = "Pending Payment";
			break;
		case 'wc-processing':
			$OTP_Status = "Processing";
			break;
		case 'wc-on-hold':
			$OTP_Status = "On Hold";
			break;
		case 'wc-completed':
			$OTP_Status = "Completed";
			break;
		case 'wc-cancelled':
			$OTP_Status = "Cancelled";
			break;
		case 'wc-refunded':
			$OTP_Status = "Refunded";
			break;
		case 'wc-failed':
			$OTP_Status = "Failed";
			break;
		default:
			$OTP_Status = "";
			foreach ($Statuses_Array as $Status_Array_Item) {
				if ('wc-' . sanitize_title($Status_Array_Item['Status']) == $WC_Status) {$OTP_Status = $Status_Array_Item['Status'];}
			}
			break;
	}

	return $OTP_Status;
}

function EWD_OTP_Get_WC_Status_Equivalents() {
	$WooCommerce_Paid_Order_Status = get_option("EWD_OTP_WooCommerce_Paid_Order_Status");
	$WooCommerce_Unpaid_Order_Status = get_option("EWD_OTP_WooCommerce_Unpaid_Order_Status");
	$WooCommerce_Processing_Order_Status = get_option("EWD_OTP_WooCommerce_Processing_Order_Status");
	$WooCommerce_Cancelled_Order_Status = get_option("EWD_OTP_WooCommerce_Cancelled_Order_Status");
	$WooCommerce_OnHold_Order_Status = get_option("EWD_OTP_WooCommerce_OnHold_Order_Status");
	$WooCommerce_Failed_Order_Status = get_option("EWD_OTP_WooCommerce_Failed_Order_Status");
	$WooCommerce_Refunded_Order_Status = get_option("EWD_OTP_WooCommerce_Refunded_Order_Status");

	$Change_Statuses = array(
		'completed' => sanitize_title($WooCommerce_Paid_Order_Status),
		'pending' => sanitize_title($WooCommerce_Unpaid_Order_Status),
		'processing' => sanitize_title($WooCommerce_Processing_Order_Status),
		'cancelled' => sanitize_title($WooCommerce_Cancelled_Order_Status),
		'on-hold' => sanitize_title($WooCommerce_OnHold_Order_Status),
		'failed' => sanitize_title($WooCommerce_Failed_Order_Status),
		'refunded' => sanitize_title($WooCommerce_Refunded_Order_Status)
	);

	return $Change_Statuses;
}

function EWD_OTP_Revert_WC_Statuses() {
	global $wpdb;

	$Statuses_Array = get_option("EWD_OTP_Statuses_Array");
	if (!is_array($Statuses_Array)) {$Statuses_Array = array();}

	$Replace_WooCommerce_Statuses = get_option("EWD_OTP_Replace_WooCommerce_Statuses");
	$WooCommerce_Revert_Statuses = get_option("EWD_OTP_WooCommerce_Revert_Statuses");

	$WooCommerce_Paid_Order_Status = get_option("EWD_OTP_WooCommerce_Paid_Order_Status");
	$WooCommerce_Unpaid_Order_Status = get_option("EWD_OTP_WooCommerce_Unpaid_Order_Status");
	$WooCommerce_Processing_Order_Status = get_option("EWD_OTP_WooCommerce_Processing_Order_Status");
	$WooCommerce_Cancelled_Order_Status = get_option("EWD_OTP_WooCommerce_Cancelled_Order_Status");
	$WooCommerce_OnHold_Order_Status = get_option("EWD_OTP_WooCommerce_OnHold_Order_Status");
	$WooCommerce_Failed_Order_Status = get_option("EWD_OTP_WooCommerce_Failed_Order_Status");
	$WooCommerce_Refunded_Order_Status = get_option("EWD_OTP_WooCommerce_Refunded_Order_Status");

	if ($Replace_WooCommerce_Statuses == "Yes" and $WooCommerce_Revert_Statuses == "Yes") {
		foreach ($Statuses_Array as $Status_Array_Item) {
			$Sanitized_Title = sanitize_title($Status_Array_Item['Status']);

			if ($Status_Array_Item['Status'] == $WooCommerce_Paid_Order_Status) {$WC_Status = 'wc-completed';}
			elseif ($Status_Array_Item['Status'] == $WooCommerce_Unpaid_Order_Status) {$WC_Status = 'wc-pending';}
			elseif ($Status_Array_Item['Status'] == $WooCommerce_Unpaid_Order_Status) {$WC_Status = 'wc-pending';}
			elseif ($Status_Array_Item['Status'] == $WooCommerce_Processing_Order_Status) {$WC_Status = 'wc-processing';}
			elseif ($Status_Array_Item['Status'] == $WooCommerce_Cancelled_Order_Status) {$WC_Status = 'wc-cancelled';}
			elseif ($Status_Array_Item['Status'] == $WooCommerce_OnHold_Order_Status) {$WC_Status = 'wc-on-hold';}
			elseif ($Status_Array_Item['Status'] == $WooCommerce_Failed_Order_Status) {$WC_Status = 'wc-failed';}
			elseif ($Status_Array_Item['Status'] == $WooCommerce_Refunded_Order_Status) {$WC_Status = 'wc-refunded';}
			else {$WC_Status = 'wc-processing';}

			$wpdb->query($wpdb->prepare("UPDATE $wpdb->posts SET post_status=%s WHERE post_status=%s AND post_type='shop_order'", $WC_Status, 'wc-' . $Sanitized_Title));
		}
	}
}
?>