<?php
function EWD_OTP_Return_Results($TrackingNumber, $Fields = array(), $Email = '', $notes_submit = '') {
	global $wpdb;
	global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name, $EWD_OTP_fields_table_name, $EWD_OTP_fields_meta_table_name, $EWD_OTP_sales_reps, $EWD_OTP_customers;
	$ReturnString = "";
	$AJAX_Reload = get_option("EWD_OTP_AJAX_Reload");
	$Email_Confirmation = get_option("EWD_OTP_Email_Confirmation");
	$Order_Information = get_option( "EWD_OTP_Order_Information" );
	$Hide_Blank_Fields = get_option("EWD_OTP_Hide_Blank_Fields");
	$Localize_Date_Time = get_option("EWD_OTP_Localize_Date_Time");
	$Display_Print_Button = get_option("EWD_OTP_Display_Print_Button");

	$Access_Role = get_option("EWD_OTP_Access_Role");
	$Display_Graphic = get_option("EWD_OTP_Display_Graphic");

	$Allow_Order_Payments = get_option("EWD_OTP_Allow_Order_Payments");

	$Statuses_Array = get_option("EWD_OTP_Statuses_Array");
	if (!is_array($Statuses_Array)) {$Statuses_Array = array();}
	$Locations_Array = get_option("EWD_OTP_Locations_Array");
	if (!is_array($Locations_Array)) {$Locations_Array = array();}

	$Links_Checked = get_option("EWD_OTP_Links_Checked");
	$Current_Date = date("Y-m-d");

	$Order_Number_Label = get_option("EWD_OTP_Order_Number_Label");
		if ($Order_Number_Label == "") {$Order_Number_Label = __("Order Number", 'order-tracking');}
		if (array_key_exists ("Order Number", $Fields)) {$Order_Number_Label = $Fields['Order Number'];}
	$Order_Name_Label = get_option("EWD_OTP_Order_Name_Label");
		if ($Order_Name_Label == "") {$Order_Name_Label = __("Order Name", 'order-tracking');}
		if (array_key_exists("Order Name", $Fields)) {$Order_Name_Label = $Fields['Order Name'];}
	$Order_Notes_Label = get_option("EWD_OTP_Order_Notes_Label");
		if ($Order_Notes_Label == "") {$Order_Notes_Label = __("Order Notes", 'order-tracking');}
		if (array_key_exists ("Order Notes", $Fields)) {$Order_Notes_Label = $Fields['Order Notes'];}

	$Customer_Name_Label = get_option("EWD_OTP_Customer_Display_Name_Label");
	if ( $Customer_Name_Label == "" ) {
		$Customer_Name_Label = __("Customer Name", 'order-tracking');
	}
	if ( array_key_exists("Customer Name", $Fields) ) {
		$Customer_Name_Label = $Fields['Customer Name'];
	}

	$Customer_Email_Label = get_option("EWD_OTP_Customer_Display_Email_Label");
	if ( $Customer_Email_Label == "" ) {
		$Customer_Email_Label = __("Customer Email", 'order-tracking');
	}
	if ( array_key_exists("Customer Email", $Fields) ) {
		$Customer_Email_Label = $Fields['Customer Email'];
	}

	$Customer_Notes_Label = get_option("EWD_OTP_Customer_Notes_Label");
		if ($Customer_Notes_Label == "") {$Customer_Notes_Label = __("Customer Notes", 'order-tracking');}
		if (array_key_exists ("Customer Notes", $Fields)) {$Customer_Notes_Label = $Fields['Customer Notes'];}

	$Sales_Rep_First_Name_Label = get_option("EWD_OTP_Sales_Rep_Display_First_Name_Label");
	if ( $Sales_Rep_First_Name_Label == "" ) {
		$Sales_Rep_First_Name_Label = __("Sales Rep First Name", 'order-tracking');
	}
	if ( array_key_exists("Sales Rep First Name", $Fields) ) {
		$Sales_Rep_First_Name_Label = $Fields['Sales Rep First Name'];
	}

	$Sales_Rep_Last_Name_Label = get_option("EWD_OTP_Sales_Rep_Display_Last_Name_Label");
	if ( $Sales_Rep_Last_Name_Label == "" ) {
		$Sales_Rep_Last_Name_Label = __("Sales Rep Last Name", 'order-tracking');
	}
	if ( array_key_exists("Sales Rep Last Name", $Fields) ) {
		$Sales_Rep_Last_Name_Label = $Fields['Sales Rep Last Name'];
	}

	$Order_Payment_Label = __("Order Payment", 'order-tracking');
	$Order_Payment_Completed_Label = __("Payment Completed",'order-tracking');
	$Order_Map_Label = get_option("EWD_OTP_Order_Current_Location_Label");
	if($Order_Map_Label == ''){$Order_Map_Label = __('Current Location', 'order-tracking');}
	$Order_Print_Button_Label = get_option("EWD_OTP_Order_Print_Button_Label");
	if($Order_Print_Button_Label == ''){$Order_Print_Button_Label = __('Print', 'order-tracking');}
	$Order_Status_Label = get_option("EWD_OTP_Order_Status_Label");
		if ($Order_Status_Label == "") {$Order_Status_Label = __("Order Status", 'order-tracking');}
		if (array_key_exists ("Order Status", $Fields)) {$Order_Status_Label = $Fields['Order Status'];}
	$Order_Location_Label = get_option("EWD_OTP_Order_Location_Label");
		if ($Order_Location_Label == "") {$Order_Location_Label = __("Order Location", 'order-tracking');}
		if (array_key_exists ("Order Location", $Fields)) {$Order_Location_Label = $Fields['Order Location'];}
	$Order_Updated_Label = get_option("EWD_OTP_Order_Updated_Label");
		if ($Order_Updated_Label == "") {$Order_Updated_Label = __("Order Updated", 'order-tracking');}
		if (array_key_exists ("Order Updated", $Fields)) {$Order_Updated_Label = $Fields['Order Updated'];}

	$notes_submit = get_option("EWD_OTP_Order_Add_Note_Button_Label");
	if($notes_submit == ''){$notes_submit = __('Add Note', 'order-tracking');}

	if ($AJAX_Reload == "Yes") {$Form_Class = 'ewd-otp-ajax-form';}
	else {$Form_Class = 'ewd-otp-non-ajax-form';}

	$Current_User = wp_get_current_user();

	//Calculate how many blank columns are in the status table
	$Status_Column_Size = 5;
	if (in_array("Order_Status", $Order_Information)) {$Status_Column_Size--;}
	if ( in_array("Order_Location", $Order_Information)) {$Status_Column_Size--;}
	if ( in_array("Order_Updated", $Order_Information)) {$Status_Column_Size--;}

		
	if ($Email_Confirmation == "Auto_Entered") {$Email = do_shortcode($Email);}
		
	if ($Email_Confirmation == "Order_Email" or $Email_Confirmation == "Auto_Entered") {
		if (strpos($Email, "@") !== false and strpos($Email, ".") !== false) {
			$Order = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE Order_Number='%s' and Order_Email LIKE '%s'", $TrackingNumber, '%' . $Email . '%'));
		}
		else {
			$Order = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE Order_Number='%s' and Order_Email='%s'", $TrackingNumber, $Email));
		}
	}
	else {$Order = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE Order_Number='%s'", $TrackingNumber));}

	// get sales rep
	if ( isset($Order->Order_ID) ) {
		$Sales_Rep = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM `{$EWD_OTP_sales_reps}` WHERE `Sales_Rep_ID` = %d", 
				$Order->Sales_Rep_ID
			)
		);
	}

	if (isset($Order->Order_ID)) {$Statuses = $wpdb->get_results($wpdb->prepare("SELECT Order_Status, Order_Location, Order_Status_Created FROM $EWD_OTP_order_statuses_table_name WHERE Order_ID='%s' AND Order_Internal_Status!='Yes' ORDER BY Order_Status_Created ASC", $Order->Order_ID));}

	if ($wpdb->num_rows == 0) {
		$ReturnString .= "<div class='pure-u-1'>";
		if ($Email_Confirmation == "Order_Email") {$ReturnString .= __("There are no order statuses for tracking number: ", 'order-tracking') . $TrackingNumber . " and e-mail: " . $Email . ".<br />";}
		else {$ReturnString .= __("There are no order statuses for tracking number: ", 'order-tracking') . $TrackingNumber . ".<br />";}
		$ReturnString .= "</div>";
	}
	else {
		if (array_key_exists($Current_Date, $Links_Checked)) {
			if (array_key_exists($TrackingNumber, $Links_Checked[$Current_Date])) {
				$Links_Checked[$Current_Date][$TrackingNumber]++;
			}
			else {$Links_Checked[$Current_Date][$TrackingNumber] = 0;}
		}
		else {$Links_Checked[$Current_Date][$TrackingNumber] = 0;}
		update_option("EWD_OTP_Links_Checked", $Links_Checked);
		$wpdb->query($wpdb->prepare("UPDATE $EWD_OTP_orders_table_name SET Order_View_Count = Order_View_Count + 1 WHERE Order_Number=%s", $TrackingNumber));

		// get customer
		$Customer = null;
		if( ! empty($Order->Customer_ID)) {
			$Customer = $wpdb->get_row(
				$wpdb->prepare(
					"SELECT * FROM `{$EWD_OTP_customers}` WHERE `Customer_ID` = %d", 
					$Order->Customer_ID
				)
			);
		}

		if ($Display_Print_Button == "Yes") {
			$ReturnString .= "<button class='ewd-otp-print-results' data-cssurl='" . plugins_url('order-tracking/css/ewd-otp-print.css') . "'>";
			$ReturnString .= $Order_Print_Button_Label;
			$ReturnString .= "</button>";
			$ReturnString .= "<div class='ewd-otp-clear'></div>";
		}
		if (in_array("Order_Graphic", $Order_Information)) {
			$ReturnString .= "<div class='ewd-otp-status-graphic pure-u-1 ewd-otp-" . $Display_Graphic . "'>";
			$ReturnString .= EWD_OTP_Display_Graph( sanitize_text_field( $_REQUEST['Tracking_Number'] ) );
			$ReturnString .= "</div>";
			$ReturnString .= "<div class='ewd-otp-clear'></div>";
		}
		if (in_array("Order_Number", $Order_Information) and ($Hide_Blank_Fields != "Yes" or $Order->Order_Number != "")) {
			$ReturnString .= "<div class='ewd-otp-label-values'>";
			$ReturnString .= "<div id='ewd-otp-order-number-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-8'>";
			$ReturnString .= $Order_Number_Label . "<span>:</span>";
			$ReturnString .= "</div>";
			$ReturnString .= "<div id='ewd-otp-order-number' class='ewd-otp-order-content pure-u-7-8'>";
			$ReturnString .= "<div class='ewd-otp-bottom-align'>" . $Order->Order_Number . "</div>";
			$ReturnString .= "</div>";
			$ReturnString .= "</div>";
		}
		if (in_array("Order_Name", $Order_Information) and ($Hide_Blank_Fields != "Yes" or $Order->Order_Name != "")) {
			$ReturnString .= "<div class='ewd-otp-label-values'>";
			$ReturnString .= "<div id='ewd-otp-order-name-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-8'>";
			$ReturnString .= $Order_Name_Label . "<span>:</span>";
			$ReturnString .= "</div>";
			$ReturnString .= "<div id='ewd-otp-order-name' class='ewd-otp-order-content pure-u-7-8'>";
			$ReturnString .= "<div class='ewd-otp-bottom-align'>" . $Order->Order_Name . "</div>";
			$ReturnString .= "</div>";
			$ReturnString .= "</div>";
		}
		if (in_array("Order_Notes", $Order_Information) and ($Hide_Blank_Fields != "Yes" or $Order->Order_Notes_Public != "")) {
			$ReturnString .= "<div class='ewd-otp-label-values'>";
			$ReturnString .= "<div id='ewd-otp-order-notes-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-8'>";
			$ReturnString .= $Order_Notes_Label . "<span>:</span>";
			$ReturnString .= "</div>";
			$ReturnString .= "<div id='ewd-otp-order-notes' class='ewd-otp-order-content pure-u-7-8'>";
			$ReturnString .= "<div class='ewd-otp-bottom-align'>" . stripslashes_deep($Order->Order_Notes_Public) . "</div>";
			$ReturnString .= "</div>";
			$ReturnString .= "</div>";
		}
		if ($Customer && in_array("Customer_Name", $Order_Information) and ($Hide_Blank_Fields != "Yes" or $Customer->Customer_Name != "")) {
			$ReturnString .= "<div class='ewd-otp-label-values'>";
			$ReturnString .= "<div id='ewd-otp-customer-notes-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-8'>";
			$ReturnString .= $Customer_Name_Label . "<span>:</span>";
			$ReturnString .= "</div>";
			$ReturnString .= "<div id='ewd-otp-order-notes' class='ewd-otp-order-content pure-u-7-8'>";
			$ReturnString .= "<div class='ewd-otp-bottom-align'>" . stripslashes_deep($Customer->Customer_Name) . "</div>";
			$ReturnString .= "</div>";
			$ReturnString .= "</div>";
		}
		if ($Customer && in_array("Customer_Email", $Order_Information) and ($Hide_Blank_Fields != "Yes" or $Customer->Customer_Email != "")) {
			$ReturnString .= "<div class='ewd-otp-label-values'>";
			$ReturnString .= "<div id='ewd-otp-customer-notes-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-8'>";
			$ReturnString .= $Customer_Email_Label . "<span>:</span>";
			$ReturnString .= "</div>";
			$ReturnString .= "<div id='ewd-otp-order-notes' class='ewd-otp-order-content pure-u-7-8'>";
			$ReturnString .= "<div class='ewd-otp-bottom-align'>" . stripslashes_deep($Customer->Customer_Email) . "</div>";
			$ReturnString .= "</div>";
			$ReturnString .= "</div>";
		}
		if (in_array("Customer_Notes", $Order_Information) and ($Hide_Blank_Fields != "Yes" or $Order->Order_Customer_Notes != "")) {
			$ReturnString .= "<div class='ewd-otp-label-values'>";
			$ReturnString .= "<div id='ewd-otp-customer-notes-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-8'>";
			$ReturnString .= $Customer_Notes_Label . "<span>:</span>";
			$ReturnString .= "</div>";
			$ReturnString .= "<div id='ewd-otp-order-notes' class='ewd-otp-order-content pure-u-7-8'>";
			$ReturnString .= "<div class='ewd-otp-bottom-align'>" . stripslashes_deep($Order->Order_Customer_Notes) . "</div>";
			$ReturnString .= "</div>";
			$ReturnString .= "</div>";
		}
		if ($Sales_Rep && in_array("Sales_Rep_First_Name", $Order_Information) and ($Hide_Blank_Fields != "Yes" or $Sales_Rep->Sales_Rep_First_Name != "")) {
			$ReturnString .= "<div class='ewd-otp-label-values'>";
			$ReturnString .= "<div id='ewd-otp-customer-notes-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-8'>";
			$ReturnString .= $Sales_Rep_First_Name_Label . "<span>:</span>";
			$ReturnString .= "</div>";
			$ReturnString .= "<div id='ewd-otp-order-notes' class='ewd-otp-order-content pure-u-7-8'>";
			$ReturnString .= "<div class='ewd-otp-bottom-align'>" . stripslashes_deep($Sales_Rep->Sales_Rep_First_Name) . "</div>";
			$ReturnString .= "</div>";
			$ReturnString .= "</div>";
		}
		if ($Sales_Rep && in_array("Sales_Rep_Last_Name", $Order_Information) and ($Hide_Blank_Fields != "Yes" or $Sales_Rep->Sales_Rep_Last_Name != "")) {
			$ReturnString .= "<div class='ewd-otp-label-values'>";
			$ReturnString .= "<div id='ewd-otp-customer-notes-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-8'>";
			$ReturnString .= $Sales_Rep_Last_Name_Label . "<span>:</span>";
			$ReturnString .= "</div>";
			$ReturnString .= "<div id='ewd-otp-order-notes' class='ewd-otp-order-content pure-u-7-8'>";
			$ReturnString .= "<div class='ewd-otp-bottom-align'>" . stripslashes_deep($Sales_Rep->Sales_Rep_Last_Name) . "</div>";
			$ReturnString .= "</div>";
			$ReturnString .= "</div>";
		}

		$Sql = "SELECT * FROM $EWD_OTP_fields_table_name WHERE Field_Function='Orders' ORDER BY Field_Order";
		$Custom_Fields = $wpdb->get_results($Sql);
		foreach ($Custom_Fields as $Custom_Field) {
			if (in_array($Custom_Field->Field_ID, $Order_Information)) {
				$MetaValue = $wpdb->get_row($wpdb->prepare("SELECT Meta_Value FROM $EWD_OTP_fields_meta_table_name WHERE Order_ID=%d AND Field_ID=%d", $Order->Order_ID, $Custom_Field->Field_ID));
				if (array_key_exists($Custom_Field->Field_Name, $Fields)) {$Field_Label = $Fields[$Custom_Field->Field_Name];}
				else {$Field_Label = $Custom_Field->Field_Name;}

				if ($Hide_Blank_Fields == "Yes" and $MetaValue->Meta_Value == "") {continue;}

				$ReturnString .= "<div class='ewd-otp-label-values'>";
				$ReturnString .= "<div id='ewd-otp-order-" . $Custom_Field->Field_ID . "-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-8'>";
				$ReturnString .= $Field_Label . "<span>:</span>";
				$ReturnString .= "</div>";
				$ReturnString .= "<div id='ewd-otp-order-" . $Custom_Field->Field_ID . "' class='ewd-otp-order-content pure-u-7-8'>";
				if ($Custom_Field->Field_Type == "file") {$ReturnString .= "<div class='ewd-otp-bottom-align'>";
					$ReturnString .= "<a href='" . site_url("/wp-content/uploads/order-tracking-uploads/") . $MetaValue->Meta_Value . "' download>";
					$ReturnString .= $MetaValue->Meta_Value . "</a></div>";
				}
				elseif ($Custom_Field->Field_Type == "picture") {
					$ReturnString .= "<div class='ewd-otp-bottom-align'>";
					$ReturnString .= "<img src='" . site_url("/wp-content/uploads/order-tracking-uploads/") . $MetaValue->Meta_Value . "' />";
					$ReturnString .= "</div>";
				}
				else {$ReturnString .= "<div class='ewd-otp-bottom-align'>" . stripslashes_deep($MetaValue->Meta_Value) . "</div>";}
				$ReturnString .= "</div>";
				$ReturnString .= "</div>";
			}
		}

		if ($Allow_Order_Payments == "Yes" and $Order->Order_Payment_Price > 0) {
			$ReturnString .= "<div class='ewd-otp-label-values'>";
			$ReturnString .= "<div id='ewd-otp-customer-notes-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-8'>";
			$ReturnString .= $Order_Payment_Label . "<span>:</span>";
			$ReturnString .= "</div>";
			if ($Order->Order_Payment_Completed != "Yes") {
				$ReturnString .= "<div id='ewd-otp-order-name' class='ewd-otp-order-content pure-u-7-8'>";
				$ReturnString .= "<div class='ewd-otp-bottom-align'>" . EWD_OTP_Insert_Payment_Form($Order) . "</div>";
				$ReturnString .= "</div>";
			}
			else {
				$ReturnString .= "<div id='ewd-otp-order-name' class='ewd-otp-order-content pure-u-7-8'>";
				$ReturnString .= "<div class='ewd-otp-bottom-align'>" . $Order_Payment_Completed_Label . "</div>";
				$ReturnString .= "</div>";
			}
			$ReturnString .= "</div>";
		}

		if (in_array("Order_Map", $Order_Information)) {
			foreach ($Locations_Array as $key => $Location_Array_Item) {
				if ($Location_Array_Item['Name'] == $Order->Order_Location) {$Current_Location_Index = $key;}
			}
			if (isset($Current_Location_Index) and $Locations_Array[$Current_Location_Index]['Latitude'] != "") {
				$ReturnString .= "<div class='ewd-otp-label-values'>";
				$ReturnString .= "<div id='ewd-otp-map-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-8'>";
				$ReturnString .= $Order_Map_Label . "<span>:</span>";
				$ReturnString .= "</div>";
				$ReturnString .= "<div id='ewd-otp-order-map' class='ewd-otp-order-content pure-u-7-8'>";
				$ReturnString .= "<iframe width='450' height='250' frameborder='0' style='border:0' ";
  				$ReturnString .= "src='https://www.google.com/maps/embed/v1/place?key=AIzaSyBFLmQU4VaX-T67EnKFtos7S7m_laWn6L4&q=" . $Locations_Array[$Current_Location_Index]['Latitude'] . "," . $Locations_Array[$Current_Location_Index]['Longitude'] . "&zoom=15' allowfullscreen>";
				$ReturnString .= "</iframe>";
				$ReturnString .= "</div>";
				$ReturnString .= "</div>";
			}
		}

		$ReturnString .= "<div class='ewd-otp-status-label'>";
		if (in_array("Order_Status", $Order_Information)) {
			$ReturnString .= "<div id='ewd-otp-status-header' class='ewd-otp-status-message pure-u-1-5 mt-12 mb-6 ewd-otp-bold'>";
			$ReturnString .= $Order_Status_Label;
			$ReturnString .= "</div>";
		}
		if (in_array("Order_Location", $Order_Information)) {
			$ReturnString .= "<div id='ewd-otp-location-header' class='ewd-otp-status-location pure-u-1-5 mt-12 mb-6 ewd-otp-bold'>";
			$ReturnString .= $Order_Location_Label;
			$ReturnString .= "</div>";
		}
		if (in_array("Order_Updated", $Order_Information)) {
			$ReturnString .= "<div id='ewd-otp-date-header' class='ewd-otp-status-time pure-u-1-5 mt-12 mb-6 ewd-otp-bold'>";
			$ReturnString .= $Order_Updated_Label;
			$ReturnString .= "</div>";
		}
		$ReturnString .= "</div>";
		if (in_array("Order_Status", $Order_Information) or in_array("Order_Updated", $Order_Information)) {
			foreach ($Statuses as $Status) {
				$ReturnString .= "<div class='ewd-otp-label-values ewd-otp-status-label-content'>";
				if (in_array("Order_Status", $Order_Information)) {
					$ReturnString .= "<div class='ewd-otp-status-message pure-u-1-5'>";
					$ReturnString .= $Status->Order_Status;
					$ReturnString .= "</div>";
				}
				if (in_array("Order_Location", $Order_Information)) {
					$ReturnString .= "<div class='ewd-otp-status-time pure-u-1-5'>";
					$ReturnString .= $Status->Order_Location;
					$ReturnString .= "</div>";
				}
				if (in_array("Order_Updated", $Order_Information)) {
					$ReturnString .= "<div class='ewd-otp-status-time pure-u-1-5'>";
					if ($Localize_Date_Time == "European") {$ReturnString .= date("d-m-Y H:i:s", strtotime($Status->Order_Status_Created));}
					else {$ReturnString .= $Status->Order_Status_Created;}
					$ReturnString .= "</div>";
				}
				$ReturnString .= "</div>";
			}
		}/*echo "Current User:<pre>" . print_r($Current_User, true) . "</pre><br>"; echo "Cap: " . user_can($Current_User, $Access_Role) "<br>";*/
		if ($Current_User->ID != 0 and (user_can($Current_User, $Access_Role) or $Sales_Rep->Sales_Rep_WP_ID == $Current_User->ID)) {
			$ReturnString .= "<form action='#' method='post' class='ewd-otp-front-end-update-form'>";
			$ReturnString .= "<div class='ewd-otp-label-values ewd-otp-status-label-content'>";
				$ReturnString .= "<input type='hidden' name='Action' value='EWD_OTP_UpdateStatus'>";
				$ReturnString .= "<input type='hidden' name='Order_ID' value='" . $Order->Order_ID . "'>";
				//if (in_array("Order_Status", $Order_Information)) {
					$ReturnString .= "<div class='ewd-otp-status-message pure-u-1-5'>";
					$ReturnString .= "<select name='Order_Status' id='Order_Status'>";
					foreach ($Statuses_Array as $Status_Array_Item) {
						$ReturnString .= "<option value='" . $Status_Array_Item['Status'] . "'>" . $Status_Array_Item['Status'] . "</option>";
					}
					$ReturnString .= "</select>";
					$ReturnString .= "</div>";
				//}
				//if (in_array("Order_Location", $Order_Information)) {
					$ReturnString .= "<div class='ewd-otp-status-time pure-u-1-5'>";
					$ReturnString .= "<select name='Order_Location' id='Order_Location'>";
					foreach ($Locations_Array as $Location_Array_Item) {
						$ReturnString .= "<option value='" . $Location_Array_Item['Name'] . "'>" . $Location_Array_Item['Name'] . "</option>";
					}
					$ReturnString .= "</select>";
					$ReturnString .= "</div>";
				//}
				
				$ReturnString .= "<div class='ewd-otp-status-time pure-u-1-5'>";

				$Update_Status_Button_Label = get_option("EWD_OTP_Order_Update_Status_Button_Label");
				if ($Update_Status_Button_Label == "") {$Update_Status_Button_Label = __("Update Status", 'order-tracking');}

				$ReturnString .= "<input type='submit' name='Status_Update_Submit' value='" . $Update_Status_Button_Label . "'>";
				$ReturnString .= "</div>";

			$ReturnString .= "</div>";
			$ReturnString .= "</form>";
		}
		if (in_array("Customer_Notes", $Order_Information)) {
			$ReturnString .= "<div id='ewd-otp-customer-notes-label' class='ewd-otp-status-message pure-u-1 mt-12 mb-6 ewd-otp-bold'>";
			$ReturnString .= $Customer_Notes_Label . ": ";
			$ReturnString .= "</div>";
			// $ReturnString .= "<div id='ewd-otp-customer-notes' class='ewd-otp-status-message pure-u-1-5 mb-6 ewd-otp-bold'>";
			// $ReturnString .= __("Note:", 'order-tracking');
			// $ReturnString .= "</div>";
			$ReturnString .= "<div id='ewd-otp-customer-notes' class='ewd-otp-status-message pure-u-4-5 mb-6'>"; 
			$ReturnString .= "<form action='#' method='post' class='pure-form pure-form-aligned ewd-otp-customer-notes-form " . $Form_Class . "'>";
			$ReturnString .= "<input type='hidden' name='CN_Order_Number' value='" . $TrackingNumber . "' />";
			$ReturnString .= "<input type='hidden' name='Tracking_Number' value='" . $TrackingNumber . "' />";
			if ($Email != "") {$ReturnString .= "<input type='hidden' name='Order_Email' value='" . $Email . "' />";}
			$ReturnString .= "<textarea name='Customer_Notes'>" . $Order->Order_Customer_Notes . "</textarea>";
			$ReturnString .= "<input class='ewd-otp-submit' type='submit' name='Notes_Submit' value='" . $notes_submit . "' />";
			$ReturnString .= "</form>";
			$ReturnString .= "</div>";
		}
	}
	return $ReturnString;
}

