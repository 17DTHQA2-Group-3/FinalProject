<?php
function Add_Edit_EWD_OTP_Order() {
	global $wpdb, $EWD_OTP_orders_table_name, $EWD_OTP_customers;

	if ( ! isset( $_POST['EWD_OTP_Admin_Nonce'] ) ) {return;}

    if ( ! wp_verify_nonce( $_POST['EWD_OTP_Admin_Nonce'], 'EWD_OTP_Admin_Nonce' ) ) {return;}
		
	$Order_Email = get_option("EWD_OTP_Order_Email");
	$Timezone = get_option("EWD_OTP_Timezone");
	date_default_timezone_set($Timezone);

	$Statuses_Array = get_option("EWD_OTP_Statuses_Array");
	if (!is_array($Statuses_Array)) {$Statuses_Array = array();}

	$Order_ID = isset( $_POST['Order_ID'] ) ? intval( $_POST['Order_ID'] ) : '';
	$Order_Name = isset( $_POST['Order_Name'] ) ? sanitize_text_field( $_POST['Order_Name'] ) : '';
	$Order_Number = isset( $_POST['Order_Number'] ) ? sanitize_text_field( $_POST['Order_Number'] ) : '';
	$Order_Status = isset( $_POST['Order_Status'] ) ? sanitize_text_field( $_POST['Order_Status'] ) : '';
	$Order_Location = isset( $_POST['Order_Location'] ) ? sanitize_text_field( $_POST['Order_Location'] ) : '';
	$Order_Notes_Public = isset( $_POST['Order_Notes_Public'] ) ? sanitize_text_field( $_POST['Order_Notes_Public'] ) : '';
	$Order_Notes_Private = isset( $_POST['Order_Notes_Private'] ) ? sanitize_text_field( $_POST['Order_Notes_Private'] ) : '';
	$Order_Email_Address = isset( $_POST['Order_Email'] ) ? sanitize_email( $_POST['Order_Email'] ) : '';
	$Order_Display = isset( $_POST['Order_Display'] ) ? sanitize_text_field( $_POST['Order_Display'] ) : '';
	$Customer_ID = isset( $_POST['Customer_ID'] ) ? intval( $_POST['Customer_ID'] ) : '';
	$Sales_Rep_ID = isset( $_POST['Sales_Rep_ID'] ) ? intval( $_POST['Sales_Rep_ID'] ) : '';
	$Order_Payment_Price = isset( $_POST['Order_Payment_Price'] ) ? sanitize_text_field( $_POST['Order_Payment_Price'] ) : '';
	$Order_Payment_Completed = isset( $_POST['Order_Payment_Completed'] ) ? sanitize_text_field( $_POST['Order_Payment_Completed'] ) : '';
	$Order_PayPal_Receipt_Number = isset( $_POST['Order_PayPal_Receipt_Number'] ) ? sanitize_text_field( $_POST['Order_PayPal_Receipt_Number'] ) : '';
	$Order_Status_Updated = date("Y-m-d H:i:s"); 
	
	if (isset($_POST['action']) and $_POST['action'] != "Add_Order") {
		$Order_Info = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE Order_ID=%d", $Order_ID));
		$Current_Status = $Order_Info->Order_Status;
	}

	$Order_External_Status = "";
	$Order_Internal_Status = "";
		
	foreach ($Statuses_Array as $Status_Array_Item) {
		if ($Order_Status == $Status_Array_Item['Status']) {
			if ($Status_Array_Item['Internal'] != "Yes") {
				$Order_External_Status = $Order_Status;
				$Order_Internal_Status = "No";
			}
			else {
				if (isset($Order_Info)) {$Order_External_Status = $Order_Info->Order_External_Status;}
				else {$Order_External_Status = "";}
				$Order_Internal_Status = "Yes";
			}
		}
	}

	if (!isset($error)) {
			// Pass the data to the appropriate function in Update_Admin_Databases.php to create the product 
			if (isset($_POST['action']) and $_POST['action'] == "Add_Order") {
				$user_update = Add_EWD_OTP_Order($Order_Name, $Order_Number, $Order_Email_Address, $Order_Status, $Order_External_Status, $Order_Location, $Order_Notes_Public, $Order_Notes_Private, $Order_Display, $Order_Status_Updated, $Customer_ID, $Sales_Rep_ID, $Order_Payment_Price, $Order_Payment_Completed, $Order_PayPal_Receipt_Number, $Order_Internal_Status);
				if (($Order_Email == "Change" or $Order_Email == "Creation") and $Order_Email_Address != "") {EWD_OTP_Send_Email($Order_Email_Address, $Order_Number, $Order_Status, $Order_Notes_Public, $Order_Status_Updated, $Order_Name, "Yes");}
			}
			// Pass the data to the appropriate function in Update_Admin_Databases.php to edit the product 
			else {
				$user_update = Edit_EWD_OTP_Order($Order_ID, $Order_Name, $Order_Number, $Order_Email_Address, $Order_Status, $Order_External_Status, $Order_Location, $Order_Notes_Public, $Order_Notes_Private, $Order_Display, $Order_Status_Updated, $Customer_ID, $Sales_Rep_ID, $Order_Payment_Price, $Order_Payment_Completed, $Order_PayPal_Receipt_Number, $Order_Internal_Status);
				if ($Order_Email == "Change" and $Order_Email_Address != "" and $Current_Status != $Order_Status and $Order_Internal_Status != "Yes") {EWD_OTP_Send_Email($Order_Email_Address, $Order_Number, $Order_Status, $Order_Notes_Public, $Order_Status_Updated, $Order_Name);}
			}
			$user_update = array("Message_Type" => "Update", "Message" => $user_update);
			return $user_update;
	}
	// Return any error that might have occurred 
	else {
			$output_error = array("Message_Type" => "Error", "Message" => $error);
			return $output_error;
	}
}

function EWD_OTP_Save_Customer_Note() {
	global $wpdb;
	global $EWD_OTP_orders_table_name;
	$Customer_Notes_Email = get_option("EWD_OTP_Customer_Notes_Email");
	$Admin_Email = get_option("EWD_OTP_Admin_Email");

	$Tracking_Number = sanitize_text_field( $_POST['CN_Order_Number'] );
	$Note = sanitize_text_field(stripslashes_deep($_POST['Customer_Notes']));

	$Order = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE Order_Number=%s", $Tracking_Number));

	if ($Customer_Notes_Email != "None" and $Order->Order_Customer_Notes != $Note) {
		EWD_OTP_Send_Email($Admin_Email, $Order->Order_Number, $Order->Order_Status, $Order->Order_Notes_Public, $Order->Order_Status_Updated, $Order->Order_Name, "No", $Customer_Notes_Email);
	}

	$user_update = Update_EWD_OTP_Customer_Note($Tracking_Number, $Note);

	return $user_update;
}

function EWD_OTP_Save_Customer_Order($Success_Message, $Order_Status = "", $Order_Location = "") {
	global $wpdb;
	global $EWD_OTP_orders_table_name, $EWD_OTP_customers;
	$Order_Email = get_option("EWD_OTP_Order_Email");
	
	$Customer_Order_Email = get_option("EWD_OTP_Customer_Order_Email");
	$Admin_Email = get_option("EWD_OTP_Admin_Email");

	$Order_Prefix = get_option("EWD_OTP_Customer_Order_Number_Prefix");
	$Order_Suffix = get_option("EWD_OTP_Customer_Order_Number_Suffix");

	$Allow_Sales_Rep_Selection = get_option("EWD_OTP_Allow_Sales_Rep_Selection");
	$Default_New_Order_Sales_Rep_ID = get_option("EWD_OTP_Default_Sales_Rep");
	$Assign_Order_Customer_Based_On_Email = get_option("EWD_OTP_Auto_Assign_Orders_To_Customers");

	$Order_Prefix = ($Order_Prefix != '' ? $Order_Prefix : __('Order', 'order-tracking'));

	$Timezone = get_option("EWD_OTP_Timezone");
	date_default_timezone_set($Timezone);

	$Order_Name = isset($_POST['Order_Name']) ? sanitize_text_field(stripslashes_deep($_POST['Order_Name'])) : '';
	$Order_Email_Address = isset($_POST['Order_Email_Address']) ? sanitize_text_field(stripslashes_deep($_POST['Order_Email_Address'])) : '';
	$Note = isset($_POST['Customer_Notes']) ? sanitize_text_field(stripslashes_deep($_POST['Customer_Notes'])) : '';

	$Order_Number = $Order_Prefix . EWD_OTP_RandomString(5) . $Order_Suffix;

	$Order_External_Status = $Order_Status;
	$Order_Internal_Status = "No";
	$Order_Notes_Public = "";
	$Order_Notes_Private = "";
	$Order_Display = "Yes";
	$Order_Status_Updated = date("Y-m-d H:i:s"); 

	$Order_Payment_Price = "";
	$Order_Payment_Completed = "No";
	$Order_PayPal_Receipt_Number = "";
	
	$WP_User = wp_get_current_user(); 
	if ($WP_User->ID != 0) {
		$Customer_ID = $wpdb->get_var($wpdb->prepare("SELECT Customer_ID FROM $EWD_OTP_customers WHERE Customer_WP_ID=%d", $WP_User->ID));
	}
	elseif (function_exists('FEUP_User')) {
		$FEUP_User = new FEUP_User();
		if ($FEUP_User->Is_Logged_In()) {
			$Customer_ID = $wpdb->get_var($wpdb->prepare("SELECT Customer_ID FROM $EWD_OTP_customers WHERE Customer_FEUP_ID=%d", $FEUP_User->Get_User_ID()));
		}
	}

	if ((!isset($Customer_ID) or $Customer_ID == "") and $Assign_Order_Customer_Based_On_Email) {
		$Customer_ID = $wpdb->get_var($wpdb->prepare("SELECT Customer_ID FROM $EWD_OTP_customers WHERE Customer_Email=%s", $Order_Email_Address));
	}
	
	if (!isset($Customer_ID) or $Customer_ID == "") {$Customer_ID = 0;} 

	if ($Customer_ID == 0) {$Sales_Rep_ID = 0;}
	else {$Sales_Rep_ID = $wpdb->get_var($wpdb->prepare("SELECT Sales_Rep_ID FROM $EWD_OTP_customers WHERE Customer_ID=%d", $Customer_ID));}

	if ($Sales_Rep_ID == 0 and $Allow_Sales_Rep_Selection) {
		$Sales_Rep_ID = isset($_POST['Sales_Rep']) ? intval($_POST['Sales_Rep']) : 0;
	}

	if ($Sales_Rep_ID == 0 and $Default_New_Order_Sales_Rep_ID) {
		$Sales_Rep_ID = $Default_New_Order_Sales_Rep_ID;
	}
	
	$message = Add_EWD_OTP_Order($Order_Name, $Order_Number, $Order_Email_Address, $Order_Status, $Order_External_Status, $Order_Location, $Order_Notes_Public, $Order_Notes_Private, $Order_Display, $Order_Status_Updated, $Customer_ID, $Sales_Rep_ID, $Order_Payment_Price, $Order_Payment_Completed, $Order_PayPal_Receipt_Number, $Order_Internal_Status);
	
	if ($message == __("Order has been successfully created.", 'order-tracking')) {
		if ($Customer_Order_Email != "None") {
			$Order = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE Order_Number=%s", $Order_Number));
			EWD_OTP_Send_Email($Admin_Email, $Order->Order_Number, $Order->Order_Status, $Order->Order_Notes_Public, $Order->Order_Status_Updated, $Order->Order_Name, "No", $Customer_Order_Email);
			if (($Order_Email == "Change" or $Order_Email == "Creation") and $Order_Email_Address != "") {EWD_OTP_Send_Email($Order_Email_Address, $Order_Number, $Order_Status, $Order_Notes_Public, $Order_Status_Updated, $Order_Name, "Yes");}
		}

		Update_EWD_OTP_Customer_Note($Order_Number, $Note);
		$user_update['Message_Type'] = "Update";
		$user_update['Message'] = $Success_Message . $Order_Number;
	}

	return $user_update;
}