function EWD_OTP_Return_Customer_Results($Customer_ID, $Fields = array(), $Customer_Email = '') {
	global $wpdb;
	global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name, $EWD_OTP_fields_table_name, $EWD_OTP_fields_meta_table_name, $EWD_OTP_customers;
	$ReturnString = "";
	$Order_Information = get_option("EWD_OTP_Order_Information");
	$Email_Confirmation = get_option("EWD_OTP_Email_Confirmation");
	$Hide_Blank_Fields = get_option("EWD_OTP_Hide_Blank_Fields");
	$Localize_Date_Time = get_option("EWD_OTP_Localize_Date_Time");
	$Cut_Off_Days = get_option("EWD_OTP_Cut_Off_Days");
	$Tracking_Page = get_option("EWD_OTP_Tracking_Page");

	$Allow_Customer_Downloads = get_option("EWD_OTP_Allow_Customer_Downloads");

	$Order_Number_Label = get_option("EWD_OTP_Order_Number_Label");
		if ($Order_Number_Label == "") {$Order_Number_Label = __("Order Number", 'order-tracking');}
		if (array_key_exists ("Order Number", $Fields)) {$Order_Number_Label = $Fields['Order Number'];}
	$Order_Name_Label = get_option("EWD_OTP_Order_Name_Label");
		if ($Order_Name_Label == "") {$Order_Name_Label = __("Order Name", 'order-tracking');}
		if (array_key_exists("Order Name", $Fields)) {$Order_Name_Label = $Fields['Order Name'];}
	$Order_Notes_Label = get_option("EWD_OTP_Order_Notes_Label");
		if ($Order_Notes_Label == "") {$Order_Notes_Label = __("Order Notes", 'order-tracking');}
		if (array_key_exists ("Order Notes", $Fields)) {$Order_Notes_Label = $Fields['Order Notes'];}
	$Order_Status_Label = get_option("EWD_OTP_Order_Status_Label");
		if ($Order_Status_Label == "") {$Order_Status_Label = __("Order Status", 'order-tracking');}
		if (array_key_exists ("Order Status", $Fields)) {$Order_Status_Label = $Fields['Order Status'];}
	$Order_Location_Label = get_option("EWD_OTP_Order_Location_Label");
		if ($Order_Location_Label == "") {$Order_Location_Label = __("Order Location", 'order-tracking');}
		if (array_key_exists ("Order Location", $Fields)) {$Order_Location_Label = $Fields['Order Location'];}
	$Order_Updated_Label = get_option("EWD_OTP_Order_Updated_Label");
		if ($Order_Updated_Label == "") {$Order_Updated_Label = __("Order Updated", 'order-tracking');}
		if (array_key_exists ("Order Updated", $Fields)) {$Order_Updated_Label = $Fields['Order Updated'];}

	$Links_Checked = get_option("EWD_OTP_Links_Checked");
	$Current_Date = date("Y-m-d");

	if ($Cut_Off_Days == "") {$Cut_Off_Days = 365;}
		
	if ($Email_Confirmation == "Auto_Entered") {$Customer_Email = do_shortcode($Customer_Email);}
		
	if ($Email_Confirmation == "Order_Email" or $Email_Confirmation == "Auto_Entered") {
		$Customer = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_customers WHERE Customer_ID='%d' and Customer_Email='%s'", $Customer_ID, $Customer_Email));
	}
	else {
		$Customer = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_customers WHERE Customer_ID='%d'", $Customer_ID));
	}
	
	if ($Email_Confirmation == "Order_Email" or $Email_Confirmation == "Auto_Entered") {
		if ($wpdb->num_rows == 0) {
			$ReturnString = "There is no customer with the ID " . $Customer_ID . " and an e-mail of " . $Customer_Email;
			return $ReturnString;
		}
	}

	$Page = isset( $_POST['Page'] ) ? intval( $_POST['Page'] ) : 0;
	$Start = ($Page) * 50;
	$CutOffDate = date("Y-m-d H:i:s", time()-(60*60*24*$Cut_Off_Days));

	
	//CutOffDate not yet implemented	
	//$Orders = $wpdb->get_results($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE Customer_ID='%d' AND Order_Status_Updated>'%s' ORDER BY Order_Status_Updated LIMIT %d, 100", $Customer_ID, $CutOffDate, $Start));
	$Orders = $wpdb->get_results($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE Customer_ID='%d' ORDER BY Order_Status_Updated LIMIT %d, 100", $Customer_ID, $Start));

	$Counter = 0;
	$ReturnString .= "<div>";

	if (is_object($Customer)) { $Customer_Name = $Customer->Customer_Name; }
	else {  $Customer_Name = ""; }
	if (in_array("Customer_Name", $Order_Information) and ($Hide_Blank_Fields != "Yes" or $Customer_Name != "")) {
		if (in_array("Customer Name", $Fields)) {$Customer_Name_Label = $Fields['Customer Name'];}
		else {$Customer_Name_Label = __("Customer Name", 'order-tracking');}
		$ReturnString .= "<div class='ewd-otp-label-values'>";
		$ReturnString .= "<div id='ewd-otp-order-name-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-8'>";
		$ReturnString .= $Customer_Name_Label . "<span>:</span>";
		$ReturnString .= "</div>";
		$ReturnString .= "<div id='ewd-otp-order-name' class='ewd-otp-order-content pure-u-7-8'>";
		$ReturnString .= "<div class='ewd-otp-bottom-align'>" . $Customer_Name . "</div>";
		$ReturnString .= "</div>";
		$ReturnString .= "</div>";
	}
	if (is_object($Customer)) { $Customer_Email = $Customer->Customer_Email; }
	else {  $Customer_Email = "";   }
	if (in_array("Customer_Email", $Order_Information) and ($Hide_Blank_Fields != "Yes" or $Customer_Email != "")) {
		if (in_array("Customer Email", $Fields)) {$Customer_Email_Label = $Fields['Customer Email'];}
		else {$Customer_Email_Label = __("Customer Email", 'order-tracking');}
		$ReturnString .= "<div class='ewd-otp-label-values'>";
		$ReturnString .= "<div id='ewd-otp-order-name-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-8'>";
		$ReturnString .= $Customer_Email_Label . "<span>:</span>";
		$ReturnString .= "</div>";
		$ReturnString .= "<div id='ewd-otp-order-name' class='ewd-otp-order-content pure-u-7-8'>";
		$ReturnString .= "<div class='ewd-otp-bottom-align'>" . $Customer_Email . "</div>";
		$ReturnString .= "</div>";
		$ReturnString .= "</div>";
	}

	$Sql = "SELECT * FROM $EWD_OTP_fields_table_name WHERE Field_Function='Customers' ORDER BY Field_Order";
	$Custom_Fields = $wpdb->get_results($Sql);
	$Meta_Value = "";
	foreach ($Custom_Fields as $Custom_Field) {
		if (in_array($Custom_Field->Field_ID, $Order_Information)) {
			if (is_object($Customer)) {$Customer_ID = $Customer->Customer_ID;}
			else {$Customer_ID = "";}
			$MetaValue = $wpdb->get_row($wpdb->prepare("SELECT Meta_Value FROM $EWD_OTP_fields_meta_table_name WHERE Customer_ID=%d AND Field_ID=%d", $Customer_ID, $Custom_Field->Field_ID));
			if(is_object($MetaValue)) { $Meta_Value = $MetaValue->Meta_Value;   }
			else {  $MetaValue = ""; }
			if (array_key_exists($Custom_Field->Field_Name, $Fields)) {$Field_Label = $Fields[$Custom_Field->Field_Name];}
			else {$Field_Label = $Custom_Field->Field_Name;}

			if ($Hide_Blank_Fields == "Yes" and $MetaValue == "") {continue;}

			$ReturnString .= "<div class='ewd-otp-label-values'>";
			$ReturnString .= "<div id='ewd-otp-order-" . $Custom_Field->Field_ID . "-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-8'>";
			$ReturnString .= $Field_Label . "<span>:</span>";
			$ReturnString .= "</div>";
			$ReturnString .= "<div id='ewd-otp-order-" . $Custom_Field->Field_ID . "' class='ewd-otp-order-content pure-u-7-8'>";
			if ($Custom_Field->Field_Type == "file") {$ReturnString .= "<div class='ewd-otp-bottom-align'>";
				$ReturnString .= "<a href='" . site_url("/wp-content/uploads/order-tracking-uploads/") . $MetaValue->Meta_Value . "' download>";
				$ReturnString .= $MetaValue->Meta_Value . "</a></div>";
			}
			elseif ($Custom_Field->Field_Type == "picture") {
				$ReturnString .= "<div class='ewd-otp-bottom-align'>";
				$ReturnString .= "<img src='" . site_url("/wp-content/uploads/order-tracking-uploads/") . $MetaValue->Meta_Value . "' />";
				$ReturnString .= "</div>";
			}
			else {$ReturnString .= "<div class='ewd-otp-bottom-align'>" . stripslashes_deep($Meta_Value) . "</div>";}
			$ReturnString .= "</div>";
			$ReturnString .= "</div>";
		}
	}

	$ReturnString .= "<table>";
	$ReturnString .= "<tr>";
	if (in_array("Order_Number", $Order_Information)) {
		$ReturnString .= "<th>";
		$ReturnString .= $Order_Number_Label . "<span>:</span>";
		$ReturnString .= "</th>";
	}
	if (in_array("Order_Name", $Order_Information)) {
		$ReturnString .= "<th>";
		$ReturnString .= $Order_Name_Label . "<span>:</span>";
		$ReturnString .= "</th>";
	}
	if (in_array("Order_Notes", $Order_Information)) {
		$ReturnString .= "<th>";
		$ReturnString .= $Order_Notes_Label . "<span>:</span>";
		$ReturnString .= "</th>";
	}
	$Order = "";
	if(is_object($Order)){  $Order_ID = $Order->Order_ID;}
	else{$Order_ID = "";}
	$Sql = "SELECT * FROM $EWD_OTP_fields_table_name WHERE Field_Function='Orders' ORDER BY Field_Order";
	$Custom_Fields = $wpdb->get_results($Sql);
	foreach ($Custom_Fields as $Custom_Field) {
		if (in_array($Custom_Field->Field_ID, $Order_Information)) {
			$MetaValue = $wpdb->get_results($wpdb->prepare("SELECT Meta_Value FROM $EWD_OTP_fields_meta_table_name WHERE Order_ID=%d AND Field_ID=%d", $Order_ID, $Custom_Field->Field_ID));
			$ReturnString .= "<th>";
			$ReturnString .= $Custom_Field->Field_Name . "<span>:</span>";
			$ReturnString .= "</th>";
		}
	}
	if (in_array("Order_Status", $Order_Information)) {
		$ReturnString .= "<th>";
		$ReturnString .= $Order_Status_Label;
		$ReturnString .= "</th>";
	}
	if (in_array("Order_Location", $Order_Information)) {
		$ReturnString .= "<th>";
		$ReturnString .= $Order_Location_Label;
		$ReturnString .= "</th>";
	}
	if (in_array("Order_Updated", $Order_Information)) {
		$ReturnString .= "<th>";
		$ReturnString .= $Order_Updated_Label;
		$ReturnString .= "</th>";
	}
	$ReturnString .= "</tr>";

	foreach ($Orders as $Order) {
		if ($Counter >= 50) {break;}			
			isset( $Links_Checked[$Current_Date][$Order->Order_Number]) ? $Links_Checked[$Current_Date][$Order->Order_Number]++ : $Links_Checked[$Current_Date][$Order->Order_Number] = 1;
			update_option("EWD_OTP_Links_Checked", $Links_Checked);
			$wpdb->query($wpdb->prepare("UPDATE $EWD_OTP_orders_table_name SET Order_View_Count = Order_View_Count + 1 WHERE Order_Number=%s", $Order->Order_Number));

			if (in_array("Order_Number", $Order_Information)) {
				$ReturnString .= "<td>";
				if ($Tracking_Page != "") {$ReturnString .= "<a href='" . rtrim($Tracking_Page, "/") . "/?Tracking_Number=$Order->Order_Number&Order_Email=$Customer_Email'>";}
				$ReturnString .= $Order->Order_Number;
				if ($Tracking_Page != "") {$ReturnString .= "</a>";}
				$ReturnString .= "</td>";
			}
			if (in_array("Order_Name", $Order_Information)) {
				$ReturnString .= "<td>";
				$ReturnString .= $Order->Order_Name;
				$ReturnString .= "</td>";
			}
			if (in_array("Order_Notes", $Order_Information)) {
				$ReturnString .= "<td>";
				$ReturnString .= $Order->Order_Notes_Public;
				$ReturnString .= "</td>";
			}
			$Sql = "SELECT * FROM $EWD_OTP_fields_table_name WHERE Field_Function='Orders' ORDER BY Field_Order";
			$Custom_Fields = $wpdb->get_results($Sql);
			foreach ($Custom_Fields as $Custom_Field) {
				if (in_array($Custom_Field->Field_ID, $Order_Information)) {
					$MetaValue = $wpdb->get_row($wpdb->prepare("SELECT Meta_Value FROM $EWD_OTP_fields_meta_table_name WHERE Order_ID=%d AND Field_ID=%d", $Order->Order_ID, $Custom_Field->Field_ID));
					$ReturnString .= "<td>";
					if ($Custom_Field->Field_Type == "file") {
						$ReturnString .= "<a href='" . site_url("/wp-content/uploads/order-tracking-uploads/") . $MetaValue->Meta_Value . "' download>";
						$ReturnString .= is_object( $MetaValue ) ? $MetaValue->Meta_Value : '' . "</a>";
					}
					elseif ($Custom_Field->Field_Type == "picture") {
						$ReturnString .= "<img src='" . site_url("/wp-content/uploads/order-tracking-uploads/") . is_object( $MetaValue ) ? $MetaValue->Meta_Value : '404.jpg' . "' />";
					}
					else {$ReturnString .= is_object( $MetaValue ) ? $MetaValue->Meta_Value : '';}
					$ReturnString .= "</td>";
				}
			}
			if (in_array("Order_Status", $Order_Information) or in_array("Order_Updated", $Order_Information) or in_array("Order_Location", $Order_Information)) {
				//foreach ($Statuses as $Status) {
				if (in_array("Order_Status", $Order_Information)) {
					$ReturnString .= "<td>";
					$ReturnString .= $Order->Order_External_Status;
					$ReturnString .= "</td>";
				}
				if (in_array("Order_Location", $Order_Information)) {
					$ReturnString .= "<td>";
					$ReturnString .= $Order->Order_Location;
					$ReturnString .= "</td>";
				}
				if (in_array("Order_Updated", $Order_Information)) {
					$ReturnString .= "<td>";
					$ReturnString .= $Order->Order_Status_Updated;
					$ReturnString .= "</td>";
				}
				//}
			}
		$ReturnString .= "</tr>";
		$Counter++;
	}
	$ReturnString .= "</table>";
	$ReturnString .= "<div class='ewd-otp-tracking-results pure-g'>";
		
	if ($Counter >= 50) {
		$ReturnString .= "<div class='pure-u-4-5'>";
		$ReturnString .= "<form action='#' method='post'>";
		$ReturnString .= "<input type='hidden' name='Customer_ID' value='" . $Customer_ID . "'>";
		$ReturnString .= "<input type='hidden' name='Customer_Email' value='" . $Customer_Email . "'>";
		$ReturnString .= "<input type='hidden' name='Page' value='" . ( $Page + 1 ) . "'>";
		$ReturnString .= "<input type='submit' name='Customer_Submit' value='Next Page'>";
		$ReturnString .= "</form>";
		$ReturnString .= "</div>";
	}

	if ($Allow_Customer_Downloads == "Yes") {
		$ReturnString .= "<div class='pure-u-4-5'>";
		$ReturnString .= "<form action='#' method='post'>";
		$ReturnString .= "<input type='hidden' name='Customer_ID' value='" . $Customer_ID . "'>";
		$ReturnString .= "<input type='hidden' name='Customer_Email' value='" . $Customer_Email . "'>";
		$ReturnString .= "</form>";
		$ReturnString .= "<button name='Customer_Download'>Download All Orders</button>";
		$ReturnString .= "</div>";
	}
		
	return $ReturnString;
}

function EWD_OTP_Return_Sales_Rep_Results($Sales_Rep_ID, $Fields = array(), $Sales_Rep_Email = '') {
	global $wpdb;
	global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name, $EWD_OTP_fields_table_name, $EWD_OTP_fields_meta_table_name, $EWD_OTP_sales_reps, $EWD_OTP_customers;
	$ReturnString = "";
	$Customer_Email = "";
	$Order_Information = get_option("EWD_OTP_Order_Information");
	$Email_Confirmation = get_option("EWD_OTP_Email_Confirmation");
	$Hide_Blank_Fields = get_option("EWD_OTP_Hide_Blank_Fields");
	$Localize_Date_Time = get_option("EWD_OTP_Localize_Date_Time");
	$Cut_Off_Days = get_option("EWD_OTP_Cut_Off_Days");
	$Tracking_Page = get_option("EWD_OTP_Tracking_Page");

	$Order_Number_Label = get_option("EWD_OTP_Order_Number_Label");
		if ($Order_Number_Label == "") {$Order_Number_Label = __("Order Number", 'order-tracking');}
		if (array_key_exists ("Order Number", $Fields)) {$Order_Number_Label = $Fields['Order Number'];}
	$Order_Name_Label = get_option("EWD_OTP_Order_Name_Label");
		if ($Order_Name_Label == "") {$Order_Name_Label = __("Order Name", 'order-tracking');}
		if (array_key_exists("Order Name", $Fields)) {$Order_Name_Label = $Fields['Order Name'];}
	$Order_Notes_Label = get_option("EWD_OTP_Order_Notes_Label");
		if ($Order_Notes_Label == "") {$Order_Notes_Label = __("Order Notes", 'order-tracking');}
		if (array_key_exists ("Order Notes", $Fields)) {$Order_Notes_Label = $Fields['Order Notes'];}
	$Order_Status_Label = get_option("EWD_OTP_Order_Status_Label");
		if ($Order_Status_Label == "") {$Order_Status_Label = __("Order Status", 'order-tracking');}
		if (array_key_exists ("Order Status", $Fields)) {$Order_Status_Label = $Fields['Order Status'];}
	$Order_Location_Label = get_option("EWD_OTP_Order_Location_Label");
		if ($Order_Location_Label == "") {$Order_Location_Label = __("Order Location", 'order-tracking');}
		if (array_key_exists ("Order Location", $Fields)) {$Order_Location_Label = $Fields['Order Location'];}
	$Order_Updated_Label = get_option("EWD_OTP_Order_Updated_Label");
		if ($Order_Updated_Label == "") {$Order_Updated_Label = __("Order Updated", 'order-tracking');}
		if (array_key_exists ("Order Updated", $Fields)) {$Order_Updated_Label = $Fields['Order Updated'];}
		
	if ($Email_Confirmation == "Auto_Entered") {$Sales_Rep_Email = do_shortcode($Sales_Rep_Email);}
		
	if ($Email_Confirmation == "Order_Email" or $Email_Confirmation == "Auto_Entered") {
		$Sales_Rep = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_sales_reps WHERE Sales_Rep_ID='%d' and Sales_Rep_Email='%s'", $Sales_Rep_ID, $Sales_Rep_Email));
	}
	else {
		$Sales_Rep = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_sales_reps WHERE Sales_Rep_ID='%d'", $Sales_Rep_ID));
	}

	if ($Email_Confirmation == "Order_Email" or $Email_Confirmation == "Auto_Entered") {
		if ($wpdb->num_rows == 0) {
			$ReturnString = "There is no sales rep with the ID " . $Sales_Rep_ID . " and an e-mail of " . $Sales_Rep_Email;
			return $ReturnString;
		}
	}
	
	$Page = isset( $_POST['Page'] ) ? intval( $_POST['Page'] ) : 0;
	$Start = ($Page) * 50;
	$CutOffDate = date("Y-m-d H:i:s", time()-(60*60*24*$Cut_Off_Days));
		
	$Orders = $wpdb->get_results($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE Sales_Rep_ID='%d' AND Order_Status_Updated>'%s' ORDER BY Order_Status_Updated LIMIT %d, 100", $Sales_Rep_ID, $CutOffDate, $Start));
	$Counter = 0;
	$ReturnString .= "<div>";
	$Sales_Rep_First_Name = "";
	if (is_object($Sales_Rep)) { $Sales_Rep_First_Name = $Sales_Rep->Sales_Rep_First_Name; }
	else{   $Sales_Rep_First_Name = ""; }
	if (in_array("Sales_Rep_First_Name", $Order_Information) and ($Hide_Blank_Fields != "Yes" or $Sales_Rep_First_Name != "")) {
		if (in_array("Sales Rep First Name", $Fields)) {$Sales_Rep_First_Name_Label = $Fields['Sales Rep First Name'];}
		else {$Sales_Rep_First_Name_Label = __("Sales Rep First Name", 'order-tracking');}
		$ReturnString .= "<div class='ewd-otp-label-values'>";
		$ReturnString .= "<div id='ewd-otp-order-name-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-8'>";
		$ReturnString .= $Sales_Rep_First_Name_Label . "<span>:</span>";
		$ReturnString .= "</div>";
		$ReturnString .= "<div id='ewd-otp-order-name' class='ewd-otp-order-content pure-u-7-8'>";
 		$ReturnString .= "<div class='ewd-otp-bottom-align'>" . $Sales_Rep_First_Name . "</div>";
		$ReturnString .= "</div>";
		$ReturnString .= "</div>";
	}
	$Sales_Rep_Last_Name = "";
	if (is_object($Sales_Rep)) { $Sales_Rep_Last_Name = $Sales_Rep->Sales_Rep_Last_Name; }
	else{   $Sales_Rep_Last_Name = ""; }
	if (in_array("Sales_Rep_Last_Name", $Order_Information) and ($Hide_Blank_Fields != "Yes" or $Sales_Rep_Last_Name != "")) {
		if (in_array("Sales Rep Last Name", $Fields)) {$Sales_Rep_Last_Name_Label = $Fields['Sales Rep Last Name'];}
		else {$Sales_Rep_Last_Name_Label = __("Sales Rep Last Name", 'order-tracking');}
		$ReturnString .= "<div class='ewd-otp-label-values'>";
		$ReturnString .= "<div id='ewd-otp-order-name-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-8'>";
		$ReturnString .= $Sales_Rep_Last_Name_Label . "<span>:</span>";
		$ReturnString .= "</div>";
		$ReturnString .= "<div id='ewd-otp-order-name' class='ewd-otp-order-content pure-u-7-8'>";
		$ReturnString .= "<div class='ewd-otp-bottom-align'>" . $Sales_Rep_Last_Name . "</div>";
		$ReturnString .= "</div>";
		$ReturnString .= "</div>";
	}

	$Sql = "SELECT * FROM $EWD_OTP_fields_table_name WHERE Field_Function='Sales_Reps' ORDER BY Field_Order";
	$Custom_Fields = $wpdb->get_results($Sql);
	$Meta_Value = "";
	foreach ($Custom_Fields as $Custom_Field) {
		if (in_array($Custom_Field->Field_ID, $Order_Information)) {
			if (is_object($Sales_Rep_ID)) { $Sales_Rep_ID = $Sales_Rep->Sales_Rep_ID; }
			else { $Sales_Rep_ID = ""; }
			$MetaValue = $wpdb->get_row($wpdb->prepare("SELECT Meta_Value FROM $EWD_OTP_fields_meta_table_name WHERE Sales_Rep_ID=%d AND Field_ID=%d", $Sales_Rep_ID, $Custom_Field->Field_ID));
			if(is_object($MetaValue)) { $Meta_Value = $MetaValue->Meta_Value;   }
			else {  $MetaValue = ""; }
			if (array_key_exists($Custom_Field->Field_Name, $Fields)) {$Field_Label = $Fields[$Custom_Field->Field_Name];}
			else {$Field_Label = $Custom_Field->Field_Name;}

			if ($Hide_Blank_Fields == "Yes" and $MetaValue == "") {continue;}

			$ReturnString .= "<div class='ewd-otp-label-values'>";
			$ReturnString .= "<div id='ewd-otp-order-" . $Custom_Field->Field_ID . "-label' class='ewd-otp-order-label ewd-otp-bold pure-u-1-8'>";
			$ReturnString .= $Field_Label . "<span>:</span>";
			$ReturnString .= "</div>";
			$ReturnString .= "<div id='ewd-otp-order-" . $Custom_Field->Field_ID . "' class='ewd-otp-order-content pure-u-7-8'>";
			if ($Custom_Field->Field_Type == "file") {$ReturnString .= "<div class='ewd-otp-bottom-align'>";
				$ReturnString .= "<a href='" . site_url("/wp-content/uploads/order-tracking-uploads/") . $MetaValue->Meta_Value . "' download>";
				$ReturnString .= $MetaValue->Meta_Value . "</a></div>";
			}
			elseif ($Custom_Field->Field_Type == "picture") {
				$ReturnString .= "<div class='ewd-otp-bottom-align'>";
				$ReturnString .= "<img src='" . site_url("/wp-content/uploads/order-tracking-uploads/") . $MetaValue->Meta_Value . "' />";
				$ReturnString .= "</div>";
			}
			else {$ReturnString .= "<div class='ewd-otp-bottom-align'>" . stripslashes_deep($Meta_Value) . "</div>";}
			$ReturnString .= "</div>";
			$ReturnString .= "</div>";
		}
	}

	$ReturnString .= "<table>";
	$ReturnString .= "<tr>";
	if (in_array("Order_Number", $Order_Information)) {
		$ReturnString .= "<th>";
		$ReturnString .= $Order_Number_Label . "<span>:</span>";
		$ReturnString .= "</th>";
	}
	if (in_array("Order_Name", $Order_Information)) {
		$ReturnString .= "<th>";
		$ReturnString .= $Order_Name_Label . "<span>:</span>";
		$ReturnString .= "</th>";
	}
	if (in_array("Order_Notes", $Order_Information)) {
		$ReturnString .= "<th>";
		$ReturnString .= $Order_Notes_Label . "<span>:</span>";
		$ReturnString .= "</th>";
	}
	if (in_array("Customer_Name", $Order_Information)) {
		if (in_array("Customer Name", $Fields)) {$Customer_Name_Label = $Fields['Customer Name'];}
		else {$Customer_Name_Label = __("Customer Name", 'order-tracking');}
		$ReturnString .= "<th>";
		$ReturnString .= $Customer_Name_Label . "<span>:</span>";
		$ReturnString .= "</th>";
	}
	$Sql = "SELECT * FROM $EWD_OTP_fields_table_name WHERE Field_Function='Orders' ORDER BY Field_Order";
	$Custom_Fields = $wpdb->get_results($Sql);
	$Order = "";
	if(is_object($Order)){  $Order_ID = $Order->Order_ID;}
	else{$Order_ID = "";}
	foreach ($Custom_Fields as $Custom_Field) {
		if (in_array($Custom_Field->Field_ID, $Order_Information)) {
			$MetaValue = $wpdb->get_results($wpdb->prepare("SELECT Meta_Value FROM $EWD_OTP_fields_meta_table_name WHERE Order_ID=%d AND Field_ID=%d", $Order_ID, $Custom_Field->Field_ID));
			$ReturnString .= "<th>";
			$ReturnString .= $Custom_Field->Field_Name . "<span>:</span>";
			$ReturnString .= "</th>";
		}
	}
	if (in_array("Order_Status", $Order_Information)) {
		$ReturnString .= "<th>";
		$ReturnString .= $Order_Status_Label;
		$ReturnString .= "</th>";
	}
	if (in_array("Order_Updated", $Order_Information)) {
		$ReturnString .= "<th>";
		$ReturnString .= $Order_Updated_Label;
		$ReturnString .= "</th>";
	}
	$ReturnString .= "</tr>";

	foreach ($Orders as $Order) {
		if ($Counter >= 50) {break;}
		//if (isset($Order->Order_ID)) {$Status = $wpdb->get_row($wpdb->prepare("SELECT Order_Status, Order_Status_Created FROM $EWD_OTP_order_statuses_table_name WHERE Order_ID='%s' AND Order_Status_Created='%s' ORDER BY Order_Status_Created ASC", $Order->Order_ID, $Order->Order_Status_Updated));}
		if (isset($Order->Order_ID)) {$Status = $Order->Order_External_Status;}

		$ReturnString .= "<tr>";
		//if ($wpdb->num_rows == 0) {
		if ($Status == "") {
			$ReturnString .= "<div class='pure-u-1'>";
			if ($Email_Confirmation == "Order_Email") {$ReturnString .= __("There are no order statuses for tracking number: ", 'order-tracking') . $TrackingNumber . " and e-mail: " . $Email . ".<br />";}
			else {$ReturnString .= __("There are no order statuses for tracking number: ", 'order-tracking') . $TrackingNumber . ".<br />";}
			$ReturnString .= "</div>";
		}
		else {					
			if (in_array("Order_Number", $Order_Information)) {
				$ReturnString .= "<td>";
				if ($Tracking_Page != "") {$ReturnString .= "<a href='" . rtrim($Tracking_Page, "/") . "/?Tracking_Number=$Order->Order_Number&Order_Email=$Customer_Email'>";}
				$ReturnString .= $Order->Order_Number;
				if ($Tracking_Page != "") {$ReturnString .= "</a>";}
				$ReturnString .= "</td>";
			}
			if (in_array("Order_Name", $Order_Information)) {
				$ReturnString .= "<td>";
				$ReturnString .= $Order->Order_Name;
				$ReturnString .= "</td>";
			}
			if (in_array("Order_Notes", $Order_Information)) {
				$ReturnString .= "<td>";
				$ReturnString .= $Order->Order_Notes_Public;
				$ReturnString .= "</td>";
			}
			if (in_array("Customer_Name", $Order_Information)) {
				$CustomerName = $wpdb->get_var ($wpdb->prepare("SELECT Customer_Name FROM $EWD_OTP_customers WHERE Customer_ID=%d", $Order->Customer_ID));
				$ReturnString .= "<td>";
				$ReturnString .= $CustomerName;
				$ReturnString .= "</td>";
			}
			$Sql = "SELECT * FROM $EWD_OTP_fields_table_name WHERE Field_Function='Orders' ORDER BY Field_Order";
			$Custom_Fields = $wpdb->get_results($Sql);
			foreach ($Custom_Fields as $Custom_Field) {
				if (in_array($Custom_Field->Field_ID, $Order_Information)) {
					$MetaValue = $wpdb->get_row($wpdb->prepare("SELECT Meta_Value FROM $EWD_OTP_fields_meta_table_name WHERE Order_ID=%d AND Field_ID=%d", $Order->Order_ID, $Custom_Field->Field_ID));
					$ReturnString .= "<td>";
					if ($Custom_Field->Field_Type == "file") {
						$ReturnString .= "<a href='" . site_url("/wp-content/uploads/order-tracking-uploads/") . is_object( $MetaValue ) ? $MetaValue->Meta_Value : '404.jpg' . "' download>";
						$ReturnString .= $MetaValue->Meta_Value . "</a>";
					}
					elseif ($Custom_Field->Field_Type == "picture") {
						$ReturnString .= "<img src='" . site_url("/wp-content/uploads/order-tracking-uploads/") . is_object( $MetaValue ) ? $MetaValue->Meta_Value : '404.jpg' . "' />";
					}
					else {$ReturnString .= is_object( $MetaValue ) ? $MetaValue->Meta_Value : '';}
					$ReturnString .= "</td>";
				}
			}
			if (in_array("Order_Status", $Order_Information) or in_array("Order_Updated", $Order_Information)) {
				//foreach ($Statuses as $Status) {
				if (in_array("Order_Status", $Order_Information)) {
					$ReturnString .= "<td>";
					//$ReturnString .= $Status->Order_Status;
					$ReturnString .= $Status;
					$ReturnString .= "</td>";
				}
				if (in_array("Order_Updated", $Order_Information)) {
					$ReturnString .= "<td>";
					//$ReturnString .= $Status->Order_Status_Created;
					$ReturnString .= $Order->Order_Status_Updated;
					$ReturnString .= "</td>";
				}
				//}
			}
		}
		$ReturnString .= "</tr>";
	}
	$ReturnString .= "</table>";
	$ReturnString .= "<div class='ewd-otp-tracking-results pure-g'>";
	$Allow_Sales_Rep_Downloads = "";
	if ($Counter >= 50) {
		$ReturnString .= "<div class='pure-u-4-5'>";
		$ReturnString .= "<form action='#' method='post'>";
		$ReturnString .= "<input type='hidden' name='Sales_Rep_ID' value='" . $Sales_Rep_ID . "'>";
		$ReturnString .= "<input type='hidden' name='Sales_Rep_Email' value='" . $Sales_Rep_Email . "'>";
		$ReturnString .= "<input type='hidden' name='Page' value='" . ( $Page + 1 ) . "'>";
		$ReturnString .= "<input type='submit' name='Sales_Rep_Submit' value='Next Page'>";
		$ReturnString .= "</form>";
		$ReturnString .= "</div>";
	}
	if ($Allow_Sales_Rep_Downloads == "Yes") {
		$ReturnString .= "<div class='pure-u-4-5'>";
		$ReturnString .= "<form action='#' method='post'>";
		$ReturnString .= "<input type='hidden' name='Sales_Rep_ID' value='" . $Sales_Rep_ID . "'>";
		$ReturnString .= "<input type='hidden' name='Sales_Rep_Email' value='" . $Sales_Rep_Email . "'>";
		$ReturnString .= "</form>";
		$ReturnString .= "<button name='Sales_Rep_Download'>Download All Orders</button>";
		$ReturnString .= "</div>";
	}
		
	return $ReturnString;
}

function EWD_OTP_Insert_Payment_Form($Order) {
	$PayPal_Email_Address = get_option("EWD_OTP_PayPal_Email_Address"); 
	$Pricing_Currency_Code = get_option("EWD_OTP_Pricing_Currency_Code"); 
	$Thank_You_URL = get_option("EWD_OTP_Thank_You_URL"); 

	$ReturnString = "<div class='ewd-otp-paypal-form'>";
	$ReturnString .= "<form action='https://www.paypal.com/cgi-bin/webscr' method='post' class='standard-form'>";
	//$ReturnString .= "<form action='https://www.sandbox.paypal.com/cgi-bin/webscr' method='post' class='standard-form'>";
    $ReturnString .= "<input type='hidden' name='item_name_1' value='" . __("Order payment for order number ", 'order-tracking') . " " . $Order->Order_Number . "' />";
    $ReturnString .= "<input type='hidden' name='quantity_1' value='1' />";
    $ReturnString .= "<input type='hidden' name='amount_1' value='" . $Order->Order_Payment_Price . "' />";
	$ReturnString .= "<input type='hidden' name='custom' value='" . $Order->Order_ID . "' />";
   	$ReturnString .= "<input type='hidden' name='cmd' value='_cart' />";
   	$ReturnString .= "<input type='hidden' name='upload' value='1' />";
   	$ReturnString .= "<input type='hidden' name='business' value='" . $PayPal_Email_Address . "' />";

   	$ReturnString .= "<input type='hidden' name='currency_code' value='" . $Pricing_Currency_Code . "' />";
   	//$ReturnString .= "<input type='hidden' name='lc' value='CA' />"
   	//$ReturnString .= "<input type='hidden' name='rm' value='2' />";
   	$ReturnString .= "<input type='hidden' name='return' value='" . $Thank_You_URL . "' />";
   	//$ReturnString .= "<input type='hidden' name='cancel_return' value='" . ' />
   	$ReturnString .= "<input type='hidden' name='notify_url' value='" . get_site_url() . "' />";

   	$ReturnString .= "<input type='submit' class='submit-button' value='Proceed to Payment' />";
	$ReturnString .= "</form>";
	$ReturnString .= "</div>";
	return $ReturnString;
}
?>