function Add_Edit_EWD_OTP_Sales_Rep() {
	
	if ( ! isset( $_POST['EWD_OTP_Admin_Nonce'] ) ) {return;}

    if ( ! wp_verify_nonce( $_POST['EWD_OTP_Admin_Nonce'], 'EWD_OTP_Admin_Nonce' ) ) {return;}

	$Timezone = get_option("EWD_OTP_Timezone");
	date_default_timezone_set($Timezone);

	$Sales_Rep_ID = isset( $_POST['Sales_Rep_ID'] ) ? intval( $_POST['Sales_Rep_ID'] ) : "";
	$Sales_Rep_First_Name = isset( $_POST['Sales_Rep_First_Name'] ) ? sanitize_text_field( $_POST['Sales_Rep_First_Name'] ) : "";
	$Sales_Rep_Last_Name = isset( $_POST['Sales_Rep_Last_Name'] ) ? sanitize_text_field( $_POST['Sales_Rep_Last_Name'] ) : "";
	$Sales_Rep_Email = isset( $_POST['Sales_Rep_Email'] ) ? sanitize_email( $_POST['Sales_Rep_Email'] ) : "";
	$Sales_Rep_WP_ID = isset( $_POST['Sales_Rep_WP_ID'] ) ? intval( $_POST['Sales_Rep_WP_ID'] ) : "";
	$Sales_Rep_Created = date("Y-m-d H:i:s"); 

	if(!isset($_POST['action'])) { $_POST['action'] = "";}

	if (!isset($error)) {
			// Pass the data to the appropriate function in Update_Admin_Databases.php to create the product 
			if ($_POST['action'] == "Add_Sales_Rep") {
				  $user_update = Add_EWD_OTP_Sales_Rep($Sales_Rep_First_Name, $Sales_Rep_Last_Name, $Sales_Rep_Email, $Sales_Rep_WP_ID, $Sales_Rep_Created);
			}
			// Pass the data to the appropriate function in Update_Admin_Databases.php to edit the product 
			else {
					$user_update = Edit_EWD_OTP_Sales_Rep($Sales_Rep_ID, $Sales_Rep_First_Name, $Sales_Rep_Last_Name, $Sales_Rep_Email, $Sales_Rep_WP_ID);
			}
			$user_update = array("Message_Type" => "Update", "Message" => $user_update);
			return $user_update;
	}
	// Return any error that might have occurred 
	else {
			$output_error = array("Message_Type" => "Error", "Message" => $error);
			return $output_error;
	}
}

function Add_Edit_EWD_OTP_Customer() {
	
	if ( ! isset( $_POST['EWD_OTP_Admin_Nonce'] ) ) {return;}

    if ( ! wp_verify_nonce( $_POST['EWD_OTP_Admin_Nonce'], 'EWD_OTP_Admin_Nonce' ) ) {return;}

	$Timezone = get_option("EWD_OTP_Timezone");
	date_default_timezone_set($Timezone);

	$Customer_ID = isset( $_POST['Customer_ID'] ) ? intval( $_POST['Customer_ID'] ) : '';
	$Customer_Name = isset( $_POST['Customer_Name'] ) ? sanitize_text_field( $_POST['Customer_Name'] ) : '';
	$Customer_Email = isset( $_POST['Customer_Email'] ) ? sanitize_email( $_POST['Customer_Email'] ) : '';
	$Sales_Rep_ID = isset( $_POST['Sales_Rep_ID'] ) ? intval( $_POST['Sales_Rep_ID'] ) : '';
	$Customer_WP_ID = isset( $_POST['Customer_WP_ID'] ) ? intval( $_POST['Customer_WP_ID'] ) : '';
	$Customer_FEUP_ID = isset( $_POST['Customer_FEUP_ID'] ) ? intval( $_POST['Customer_FEUP_ID'] ) : '';
	$Customer_Created = date("Y-m-d H:i:s"); 

	if (!isset($_POST['action'])){ $_POST['action'] = '';}

	if (!isset($error)) {
			// Pass the data to the appropriate function in Update_Admin_Databases.php to create the product 
			if ($_POST['action'] == "Add_Customer") {
				  $user_update = Add_EWD_OTP_Customer($Customer_Name, $Customer_Email, $Sales_Rep_ID, $Customer_WP_ID, $Customer_FEUP_ID, $Customer_Created);
			}
			// Pass the data to the appropriate function in Update_Admin_Databases.php to edit the product 
			else {
					$user_update = Edit_EWD_OTP_Customer($Customer_ID, $Customer_Name, $Customer_Email, $Sales_Rep_ID, $Customer_WP_ID, $Customer_FEUP_ID);
			}
			$user_update = array("Message_Type" => "Update", "Message" => $user_update);
			return $user_update;
	}
	// Return any error that might have occurred 
	else {
			$output_error = array("Message_Type" => "Error", "Message" => $error);
			return $output_error;
	}
}

function EWD_OTP_Send_Email($Order_Email, $Order_Number, $Order_Status, $Order_Notes_Public, $Order_Status_Updated, $Order_Name, $Created = "No", $Message_Name = "") {
	global $wpdb, $EWD_OTP_orders_table_name, $EWD_OTP_customers, $EWD_OTP_fields_table_name, $EWD_OTP_fields_meta_table_name, $EWD_OTP_sales_reps;
		
	$Admin_Email = get_option("EWD_OTP_Admin_Email");
	$From_Name = get_option("EWD_OTP_From_Name");
	$Username = get_option("EWD_OTP_Username");
	$Port = get_option("EWD_OTP_Port");
	$Use_SMTP = get_option("EWD_OTP_Use_SMTP");
	$SMTP_Mail_Server = get_option("EWD_OTP_SMTP_Mail_Server");
	$Encryption_Type = get_option("EWD_OTP_Encryption_Type");
	$Message_Body = get_option("EWD_OTP_Message_Body");
    $Subject_Line = get_option("EWD_OTP_Subject_Line"); 
    $Tracking_Page = get_option("EWD_OTP_Tracking_Page");

    $Statuses_Array = get_option("EWD_OTP_Statuses_Array");
	$Email_Messages_Array = get_option("EWD_OTP_Email_Messages_Array");

	$Emails_Sent = get_option("EWD_OTP_Emails_Sent");
	$Current_Date = date("Y-m-d");

	$Order_Info = $wpdb->get_row($wpdb->prepare("SELECT Order_ID, Customer_ID, Sales_Rep_ID, Order_Customer_Notes FROM $EWD_OTP_orders_table_name WHERE Order_Number='%s'", $Order_Number));
	$Customer_Name = $wpdb->get_var($wpdb->prepare("SELECT Customer_Name FROM $EWD_OTP_customers WHERE Customer_ID='%d'", $Order_Info->Customer_ID));
	$Sales_Rep = $wpdb->get_row($wpdb->prepare("SELECT Sales_Rep_First_Name, Sales_Rep_Last_Name FROM $EWD_OTP_sales_reps WHERE Sales_Rep_ID='%d'", $Order_Info->Sales_Rep_ID));
	if (is_object($Sales_Rep)) {$Sales_Rep_Name = $Sales_Rep->Sales_Rep_First_Name . " " . $Sales_Rep->Sales_Rep_Last_Name;}
	else {$Sales_Rep_Name = "";}

	if ($Message_Name == "") {
		if (is_array($Statuses_Array)) {
			foreach ($Statuses_Array as $Status_Array_Item) {
				if ($Order_Status == $Status_Array_Item['Status']){$Message_Name = $Status_Array_Item['Message'];}
			}
		}
	}

	if ($Message_Name === 0) {return;}

	if ($Message_Name < 0) {
		$Params = array(
			'Email_ID' => $Message_Name * -1,
			'Email_Address' => $Order_Email,
			'order_id' => $Order_Info->Order_ID
		);

		EWD_URP_Send_Email_To_Non_User($Params);

		return;
	}

	if (is_array($Email_Messages_Array)) {
		foreach ($Email_Messages_Array as $Email_Array_Item) {
			if ($Message_Name == $Email_Array_Item['Name']) {$Message_Body = $Email_Array_Item['Message'];}
		}
	}
		
	$key = 'EWD_OTP';
	if ($Port == "") {$Port= '25';}
	if ($Encryption_Type == "") {$Encryption_Type = "ssl";}
	if ($From_Name == "") {$From_Name = $Admin_Email;}

	$Tracking_Link_Confirmation_Code = EWD_OTP_RandomString();
	$Tracking_Link = $Tracking_Page . "?Tracking_Number=" . $Order_Number . "&Order_Email=" . $Order_Email . "&TL_Code=" . $Tracking_Link_Confirmation_Code;

	$Message_Body = str_replace("[order-number]", $Order_Number, $Message_Body);
	$Message_Body = str_replace("[order-status]", $Order_Status, $Message_Body);
	$Message_Body = str_replace("[order-notes]", $Order_Notes_Public, $Message_Body);
	$Message_Body = str_replace("[customer-notes]", $Order_Info->Order_Customer_Notes, $Message_Body);
	$Message_Body = str_replace("[order-time]", $Order_Status_Updated, $Message_Body);
    $Message_Body = str_replace("[order-name]", $Order_Name, $Message_Body);
    $Message_Body = str_replace("[customer-id]", $Order_Info->Customer_ID, $Message_Body);
    $Message_Body = str_replace("[customer-name]", $Customer_Name, $Message_Body);
	$Message_Body = str_replace("[sales-rep]", $Sales_Rep_Name, $Message_Body);
	$Message_Body = str_replace("[tracking-link]", $Tracking_Link, $Message_Body, $Tracking_Link_Count);

	$Subject_Line = str_replace("[order-number]", $Order_Number, $Subject_Line);
	$Subject_Line = str_replace("[order-status]", $Order_Status, $Subject_Line);
	$Subject_Line = str_replace("[order-notes]", $Order_Notes_Public, $Subject_Line);
	$Subject_Line = str_replace("[customer-notes]", $Order_Info->Order_Customer_Notes, $Subject_Line);
	$Subject_Line = str_replace("[order-time]", $Order_Status_Updated, $Subject_Line);
    $Subject_Line = str_replace("[order-name]", $Order_Name, $Subject_Line);
    $Subject_Line = str_replace("[customer-id]", $Order_Info->Customer_ID, $Subject_Line);
    $Subject_Line = str_replace("[customer-name]", $Customer_Name, $Subject_Line);
	$Subject_Line = str_replace("[sales-rep]", $Sales_Rep_Name, $Subject_Line);
	$Subject_Line = str_replace("[tracking-link]", $Tracking_Link, $Subject_Line);

	if ($Tracking_Link_Count > 0) {$wpdb->query($wpdb->prepare("UPDATE $EWD_OTP_orders_table_name SET Order_Tracking_Link_Code=%s WHERE Order_ID=%d", $Tracking_Link_Confirmation_Code, $Order_Info->Order_ID));}
		
	$Order_Metas = $wpdb->get_results($wpdb->prepare("SELECT Field_ID, Meta_Value FROM $EWD_OTP_fields_meta_table_name WHERE Order_ID='%d'", $Order_Info->Order_ID));
	foreach ($Order_Metas as $Order_Meta) {
		$Field = $wpdb->get_row($wpdb->prepare("SELECT Field_Type, Field_Slug FROM $EWD_OTP_fields_table_name WHERE Field_ID='%d'", $Order_Meta->Field_ID));
		if ($Field->Field_Type == "file") {
			$upload_dir = wp_upload_dir();
			$File_Link = $upload_dir['baseurl'] . '/order-tracking-uploads/' . $Order_Meta->Meta_Value;
			$Message_Body = str_replace("[" . $Field->Field_Slug . "]", $File_Link, $Message_Body);
		}
		else {$Message_Body = str_replace("[" . $Field->Field_Slug . "]", $Order_Meta->Meta_Value, $Message_Body);}

	}

	$Emails = explode(",", $Order_Email);
	foreach ($Emails as $Email) {
    	$headers = array('Content-Type: text/html; charset=UTF-8');
		$Mail_Success = wp_mail($Email, $Subject_Line, $Message_Body, $headers);
		$Emails_Sent[$Current_Date]++;
	}

	update_option("EWD_OTP_Emails_Sent", $Emails_Sent);
}

/* Prepare the data to add multiple products from a spreadsheet */
function Add_Orders_From_Spreadsheet() {
		
		$Access_Role = get_option("EWD_OTP_Access_Role");

		// check that the current user has the correct privileges to create posts
    	if ( ! current_user_can( $Access_Role ) ) { return; }

    	// make sure that the request is coming from the admin form
    	if ( ! isset( $_POST['EWD_OTP_Import_Nonce'] ) ) { return; }
   		if ( ! wp_verify_nonce( $_POST['EWD_OTP_Import_Nonce'], 'EWD_OTP_Import' ) ) { return; }

		/* Test if there is an error with the uploaded spreadsheet and return that error if there is */
		if (!empty($_FILES['Orders_Spreadsheet']['error']))
		{
				switch($_FILES['Orders_Spreadsheet']['error'])
				{

				case '1':
						$error = __('The uploaded file exceeds the upload_max_filesize directive in php.ini', 'order-tracking');
						break;
				case '2':
						$error = __('The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form', 'order-tracking');
						break;
				case '3':
						$error = __('The uploaded file was only partially uploaded', 'order-tracking');
						break;
				case '4':
						$error = __('No file was uploaded.', 'order-tracking');
						break;

				case '6':
						$error = __('Missing a temporary folder', 'order-tracking');
						break;
				case '7':
						$error = __('Failed to write file to disk', 'order-tracking');
						break;
				case '8':
						$error = __('File upload stopped by extension', 'order-tracking');
						break;
				case '999':
						default:
						$error = __('No error code avaiable', 'order-tracking');
				}
		}
		/* Make sure that the file exists */ 	 	
		elseif (empty($_FILES['Orders_Spreadsheet']['tmp_name']) || $_FILES['Orders_Spreadsheet']['tmp_name'] == 'none') {
				$error = __('No file was uploaded here..', 'order-tracking');
		}
		/* Move the file and store the URL to pass it onwards*/   
        /* Check that it is a .xls or .xlsx file */
        if(!preg_match("/\.(xls.?)$/", $_FILES['Orders_Spreadsheet']['name']) and !preg_match("/\.(csv.?)$/", $_FILES['Orders_Spreadsheet']['name'])) {
            $error = __('File must be .csv, .xls or .xlsx', 'order-tracking');
        }
		/* Move the file and store the URL to pass it onwards*/ 	 	
		else {				 
				 	  $msg = $_FILES['Orders_Spreadsheet']['name'];
						//for security reason, we force to remove all uploaded file
						$target_path = ABSPATH . "wp-content/plugins/order-tracking/order-sheets/";
						//plugins_url("order-tracking/product-sheets/");

						$target_path = $target_path . basename( $_FILES['Orders_Spreadsheet']['name']); 

						if (!move_uploaded_file($_FILES['Orders_Spreadsheet']['tmp_name'], $target_path)) {
						//if (!$upload = wp_upload_bits($_FILES["Item_Image"]["name"], null, file_get_contents($_FILES["Item_Image"]["tmp_name"]))) {
				 			  $error .= "There was an error uploading the file, please try again!";
						}
						else {
				 				$Excel_File_Name = basename( $_FILES['Orders_Spreadsheet']['name']);
						}	
		}

		/* Pass the data to the appropriate function in Update_Admin_Databases.php to create the products */
		if (!isset($error)) {
				$user_update = Add_EWD_OTP_Orders_From_Spreadsheet($Excel_File_Name);
				return $user_update;
		}
		else {
				$output_error = array("Message_Type" => "Error", "Message" => $error);
				return $output_error;
		}
}

function Mass_EWD_OTP_Action() {
		if (isset($_POST['action'])) {
				switch ($_POST['action']) {
						case "hide":
        				$message = Mass_Hide_EWD_OTP_Orders();
								break;
						case "delete":
        				$message = Mass_Delete_EWD_OTP_Orders();
								break;
						case "-1":
								break;
						default:
								$message = Mass_Status_EWD_OTP_Orders();
								break;
				}
		}
}

function Mass_Delete_EWD_OTP_Orders() {
	$Orders = $_POST['Orders_Bulk'];
		
	if (is_array($Orders)) {
		foreach ($Orders as $Order) {
			if ($Order != "") {
				Delete_EWD_OTP_Order( intval( $Order ) );
			}
		}
	}
		
	$update = __("Orders have been successfully deleted.", 'order-tracking');
	$user_update = array("Message_Type" => "Update", "Message" => $update);
	
	return $user_update;
}

function Mass_Delete_EWD_OTP_Sales_Reps() {
	$SalesReps = $_POST['Reps_Bulk'];
		
	if (is_array($SalesReps)) {
		foreach ($SalesReps as $SalesRep) {
			if ($SalesRep != "") {
				Delete_EWD_OTP_Sales_Rep( intval( $SalesRep ) );
			}
		}
	}
		
	$update = __("Sales Reps have been successfully deleted.", 'order-tracking');
	$user_update = array("Message_Type" => "Update", "Message" => $update);
	
	return $user_update;
}

function Mass_Delete_EWD_OTP_Customers() {
	$Customers = $_POST['Customers_Bulk'];
		
	if (is_array($Customers)) {
		foreach ($Customers as $Customer) {
			if ($Customer != "") {
				Delete_EWD_OTP_Customer( intval( $Customer ) );
			}
		}
	}
		
	$update = __("Customers have been successfully deleted.", 'order-tracking');
	$user_update = array("Message_Type" => "Update", "Message" => $update);
	
	return $user_update;
}

function Mass_Hide_EWD_OTP_Orders() {
	$Orders = $_POST['Orders_Bulk'];
		
	if (is_array($Orders)) {
		foreach ($Orders as $Order) {
			if ($Order != "") {
				Hide_EWD_OTP_Order( intval( $Order ) );
			}
		}
	}
		
	$update = __("Orders have been successfully hidden.", 'order-tracking');
	$user_update = array("Message_Type" => "Update", "Message" => $update);
	
	return $user_update;
}

function Mass_Status_EWD_OTP_Orders() {
	global $wpdb, $EWD_OTP_orders_table_name;
	$Order_Email = get_option("EWD_OTP_Order_Email");
		
	$Timezone = get_option("EWD_OTP_Timezone");
	date_default_timezone_set($Timezone);

	$Statuses_Array = get_option("EWD_OTP_Statuses_Array");
	if (!is_array($Statuses_Array)) {$Statuses_Array = array();}
		
	$Orders = $_POST['Orders_Bulk'];
	$Status = sanitize_text_field( $_POST['action'] );
	$Update_Time = date("Y-m-d H:i:s");
		
	if (is_array($Orders)) {
		foreach ($Orders as $Order) {
			if ($Order != "") {
				$Order_Info = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $EWD_OTP_orders_table_name WHERE Order_ID='%d'", intval( $Order ) ) );

				foreach ($Statuses_Array as $Status_Array_Item) {
					if ($Status == $Status_Array_Item['Status']) {
						if ($Status_Array_Item['Internal'] != "Yes") {
							$Order_External_Status = $Status;
							$Order_Internal_Status = "No";
						}
						else {
							$Order_External_Status = $Order_Info->Order_External_Status;
							$Order_Internal_Status = "Yes";
						}
					}
				}

				Update_EWD_OTP_Order_Status($Order, $Status, $Update_Time, $Order_Internal_Status, $Order_External_Status);
				if ($Order_Email == "Change" and $Order_Info->Order_Email != "" and $Order_Internal_Status != "Yes") {EWD_OTP_Send_Email($Order_Info->Order_Email, $Order_Info->Order_Number, $Status, $Order_Info->Order_Notes_Public, $Order_Info->Order_Status_Updated, $Order_Info->Order_Name);}
			}
		}
	}
		
	$update = __("Orders have been successfully updated.", 'order-tracking');
	$user_update = array("Message_Type" => "Update", "Message" => $update);
	
	return $user_update;
}

function EWD_OTP_Front_End_Status_Update() {
		global $wpdb, $EWD_OTP_orders_table_name, $EWD_OTP_sales_reps;
		global $user_message;

		$Order_Email = get_option("EWD_OTP_Order_Email");
		
		$Timezone = get_option("EWD_OTP_Timezone");
		date_default_timezone_set($Timezone);

		$Access_Role = get_option("EWD_OTP_Access_Role");
		$Current_User = wp_get_current_user();

		$Statuses_Array = get_option("EWD_OTP_Statuses_Array");
		if (!is_array($Statuses_Array)) {$Statuses_Array = array();}

		$Order_ID = intval( $_POST['Order_ID'] );
		$Order = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE Order_ID=%d", $Order_ID));
		$Sales_Rep = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_sales_reps WHERE Sales_Rep_ID=%d", $Order->Sales_Rep_ID));

		if ($Current_User->ID == 0 or (!user_can($Current_User, $Access_Role) and $Sales_Rep->Sales_Rep_WP_ID != $Current_User->ID)) {return;}
		
		$Status = sanitize_text_field( $_POST['Order_Status'] );
		$Order_Location = isset($_POST['Order_Location']) ? sanitize_text_field( $_POST['Order_Location'] ) : '';
		$Update_Time = date("Y-m-d H:i:s");
		
		if (isset($Order->Order_ID)) {
			$Order_Info = $wpdb->get_row($wpdb->prepare("SELECT * FROM $EWD_OTP_orders_table_name WHERE Order_ID='%d'", $Order_ID));
			
			foreach ($Statuses_Array as $Status_Array_Item) {
				if ($Status == $Status_Array_Item['Status']) {
					if ($Status_Array_Item['Internal'] != "Yes") {
						$Order_External_Status = $Status;
						$Order_Internal_Status = "No";
					}
					else {
						$Order_External_Status = $Order_Info->Order_External_Status;
						$Order_Internal_Status = "Yes";
					}
				}
			}

			Update_EWD_OTP_Order_Status($Order->Order_ID, $Status, $Update_Time, $Order_Internal_Status, $Order_External_Status, $Order_Location);
			if ($Order_Email == "Change" and $Order_Info->Order_Email != "" and $Order_Internal_Status != "Yes") {EWD_OTP_Send_Email($Order_Info->Order_Email, $Order_Info->Order_Number, $Order_Info->Order_Status, $Order_Info->Order_Notes_Public, $Order_Info->Order_Status_Updated, $Order_Info->Order_Name);}
		}
		
		$user_message = __("Order has been successfully updated.<br/>", 'order-tracking');
		return;
}

function Add_Edit_EWD_OTP_Custom_Field() {
	if ( ! isset( $_POST['EWD_OTP_Admin_Nonce'] ) ) {return;}

    if ( ! wp_verify_nonce( $_POST['EWD_OTP_Admin_Nonce'], 'EWD_OTP_Admin_Nonce' ) ) {return;}
    	
	/* Process the $_POST data where neccessary before storage */
	$Field_Name = isset( $_POST['Field_Name'] ) ? sanitize_text_field( $_POST['Field_Name'] ) : '';
	$Field_Slug = isset( $_POST['Field_Slug'] ) ? sanitize_text_field( $_POST['Field_Slug'] ) : '';
	$Field_Type = isset( $_POST['Field_Type'] ) ? sanitize_text_field( $_POST['Field_Type'] ) : '';
	$Field_Description = isset( $_POST['Field_Description'] ) ? sanitize_text_field( $_POST['Field_Description'] ) : '';
	$Field_Values = isset( $_POST['Field_Values'] ) ? sanitize_text_field( $_POST['Field_Values'] ) : '';
	$Field_Front_End_Display = isset( $_POST['Field_Front_End_Display'] ) ? sanitize_text_field( $_POST['Field_Front_End_Display'] ) : '';
	$Field_Required = isset( $_POST['Field_Required'] ) ? sanitize_text_field( $_POST['Field_Required'] ) : '';
	$Field_Equivalent = isset( $_POST['Field_Equivalent'] ) ? sanitize_text_field( $_POST['Field_Equivalent'] ) : '';
	$Field_Function = isset( $_POST['Field_Function'] ) ? sanitize_text_field( $_POST['Field_Function'] ) : '';
	$Field_Display = isset( $_POST['Field_Display'] ) ? sanitize_text_field( $_POST['Field_Display'] ) : 'No';
	$Field_ID = isset( $_POST['Field_ID'] ) ? intval( $_POST['Field_ID'] ) : '';

	if(!isset($_POST['action'])) { $_POST['action'] = '';}
	
	if (!isset($error)) {
		/* Pass the data to the appropriate function in Update_Admin_Databases.php to create the custom field */
		if ($_POST['action'] == "Add_Custom_Field") {
			$user_update = Add_EWD_OTP_Custom_Field($Field_Name, $Field_Slug, $Field_Type, $Field_Description, $Field_Values, $Field_Front_End_Display, $Field_Required, $Field_Equivalent, $Field_Function, $Field_Display);
		}
		/* Pass the data to the appropriate function in Update_Admin_Databases.php to edit the custom field */
		else {
			$user_update = Edit_EWD_OTP_Custom_Field($Field_ID, $Field_Name, $Field_Slug, $Field_Type, $Field_Description, $Field_Values, $Field_Front_End_Display, $Field_Required, $Field_Equivalent, $Field_Function, $Field_Display);
		}

		$user_update = array("Message_Type" => "Update", "Message" => $user_update);
		
		return $user_update;
	}
	else {
		$output_error = array("Message_Type" => "Error", "Message" => $error);
		
		return $output_error;
	}
}

function Mass_Delete_EWD_OTP_Custom_Fields() {
	$Fields = $_POST['Fields_Bulk'];
		
	if (is_array($Fields)) {
		foreach ($Fields as $Field) {
			if ($Field != "") {
				Delete_EWD_OTP_Custom_Field( intval( $Field ) );
			}
		}
	}
		
	$update = __("Field(s) have been successfully deleted.", 'UPCP');
	$user_update = array("Message_Type" => "Update", "Message" => $update);
	
	return $user_update;
}

function EWD_OTP_Handle_File_Upload($Field_Name) {
		
	/* Test if there is an error with the uploaded file and return that error if there is */
	if (isset($_POST['Customer_Order_Submit'])) {
		if ( ! function_exists( 'wp_handle_upload' ) ) {
		    require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}

		$User_Upload_File_Name = wp_handle_upload($_FILES[$Field_Name], array('test_form' => false));
		if ($User_Upload_File_Name && !isset($User_Upload_File_Name['error'])) {
			$Return['Success'] = "Yes";
			$Return['Data'] = $User_Upload_File_Name['url'];
		}
		else {
			$Return['Success'] = "No";
			$Return['Data'] = $User_Upload_File_Name['error'];
		}

		return $Return;
	}
	elseif (!empty($_FILES[$Field_Name]['error']))
	{
		switch($_FILES[$Field_Name]['error'])
		{

			case '1':
					$error = __('The uploaded file exceeds the upload_max_filesize directive in php.ini', 'order-tracking');
					break;
			case '2':
					$error = __('The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form', 'order-tracking');
					break;
			case '3':
					$error = __('The uploaded file was only partially uploaded', 'order-tracking');
					break;
			case '4':
					$error = __('No file was uploaded.', 'order-tracking');
					break;

			case '6':
					$error = __('Missing a temporary folder', 'order-tracking');
					break;
			case '7':
					$error = __('Failed to write file to disk', 'order-tracking');
					break;
			case '8':
					$error = __('File upload stopped by extension', 'order-tracking');
					break;
			case '999':
					default:
					$error = __('No error code avaiable', 'order-tracking');
		}
	}
	/* Make sure that the file exists */ 	 	
	elseif (empty($_FILES[$Field_Name]['tmp_name']) || $_FILES[$Field_Name]['tmp_name'] == 'none') {
			$error = __('No file was uploaded here..', 'order-tracking');
	}
	/* Move the file and store the URL to pass it onwards*/ 	 	
	else {				 
		$msg = $_FILES[$Field_Name]['name'];
		//for security reason, we force to remove all uploaded file
		$upload_dir = wp_upload_dir();
		$target_path = $upload_dir['basedir'] . '/order-tracking-uploads/';
						
		//create the uploads directory if it doesn't exist
		if (!file_exists($target_path)) {
			  mkdir($target_path, 0777, true);
		}

		$target_path = $target_path . basename( $_FILES[$Field_Name]['name']); 

		if (!move_uploaded_file($_FILES[$Field_Name]['tmp_name'], $target_path)) {
		//if (!$upload = wp_upload_bits($_FILES["Item_Image"]["name"], null, file_get_contents($_FILES["Item_Image"]["tmp_name"]))) {
				  $error .= "There was an error uploading the file, please try again!";
		}
		else {
					$User_Upload_File_Name = basename( $_FILES[$Field_Name]['name']);
		}	
	}
		
	/* Return the file name, or the error that was generated. */
	if (isset($error) and $error == __('No file was uploaded.', 'order-tracking')) {
		$Return['Success'] = "N/A";
		$Return['Data'] = __('No file was uploaded.', 'order-tracking');
	}
	elseif (!isset($error)) {
		$Return['Success'] = "Yes";
		$Return['Data'] = $User_Upload_File_Name;
	}
	else {
		$Return['Success'] = "No";
		$Return['Data'] = $error;
	}
	
	return $Return;
}

function EWD_OTP_Delete_All_Orders() {
		global $wpdb;
		global $EWD_OTP_orders_table_name;
		$Orders = $wpdb->get_results("SELECT Order_ID FROM $EWD_OTP_orders_table_name");
		
		if (is_array($Orders)) {
				foreach ($Orders as $Order) {
						if ($Order->Order_ID != "") {
								Delete_EWD_OTP_Order($Order->Order_ID);
						}
				}
		}
		
		$update = __("Orders have been successfully deleted.", 'order-tracking');
		$user_update = array("Message_Type" => "Update", "Message" => $update);
		return $user_update;
}

function EWD_OTP_RandomString($CharLength = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < $CharLength; $i++) {
        $randstring .= $characters[rand(0, strlen($characters))];
    }
    return $randstring;
}

?>
