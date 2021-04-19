<?php
	$Custom_CSS = get_option("EWD_OTP_Custom_CSS");
	$AJAX_Reload = get_option("EWD_OTP_AJAX_Reload");
	$New_Window = get_option("EWD_OTP_New_Window");
	$Order_Information = get_option("EWD_OTP_Order_Information");
	if (!is_array($Order_Information)) {$Order_Information = array();}
	$Hide_Blank_Fields = get_option("EWD_OTP_Hide_Blank_Fields");
	$Form_Instructions = get_option("EWD_OTP_Form_Instructions");
	$Email_Confirmation = get_option("EWD_OTP_Email_Confirmation");
	$Timezone = get_option("EWD_OTP_Timezone");
	$Localize_Date_Time = get_option("EWD_OTP_Localize_Date_Time");
	$Display_Print_Button = get_option("EWD_OTP_Display_Print_Button");
	$Order_Email = get_option("EWD_OTP_Order_Email");
	$Statistics_Days = get_option("EWD_OTP_Statistics_Days");
	$Show_TinyMCE = get_option("EWD_OTP_Show_TinyMCE");

	$Access_Role = get_option("EWD_OTP_Access_Role");
	$WooCommerce_Integration = get_option("EWD_OTP_WooCommerce_Integration");
	$WooCommerce_Prefix = get_option("EWD_OTP_WooCommerce_Prefix");
	$WooCommerce_Random_Suffix = get_option("EWD_OTP_WooCommerce_Random_Suffix");
	$WooCommerce_Show_On_Order_Page = get_option("EWD_OTP_WooCommerce_Show_On_Order_Page");
	$Enabled_Locations_For_WooCommerce = get_option("EWD_OTP_Enabled_Locations_For_WooCommerce");
	$Replace_WooCommerce_Statuses = get_option("EWD_OTP_Replace_WooCommerce_Statuses");
	$WooCommerce_Revert_Statuses = get_option("EWD_OTP_WooCommerce_Revert_Statuses");
	$WooCommerce_Paid_Order_Status = get_option("EWD_OTP_WooCommerce_Paid_Order_Status");
	$WooCommerce_Unpaid_Order_Status = get_option("EWD_OTP_WooCommerce_Unpaid_Order_Status");
	$WooCommerce_Processing_Order_Status = get_option("EWD_OTP_WooCommerce_Processing_Order_Status");
	$WooCommerce_Cancelled_Order_Status = get_option("EWD_OTP_WooCommerce_Cancelled_Order_Status");
	$WooCommerce_OnHold_Order_Status = get_option("EWD_OTP_WooCommerce_OnHold_Order_Status");
	$WooCommerce_Failed_Order_Status = get_option("EWD_OTP_WooCommerce_Failed_Order_Status");
	$WooCommerce_Refunded_Order_Status = get_option("EWD_OTP_WooCommerce_Refunded_Order_Status");
	$Display_Graphic = get_option("EWD_OTP_Display_Graphic");
	$Mobile_Stylesheet = get_option("EWD_OTP_Mobile_Stylesheet");
	$Customer_Notes_Email = get_option("EWD_OTP_Customer_Notes_Email");
	$Customer_Order_Email = get_option("EWD_OTP_Customer_Order_Email");
	$Allow_Customer_Downloads = get_option("EWD_OTP_Allow_Customer_Downloads");
	$Allow_Sales_Rep_Downloads = get_option("EWD_OTP_Allow_Sales_Rep_Downloads");
	$Allow_Sales_Rep_Selection = get_option("EWD_OTP_Allow_Sales_Rep_Selection");
	$Auto_Assign_Orders_To_Customers = get_option("EWD_OTP_Auto_Assign_Orders_To_Customers");
	$Customer_Order_Number_Prefix = get_option("EWD_OTP_Customer_Order_Number_Prefix");
	$Customer_Order_Number_Suffix = get_option("EWD_OTP_Customer_Order_Number_Suffix");
	$Default_Sales_Rep = get_option("EWD_OTP_Default_Sales_Rep");

	$Allow_Order_Payments = get_option("EWD_OTP_Allow_Order_Payments");
	$Default_Payment_Status = get_option("EWD_OTP_Default_Payment_Status");
	$PayPal_Email_Address = get_option("EWD_OTP_PayPal_Email_Address");
	$Pricing_Currency_Code = get_option("EWD_OTP_Pricing_Currency_Code");
	$Thank_You_URL = get_option("EWD_OTP_Thank_You_URL");

	$Zendesk_Integration = get_option("EWD_OTP_Zendesk_Integration");
	$Zendesk_API_Key = get_option("EWD_OTP_Zendesk_API_Key");

	$Tracking_Title_Label = get_option("EWD_OTP_Tracking_Title_Label");
	$Tracking_Ordernumber_Label = get_option("EWD_OTP_Tracking_Ordernumber_Label");
	$Tracking_Ordernumber_Placeholder_Label = get_option("EWD_OTP_Tracking_Ordernumber_Placeholder_Label");
	$Tracking_Email_Label = get_option("EWD_OTP_Tracking_Email_Label");
	$Tracking_Email_Placeholder_Label = get_option("EWD_OTP_Tracking_Email_Placeholder_Label");
	$Tracking_Button_Label = get_option("EWD_OTP_Tracking_Button_Label");
	$Retrieving_Results_Label = get_option("EWD_OTP_Retrieving_Results_Label");
	$Customer_Form_Title_Label = get_option("EWD_OTP_Customer_Form_Title_Label");
	$Customer_Form_Description_Label = get_option("EWD_OTP_Customer_Form_Description_Label");
	$Customer_Form_Number_Label = get_option("EWD_OTP_Customer_Form_Number_Label");
	$Customer_Form_Number_Placeholder_Label = get_option("EWD_OTP_Customer_Form_Number_Placeholder_Label");
	$Customer_Form_Email_Label = get_option("EWD_OTP_Customer_Form_Email_Label");
	$Customer_Form_Email_Placeholder_Label = get_option("EWD_OTP_Customer_Form_Email_Placeholder_Label");
	$Customer_Form_Button_Label = get_option("EWD_OTP_Customer_Form_Button_Label");
	$Sales_Rep_Form_Title_Label = get_option("EWD_OTP_Sales_Rep_Form_Title_Label");
	$Sales_Rep_Form_Description_Label = get_option("EWD_OTP_Sales_Rep_Form_Description_Label");
	$Sales_Rep_Form_Number_Label = get_option("EWD_OTP_Sales_Rep_Form_Number_Label");
	$Sales_Rep_Form_Number_Placeholder_Label = get_option("EWD_OTP_Sales_Rep_Form_Number_Placeholder_Label");
	$Sales_Rep_Form_Email_Label = get_option("EWD_OTP_Sales_Rep_Form_Email_Label");
	$Sales_Rep_Form_Email_Placeholder_Label = get_option("EWD_OTP_Sales_Rep_Form_Email_Placeholder_Label");
	$Sales_Rep_Form_Button_Label = get_option("EWD_OTP_Sales_Rep_Form_Button_Label");
	$Order_Information_Label = get_option("EWD_OTP_Order_Information_Label");
	$Order_Number_Label = get_option("EWD_OTP_Order_Number_Label");
	$Order_Name_Label = get_option("EWD_OTP_Order_Name_Label");
	$Order_Notes_Label = get_option("EWD_OTP_Order_Notes_Label");
	$Customer_Notes_Label = get_option("EWD_OTP_Customer_Notes_Label");
	$Order_Status_Label = get_option("EWD_OTP_Order_Status_Label");
	$Order_Location_Label = get_option("EWD_OTP_Order_Location_Label");
	$Order_Updated_Label = get_option("EWD_OTP_Order_Updated_Label");
	$Order_Current_Location_Label = get_option("EWD_OTP_Order_Current_Location_Label");
	$Order_Print_Button_Label = get_option("EWD_OTP_Order_Print_Button_Label");
	$Order_Add_Note_Button_Label = get_option("EWD_OTP_Order_Add_Note_Button_Label");
	$Order_Update_Status_Button_Label = get_option("EWD_OTP_Order_Update_Status_Button_Label");
	$Customer_Display_Name_Label = get_option("EWD_OTP_Customer_Display_Name_Label");
	$Customer_Display_Email_Label = get_option("EWD_OTP_Customer_Display_Email_Label");
	$Customer_Display_Download_Label = get_option("EWD_OTP_Customer_Display_Download_Label");
	$Sales_Rep_Display_First_Name_Label = get_option("EWD_OTP_Sales_Rep_Display_First_Name_Label");
	$Sales_Rep_Display_Last_Name_Label = get_option("EWD_OTP_Sales_Rep_Display_Last_Name_Label");
	$Customer_Order_Name_Label = get_option("EWD_OTP_Customer_Order_Name_Label");
	$Customer_Order_Email_Label = get_option("EWD_OTP_Customer_Order_Email_Label");
	$Customer_Order_Notes_Label = get_option("EWD_OTP_Customer_Order_Notes_Label");
	$Customer_Order_Button_Label = get_option("EWD_OTP_Customer_Order_Button_Label");
	$Customer_Order_Thank_You_Label = get_option("EWD_OTP_Customer_Order_Thank_You_Label");
	$Customer_Order_Email_Instructions_Label = get_option("EWD_OTP_Customer_Order_Email_Instructions_Label");

	$OTP_Styling_Title_Font = get_option("EWD_OTP_Styling_Title_Font");
	$OTP_Styling_Title_Font_Size = get_option("EWD_OTP_Styling_Title_Font_Size");
	$OTP_Styling_Title_Font_Color = get_option("EWD_OTP_Styling_Title_Font_Color");
	$OTP_Styling_Label_Font = get_option("EWD_OTP_Styling_Label_Font");
	$OTP_Styling_Label_Font_Size = get_option("EWD_OTP_Styling_Label_Font_Size");
	$OTP_Styling_Label_Font_Color = get_option("EWD_OTP_Styling_Label_Font_Color");
	$OTP_Styling_Content_Font = get_option("EWD_OTP_Styling_Content_Font");
	$OTP_Styling_Content_Font_Size = get_option("EWD_OTP_Styling_Content_Font_Size");
	$OTP_Styling_Content_Font_Color = get_option("EWD_OTP_Styling_Content_Font_Color");
	$OTP_Styling_Title_Margin = get_option("EWD_OTP_Styling_Title_Margin");
	$OTP_Styling_Title_Padding = get_option("EWD_OTP_Styling_Title_Padding");
	$OTP_Styling_Body_Margin = get_option("EWD_OTP_Styling_Body_Margin");
	$OTP_Styling_Body_Padding = get_option("EWD_OTP_Styling_Body_Padding");
	$OTP_Styling_Button_Font_Color = get_option("EWD_OTP_Styling_Button_Font_Color");
	$OTP_Styling_Button_Bg_Color = get_option("EWD_OTP_Styling_Button_Bg_Color");
	$OTP_Styling_Button_Border = get_option("EWD_OTP_Styling_Button_Border");
	$OTP_Styling_Button_Margin = get_option("EWD_OTP_Styling_Button_Margin");
	$OTP_Styling_Button_Padding = get_option("EWD_OTP_Styling_Button_Padding");

	$Email_Messages_Array = get_option("EWD_OTP_Email_Messages_Array");
	if (!is_array($Email_Messages_Array)) {$Email_Messages_Array = array();}

	if (isset($_POST['Display_Tab'])) {$Display_Tab = sanitize_text_field( $_POST['Display_Tab'] );}
	else {$Display_Tab = "";}
?>

<div class="wrap otp-options-page-tabbed">
<div class="otp-options-submenu-div">
	<ul class="otp-options-submenu otp-options-page-tabbed-nav">
		<li><a id="Basic_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == '' or $Display_Tab == 'Basic') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('Basic');">Basic</a></li>
		<li><a id="Premium_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == 'Premium') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('Premium');">Premium</a></li>
		<li><a id="Payment_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == 'Payment') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('Payment');">Payment</a></li>
		<li><a id="Woocommerce_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == 'Woocommerce') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('Woocommerce');">WooCommerce</a></li>
		<li><a id="Zendesk_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == 'Zendesk') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('Zendesk');">Zendesk</a></li>
		<li><a id="Labelling_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == 'Labelling') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('Labelling');">Labelling</a></li>
		<li><a id="Styling_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == 'Styling') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('Styling');">Styling</a></li>
	</ul>
</div>

<div class="otp-options-page-tabbed-content">

<form method="post" action="admin.php?page=EWD-OTP-options&DisplayPage=Options&OTPAction=EWD_OTP_UpdateOptions">
<?php wp_nonce_field('EWD_OTP_Admin_Nonce', 'EWD_OTP_Admin_Nonce'); ?>

<input type='hidden' name='Display_Tab' value='<?php echo esc_attr( $Display_Tab ); ?>' />

<div id='Basic' class='otp-option-set<?php echo ( ($Display_Tab == '' or $Display_Tab == 'Basic') ? '' : ' otp-hidden' ); ?>'>

<br />

<div class="ewd-otp-admin-section-heading"><?php _e('Basic Options', 'order-tracking'); ?></div>

<table class="form-table">
<tr>
<th scope="row">Custom CSS</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Custom CSS</span></legend>
	<label title='Custom CSS'></label><textarea class='ewd-otp-textarea' name='custom_css'> <?php echo $Custom_CSS; ?></textarea><br />
	<p>You can add custom CSS styles for your order form in the box above.</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Order Information Displayed</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Order Information Displayed</span></legend>
	<label title='Order Number' class='ewd-otp-admin-input-container'><input type='checkbox' name='order_information[]' value='Order_Number' <?php if(in_array("Order_Number", $Order_Information)) {echo "checked='checked'";} ?> /><span class='ewd-otp-admin-checkbox'></span> <span>Order Number</span></label><br />
	<label title='Name' class='ewd-otp-admin-input-container'><input type='checkbox' name='order_information[]' value='Order_Name' <?php if(in_array("Order_Name", $Order_Information)) {echo "checked='checked'";} ?> /><span class='ewd-otp-admin-checkbox'></span> <span>Name</span></label><br />
	<label title='Status' class='ewd-otp-admin-input-container'><input type='checkbox' name='order_information[]' value='Order_Status' <?php if(in_array("Order_Status", $Order_Information)) {echo "checked='checked'";} ?> /><span class='ewd-otp-admin-checkbox'></span> <span>Status</span></label><br />
	<label title='Location' class='ewd-otp-admin-input-container'><input type='checkbox' name='order_information[]' value='Order_Location' <?php if(in_array("Order_Location", $Order_Information)) {echo "checked='checked'";} ?> /><span class='ewd-otp-admin-checkbox'></span> <span>Location</span></label><br />
	<label title='Update Date' class='ewd-otp-admin-input-container'><input type='checkbox' name='order_information[]' value='Order_Updated' <?php if(in_array("Order_Updated", $Order_Information)) {echo "checked='checked'";} ?> /><span class='ewd-otp-admin-checkbox'></span> <span>Updated Date</span></label><br />
	<label title='Notes' class='ewd-otp-admin-input-container'><input type='checkbox' name='order_information[]' value='Order_Notes' <?php if(in_array("Order_Notes", $Order_Information)) {echo "checked='checked'";} ?> /><span class='ewd-otp-admin-checkbox'></span> <span>Notes</span></label><br />
	<label title='Customer_Notes' class='ewd-otp-admin-input-container'><input type='checkbox' name='order_information[]' value='Customer_Notes' <?php if(in_array("Customer_Notes", $Order_Information)) {echo "checked='checked'";} ?> /><span class='ewd-otp-admin-checkbox'></span> <span>Customer Notes</span></label><br />
	<label title='Graphic' class='ewd-otp-admin-input-container'><input type='checkbox' name='order_information[]' value='Order_Graphic' <?php if(in_array("Order_Graphic", $Order_Information)) {echo "checked='checked'";} ?> /><span class='ewd-otp-admin-checkbox'></span> <span>Status Graphic</span></label><br />
	<label title='Map' class='ewd-otp-admin-input-container'><input type='checkbox' name='order_information[]' value='Order_Map' <?php if(in_array("Order_Map", $Order_Information)) {echo "checked='checked'";} ?> /><span class='ewd-otp-admin-checkbox'></span> <span>Tracking Map</span></label><br />
	<?php
		$Sql = "SELECT * FROM $EWD_OTP_fields_table_name WHERE Field_Function='Orders' ORDER BY Field_Order";
		$Fields = $wpdb->get_results($Sql);
		foreach ($Fields as $Field) {
			echo "<label title='" . $Field->Field_ID . "' class='ewd-otp-admin-input-container'><input type='checkbox' name='order_information[]' value='" . $Field->Field_ID . "'";
			if (in_array($Field->Field_ID, $Order_Information)) {echo "checked='checked'";}
			echo "/><span class='ewd-otp-admin-checkbox'></span> <span>" . $Field->Field_Name . "</span></label><br />";
		}
	?>
	<h5>Customer Information</h5>
	<label title='Customer Name' class='ewd-otp-admin-input-container'><input type='checkbox' name='order_information[]' value='Customer_Name' <?php if(in_array("Customer_Name", $Order_Information)) {echo "checked='checked'";} ?> /><span class='ewd-otp-admin-checkbox'></span> <span>Customer Name</span></label><br />
	<label title='Customer Email' class='ewd-otp-admin-input-container'><input type='checkbox' name='order_information[]' value='Customer_Email' <?php if(in_array("Customer_Email", $Order_Information)) {echo "checked='checked'";} ?> /><span class='ewd-otp-admin-checkbox'></span> <span>Customer Email</span></label><br />
	<?php
		$Sql = "SELECT * FROM $EWD_OTP_fields_table_name WHERE Field_Function='Customers' ORDER BY Field_Order";
		$Fields = $wpdb->get_results($Sql);
		foreach ($Fields as $Field) {
			echo "<label title='" . $Field->Field_ID . "' class='ewd-otp-admin-input-container'><input type='checkbox' name='order_information[]' value='" . $Field->Field_ID . "'";
			if (in_array($Field->Field_ID, $Order_Information)) {echo "checked='checked'";}
			echo "/><span class='ewd-otp-admin-checkbox'></span> <span>" . $Field->Field_Name . "</span></label><br />";
		}
	?>
	<h5>Sales Rep Information</h5>
	<?php
		$Sql = "SELECT * FROM $EWD_OTP_fields_table_name WHERE Field_Function='Sales_Reps' ORDER BY Field_Order";
		$Fields = $wpdb->get_results($Sql);
		foreach ($Fields as $Field) {
			echo "<label title='" . $Field->Field_ID . "' class='ewd-otp-admin-input-container'><input type='checkbox' name='order_information[]' value='" . $Field->Field_ID . "'";
			if (in_array($Field->Field_ID, $Order_Information)) {echo "checked='checked'";}
			echo "/><span class='ewd-otp-admin-checkbox'></span> <span>" . $Field->Field_Name . "</span></label><br />";
		}
	?>
	<label title='Sales Rep First Name' class='ewd-otp-admin-input-container'><input type='checkbox' name='order_information[]' value='Sales_Rep_First_Name' <?php if(in_array("Sales_Rep_First_Name", $Order_Information)) {echo "checked='checked'";} ?> /><span class='ewd-otp-admin-checkbox'></span> <span>Sales Rep First Name</span></label><br />
	<label title='Sales Rep Last Name' class='ewd-otp-admin-input-container'><input type='checkbox' name='order_information[]' value='Sales_Rep_Last_Name' <?php if(in_array("Sales_Rep_Last_Name", $Order_Information)) {echo "checked='checked'";} ?> /><span class='ewd-otp-admin-checkbox'></span> <span>Sales Rep Last Name</span></label><br />
	<p>Select what information should be displayed for each order.</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Hide Blank Fields</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Hide Blank Fields</span></legend>
	<div class="ewd-otp-admin-hide-radios">
		<label title='Yes'><input type='radio' name='hide_blank_fields' value='Yes' <?php if($Hide_Blank_Fields == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
		<label title='No'><input type='radio' name='hide_blank_fields' value='No' <?php if($Hide_Blank_Fields == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
	</div>
	<label class="ewd-otp-admin-switch">
		<input type="checkbox" class="ewd-otp-admin-option-toggle" data-inputname="hide_blank_fields" <?php if($Hide_Blank_Fields == "Yes") {echo "checked='checked'";} ?>>
		<span class="ewd-otp-admin-switch-slider round"></span>
	</label>		
	<p>Should fields which don't have a value (ex. customer name, custom fields) be hidden if they're empty?</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Order Form Instructions</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Order Form Instructions</span></legend>
	<label title='Form Instructions'></label><textarea class='ewd-otp-textarea' name='form_instructions'> <?php echo $Form_Instructions; ?></textarea><br />
	<p>The instructions that will display above the order form.</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Set Timezone</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Set Timezone</span></legend>
	<label title='Timezone'></label><select name='timezone'>
			<option value="Pacific/Midway"<?php if($Timezone == "Pacific/Midway") {echo " selected=selected";} ?>>(GMT-11:00) Midway Island, Samoa</option>
			<option value="America/Adak"<?php if($Timezone == "America/Adak") {echo " selected=selected";} ?>>(GMT-10:00) Hawaii-Aleutian</option>
			<option value="Etc/GMT+10"<?php if($Timezone == "Etc/GMT+10") {echo " selected=selected";} ?>>(GMT-10:00) Hawaii</option>
			<option value="Pacific/Marquesas"<?php if($Timezone == "Pacific/Marquesas") {echo " selected=selected";} ?>>(GMT-09:30) Marquesas Islands</option>
			<option value="Pacific/Gambier"<?php if($Timezone == "Pacific/Gambier") {echo " selected=selected";} ?>>(GMT-09:00) Gambier Islands</option>
			<option value="America/Anchorage"<?php if($Timezone == "America/Anchorage") {echo " selected=selected";} ?>>(GMT-09:00) Alaska</option>
			<option value="America/Ensenada"<?php if($Timezone == "America/Ensenada") {echo " selected=selected";} ?>>(GMT-08:00) Tijuana, Baja California</option>
			<option value="Etc/GMT+8"<?php if($Timezone == "Etc/GMT+8") {echo " selected=selected";} ?>>(GMT-08:00) Pitcairn Islands</option>
			<option value="America/Los_Angeles"<?php if($Timezone == "America/Los_Angeles") {echo " selected=selected";} ?>>(GMT-08:00) Pacific Time (US & Canada)</option>
			<option value="America/Denver"<?php if($Timezone == "America/Denver") {echo " selected=selected";} ?>>(GMT-07:00) Mountain Time (US & Canada)</option>
			<option value="America/Chihuahua"<?php if($Timezone == "America/Chihuahua") {echo " selected=selected";} ?>>(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
			<option value="America/Dawson_Creek"<?php if($Timezone == "America/Dawson_Creek") {echo " selected=selected";} ?>>(GMT-07:00) Arizona</option>
			<option value="America/Belize"<?php if($Timezone == "America/Belize") {echo " selected=selected";} ?>>(GMT-06:00) Saskatchewan, Central America</option>
			<option value="America/Cancun"<?php if($Timezone == "America/Cancun") {echo " selected=selected";} ?>>(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
			<option value="Chile/EasterIsland"<?php if($Timezone == "Chile/EasterIsland") {echo " selected=selected";} ?>>(GMT-06:00) Easter Island</option>
			<option value="America/Chicago"<?php if($Timezone == "America/Chicago") {echo " selected=selected";} ?>>(GMT-06:00) Central Time (US & Canada)</option>
			<option value="America/New_York"<?php if($Timezone == "America/New_York") {echo " selected=selected";} ?>>(GMT-05:00) Eastern Time (US & Canada)</option>
			<option value="America/Havana"<?php if($Timezone == "America/Havana") {echo " selected=selected";} ?>>(GMT-05:00) Cuba</option>
			<option value="America/Bogota"<?php if($Timezone == "America/Bogota") {echo " selected=selected";} ?>>(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
			<option value="America/Caracas"<?php if($Timezone == "America/Caracas") {echo " selected=selected";} ?>>(GMT-04:30) Caracas</option>
			<option value="America/Santiago"<?php if($Timezone == "America/Santiago") {echo " selected=selected";} ?>>(GMT-04:00) Santiago</option>
			<option value="America/La_Paz"<?php if($Timezone == "America/La_Paz") {echo " selected=selected";} ?>>(GMT-04:00) La Paz</option>
			<option value="Atlantic/Stanley"<?php if($Timezone == "Atlantic/Stanley") {echo " selected=selected";} ?>>(GMT-04:00) Faukland Islands</option>
			<option value="America/Campo_Grande"<?php if($Timezone == "America/Campo_Grande") {echo " selected=selected";} ?>>(GMT-04:00) Brazil</option>
			<option value="America/Goose_Bay"<?php if($Timezone == "America/Goose_Bay") {echo " selected=selected";} ?>>(GMT-04:00) Atlantic Time (Goose Bay)</option>
			<option value="America/Glace_Bay"<?php if($Timezone == "America/Glace_Bay") {echo " selected=selected";} ?>>(GMT-04:00) Atlantic Time (Canada)</option>
			<option value="America/St_Johns"<?php if($Timezone == "America/St_Johns") {echo " selected=selected";} ?>>(GMT-03:30) Newfoundland</option>
			<option value="America/Araguaina"<?php if($Timezone == "America/Araguaina") {echo " selected=selected";} ?>>(GMT-03:00) UTC-3</option>
			<option value="America/Montevideo"<?php if($Timezone == "America/Montevideo") {echo " selected=selected";} ?>>(GMT-03:00) Montevideo</option>
			<option value="America/Miquelon"<?php if($Timezone == "America/Miquelon") {echo " selected=selected";} ?>>(GMT-03:00) Miquelon, St. Pierre</option>
			<option value="America/Godthab"<?php if($Timezone == "America/Godthab") {echo " selected=selected";} ?>>(GMT-03:00) Greenland</option>
			<option value="America/Argentina/Buenos_Aires"<?php if($Timezone == "America/Argentina/Buenos_Aires") {echo " selected=selected";} ?>>(GMT-03:00) Buenos Aires</option>
			<option value="America/Sao_Paulo"<?php if($Timezone == "America/Sao_Paulo") {echo " selected=selected";} ?>>(GMT-03:00) Brasilia</option>
			<option value="America/Noronha"<?php if($Timezone == "America/Noronha") {echo " selected=selected";} ?>>(GMT-02:00) Mid-Atlantic</option>
			<option value="Atlantic/Cape_Verde"<?php if($Timezone == "Atlantic/Cape_Verde") {echo " selected=selected";} ?>>(GMT-01:00) Cape Verde Is.</option>
			<option value="Atlantic/Azores"<?php if($Timezone == "Atlantic/Azores") {echo " selected=selected";} ?>>(GMT-01:00) Azores</option>
			<option value="Europe/Belfast"<?php if($Timezone == "Europe/Belfast") {echo " selected=selected";} ?>>(GMT) Greenwich Mean Time : Belfast</option>
			<option value="Europe/Dublin"<?php if($Timezone == "Europe/Dublin") {echo " selected=selected";} ?>>(GMT) Greenwich Mean Time : Dublin</option>
			<option value="Europe/Lisbon"<?php if($Timezone == "Europe/Lisbon") {echo " selected=selected";} ?>>(GMT) Greenwich Mean Time : Lisbon</option>
			<option value="Europe/London"<?php if($Timezone == "Europe/London") {echo " selected=selected";} ?>>(GMT) Greenwich Mean Time : London</option>
			<option value="Africa/Abidjan"<?php if($Timezone == "Africa/Abidjan") {echo " selected=selected";} ?>>(GMT) Monrovia, Reykjavik</option>
			<option value="Europe/Amsterdam"<?php if($Timezone == "Europe/Amsterdam") {echo " selected=selected";} ?>>(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
			<option value="Europe/Belgrade"<?php if($Timezone == "Europe/Belgrade") {echo " selected=selected";} ?>>(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
			<option value="Europe/Brussels"<?php if($Timezone == "Europe/Brussels") {echo " selected=selected";} ?>>(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
			<option value="Africa/Algiers"<?php if($Timezone == "Africa/Algiers") {echo " selected=selected";} ?>>(GMT+01:00) West Central Africa</option>
			<option value="Africa/Windhoek"<?php if($Timezone == "Africa/Windhoek") {echo " selected=selected";} ?>>(GMT+01:00) Windhoek</option>
			<option value="Asia/Beirut"<?php if($Timezone == "Asia/Beirut") {echo " selected=selected";} ?>>(GMT+02:00) Beirut</option>
			<option value="Africa/Cairo"<?php if($Timezone == "Africa/Cairo") {echo " selected=selected";} ?>>(GMT+02:00) Cairo</option>
			<option value="Asia/Gaza"<?php if($Timezone == "Asia/Gaza") {echo " selected=selected";} ?>>(GMT+02:00) Gaza</option>
			<option value="Africa/Blantyre"<?php if($Timezone == "Africa/Blantyre") {echo " selected=selected";} ?>>(GMT+02:00) Harare, Pretoria</option>
			<option value="Asia/Jerusalem"<?php if($Timezone == "Asia/Jerusalem") {echo " selected=selected";} ?>>(GMT+02:00) Jerusalem</option>
			<option value="Europe/Minsk"<?php if($Timezone == "Europe/Minsk") {echo " selected=selected";} ?>>(GMT+02:00) Minsk</option>
  		<option value="Asia/Damascus"<?php if($Timezone == "Asia/Damascus") {echo " selected=selected";} ?>>(GMT+02:00) Syria</option>
			<option value="Europe/Moscow"<?php if($Timezone == "Europe/Moscow") {echo " selected=selected";} ?>>(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
			<option value="Africa/Addis_Ababa"<?php if($Timezone == "Africa/Addis_Ababa") {echo " selected=selected";} ?>>(GMT+03:00) Nairobi</option>
			<option value="Asia/Tehran"<?php if($Timezone == "Asia/Tehran") {echo " selected=selected";} ?>>(GMT+03:30) Tehran</option>
			<option value="Asia/Dubai"<?php if($Timezone == "Asia/Dubai") {echo " selected=selected";} ?>>(GMT+04:00) Abu Dhabi, Muscat</option>
			<option value="Asia/Yerevan"<?php if($Timezone == "Asia/Yerevan") {echo " selected=selected";} ?>>(GMT+04:00) Yerevan</option>
			<option value="Asia/Kabul"<?php if($Timezone == "Asia/Kabul") {echo " selected=selected";} ?>>(GMT+04:30) Kabul</option>
			<option value="Asia/Yekaterinburg"<?php if($Timezone == "Asia/Yekaterinburg") {echo " selected=selected";} ?>>(GMT+05:00) Ekaterinburg</option>
			<option value="Asia/Tashkent"<?php if($Timezone == "Asia/Tashkent") {echo " selected=selected";} ?>>(GMT+05:00) Tashkent</option>
			<option value="Asia/Kolkata"<?php if($Timezone == "Asia/Kolkata") {echo " selected=selected";} ?>>(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
			<option value="Asia/Katmandu"<?php if($Timezone == "Asia/Katmandu") {echo " selected=selected";} ?>>(GMT+05:45) Kathmandu</option>
			<option value="Asia/Dhaka"<?php if($Timezone == "Asia/Dhaka") {echo " selected=selected";} ?>>(GMT+06:00) Astana, Dhaka</option>
			<option value="Asia/Novosibirsk"<?php if($Timezone == "Asia/Novosibirsk") {echo " selected=selected";} ?>>(GMT+06:00) Novosibirsk</option>
			<option value="Asia/Rangoon"<?php if($Timezone == "Asia/Rangoon") {echo " selected=selected";} ?>>(GMT+06:30) Yangon (Rangoon)</option>
			<option value="Asia/Bangkok"<?php if($Timezone == "Asia/Bangkok") {echo " selected=selected";} ?>>(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
			<option value="Asia/Krasnoyarsk"<?php if($Timezone == "Asia/Krasnoyarsk") {echo " selected=selected";} ?>>(GMT+07:00) Krasnoyarsk</option>
			<option value="Asia/Hong_Kong"<?php if($Timezone == "Asia/Hong_Kong") {echo " selected=selected";} ?>>(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
			<option value="Asia/Irkutsk"<?php if($Timezone == "Asia/Irkutsk") {echo " selected=selected";} ?>>(GMT+08:00) Irkutsk, Ulaan Bataar</option>
			<option value="Australia/Perth"<?php if($Timezone == "Australia/Perth") {echo " selected=selected";} ?>>(GMT+08:00) Perth</option>
			<option value="Australia/Eucla"<?php if($Timezone == "Australia/Eucla") {echo " selected=selected";} ?>>(GMT+08:45) Eucla</option>
			<option value="Asia/Tokyo"<?php if($Timezone == "Asia/Tokyo") {echo " selected=selected";} ?>>(GMT+09:00) Osaka, Sapporo, Tokyo</option>
			<option value="Asia/Seoul"<?php if($Timezone == "Asia/Seoul") {echo " selected=selected";} ?>>(GMT+09:00) Seoul</option>
			<option value="Asia/Yakutsk"<?php if($Timezone == "Asia/Yakutsk") {echo " selected=selected";} ?>>(GMT+09:00) Yakutsk</option>
			<option value="Australia/Adelaide"<?php if($Timezone == "Australia/Adelaide") {echo " selected=selected";} ?>>(GMT+09:30) Adelaide</option>
			<option value="Australia/Darwin"<?php if($Timezone == "Australia/Darwin") {echo " selected=selected";} ?>>(GMT+09:30) Darwin</option>
			<option value="Australia/Brisbane"<?php if($Timezone == "Australia/Brisbane") {echo " selected=selected";} ?>>(GMT+10:00) Brisbane</option>
			<option value="Australia/Hobart"<?php if($Timezone == "Australia/Hobart") {echo " selected=selected";} ?>>(GMT+10:00) Hobart</option>
			<option value="Asia/Vladivostok"<?php if($Timezone == "Asia/Vladivostok") {echo " selected=selected";} ?>>(GMT+10:00) Vladivostok</option>
			<option value="Australia/Lord_Howe"<?php if($Timezone == "Australia/Lord_Howe") {echo " selected=selected";} ?>>(GMT+10:30) Lord Howe Island</option>
			<option value="Etc/GMT-11"<?php if($Timezone == "Etc/GMT-11") {echo " selected=selected";} ?>>(GMT+11:00) Solomon Is., New Caledonia</option>
			<option value="Asia/Magadan"<?php if($Timezone == "Asia/Magadan") {echo " selected=selected";} ?>>(GMT+11:00) Magadan</option>
			<option value="Pacific/Norfolk"<?php if($Timezone == "Pacific/Norfolk") {echo " selected=selected";} ?>>(GMT+11:30) Norfolk Island</option>
			<option value="Asia/Anadyr"<?php if($Timezone == "Asia/Anadyr") {echo " selected=selected";} ?>>(GMT+12:00) Anadyr, Kamchatka</option>
			<option value="Pacific/Auckland"<?php if($Timezone == "Pacific/Auckland") {echo " selected=selected";} ?>>(GMT+12:00) Auckland, Wellington</option>
			<option value="Etc/GMT-12"<?php if($Timezone == "Etc/GMT-12") {echo " selected=selected";} ?>>(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
			<option value="Pacific/Chatham"<?php if($Timezone == "Pacific/Chatham") {echo " selected=selected";} ?>>(GMT+12:45) Chatham Islands</option>
			<option value="Pacific/Tongatapu"<?php if($Timezone == "Pacific/Tongatapu") {echo " selected=selected";} ?>>(GMT+13:00) Nuku'alofa</option>
			<option value="Pacific/Kiritimati"<?php if($Timezone == "Pacific/Kiritimati") {echo " selected=selected";} ?>>(GMT+14:00) Kiritimati</option>
	</select>
	<p>What timezone should be used when sending the orders to the WordPress database?</p>
	</fieldset>
</td>
</tr>

<tr>
<th scope="row">Date/Time Format</th>
<td>
  <fieldset><legend class="screen-reader-text"><span>Date/Time Format</span></legend>
  <label title='Localize Date & Time settings'></label><select name='localize_date_time'>
		<option value="North_American" <?php if($Localize_Date_Time == "North_American") {echo " selected=selected";} ?>>North American (YY-DD-MM)</option>
    <option value="European" <?php if($Localize_Date_Time == "European") {echo " selected=selected";} ?> >European (DD-MM-YY)</option>
	</select>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Order Email Frequency</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Order Email Frequency</span></legend>
	<label title='On Change' class='ewd-otp-admin-input-container'><input type='radio' name='order_email' value='Change' <?php if($Order_Email == "Change") {echo "checked='checked'";} ?> /><span class='ewd-otp-admin-radio-button'></span> <span>On Change</span></label><br />
	<label title='On Creation' class='ewd-otp-admin-input-container'><input type='radio' name='order_email' value='Creation' <?php if($Order_Email == "Creation") {echo "checked='checked'";} ?> /><span class='ewd-otp-admin-radio-button'></span> <span>On Creation</span></label><br />
	<label title='Never' class='ewd-otp-admin-input-container'><input type='radio' name='order_email' value='Never' <?php if($Order_Email == "Never") {echo "checked='checked'";} ?> /><span class='ewd-otp-admin-radio-button'></span> <span>Never</span></label><br />
	<p>How often should emails be sent to customers about the status of their orders?</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">AJAX Reloads</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>AJAX Reloads</span></legend>
	<div class="ewd-otp-admin-hide-radios">
		<label title='Yes'><input type='radio' name='ajax_reload' value='Yes' <?php if($AJAX_Reload == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
		<label title='No'><input type='radio' name='ajax_reload' value='No' <?php if($AJAX_Reload == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
	</div>
	<label class="ewd-otp-admin-switch">
		<input type="checkbox" class="ewd-otp-admin-option-toggle" data-inputname="ajax_reload" <?php if($AJAX_Reload == "Yes") {echo "checked='checked'";} ?>>
		<span class="ewd-otp-admin-switch-slider round"></span>
	</label>		
	<p>Should search results use AJAX to display without reloading the page?</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">New Window for Results</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>New Window for Results</span></legend>
	<div class="ewd-otp-admin-hide-radios">
		<label title='Yes'><input type='radio' name='new_window' value='Yes' <?php if($New_Window == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
		<label title='No'><input type='radio' name='new_window' value='No' <?php if($New_Window == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
	</div>
	<label class="ewd-otp-admin-switch">
		<input type="checkbox" class="ewd-otp-admin-option-toggle" data-inputname="new_window" <?php if($New_Window == "Yes") {echo "checked='checked'";} ?>>
		<span class="ewd-otp-admin-switch-slider round"></span>
	</label>		
	<p>Should search results display in a new window or open in the same one? (Doesn't work with AJAX reloads)</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Display "Print" Button</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Display "Print" Button</span></legend>
	<div class="ewd-otp-admin-hide-radios">
		<label title='Yes'><input type='radio' name='display_print_button' value='Yes' <?php if($Display_Print_Button == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
		<label title='No'><input type='radio' name='display_print_button' value='No' <?php if($Display_Print_Button == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
	</div>
	<label class="ewd-otp-admin-switch">
		<input type="checkbox" class="ewd-otp-admin-option-toggle" data-inputname="display_print_button" <?php if($Display_Print_Button == "Yes") {echo "checked='checked'";} ?>>
		<span class="ewd-otp-admin-switch-slider round"></span>
	</label>		
	<p>Should a "Print" button be added to tracking form results, so that visitors can print their order information more easily?</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Order Email Confirmation</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Order Email Confirmation</span></legend>
	<div class="ewd-otp-admin-hide-radios">
		<label title='User Entered' class='ewd-otp-admin-input-container'><input type='radio' name='email_confirmation' value='Order_Email' <?php if($Email_Confirmation == "Order_Email") {echo "checked='checked'";} ?> /><span class='ewd-otp-admin-radio-button'></span> <span>User Entered</span></label><br />
		<label title='No' class='ewd-otp-admin-input-container'><input type='radio' name='email_confirmation' value='None' <?php if($Email_Confirmation == "None") {echo "checked='checked'";} ?> /><span class='ewd-otp-admin-radio-button'></span> <span>No</span></label><br />
	</div>
	<label class="ewd-otp-admin-switch">
		<input type="checkbox" class="ewd-otp-admin-option-toggle" data-inputname="email_confirmation" <?php if($Email_Confirmation == "Order_Email") {echo "checked='checked'";} ?>>
		<span class="ewd-otp-admin-switch-slider round"></span>
	</label>		
	<p>Do visitors need to also enter the email address associated with an order to be able to view order information?</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Show Editor Helper</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Show Editor Helper</span></legend>
	<div class="ewd-otp-admin-hide-radios">
		<label title='Yes'><input type='radio' name='show_tinymce' value='Yes' <?php if($Show_TinyMCE == "Yes") {echo "checked='checked'";} ?> /> <span>Yes</span></label><br />
		<label title='No'><input type='radio' name='show_tinymce' value='No' <?php if($Show_TinyMCE == "No") {echo "checked='checked'";} ?> /> <span>No</span></label><br />
	</div>
	<label class="ewd-otp-admin-switch">
		<input type="checkbox" class="ewd-otp-admin-option-toggle" data-inputname="show_tinymce" <?php if($Show_TinyMCE == "Yes") {echo "checked='checked'";} ?>>
		<span class="ewd-otp-admin-switch-slider round"></span>
	</label>		
	<p>Should the shortcode builder be shown above the WordPress page/post editor, in the toolbar buttons?</p>
	</fieldset>
</td>
</tr>
</table>
</div>

<div id='Premium' class='otp-option-set<?php echo ( $Display_Tab == 'Premium' ? '' : ' otp-hidden' ); ?>'>

<h2 class="otp-options-tab-title"><?php _e('Premium Options', 'order-tracking'); ?></h2>
<br />

<div class="ewd-otp-admin-section-heading"><?php _e('General', 'order-tracking'); ?></div>

<table class="form-table ewd-otp-premium-options-table">
<tr>
<th scope="row">Days to Save Statistics</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Days to Save Statistics</span></legend>
	<label title='Statistics Days'><input type='text' name='statistics_days' value='<?php echo $Statistics_Days; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?> /></label><br />
	<p>How many days should statistics be saved for?</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Set Access Role</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Set Access Role</span></legend>
	<label title='Access Role'></label><select name='access_role' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>>
		<option value="administrator"<?php if($Access_Role == "administrator") {echo " selected=selected";} ?>>Administrator</option>
		<option value="delete_others_pages"<?php if($Access_Role == "delete_others_pages") {echo " selected=selected";} ?>>Editor</option>
		<option value="delete_published_posts"<?php if($Access_Role == "delete_published_posts") {echo " selected=selected";} ?>>Author</option>
		<option value="delete_posts"<?php if($Access_Role == "delete_posts") {echo " selected=selected";} ?>>Contributor</option>
		<option value="read"<?php if($Access_Role == "read") {echo " selected=selected";} ?>>Subscriber</option>
	</select>
	<p>Who should have access to the "Status Tracking" admin menu?</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Status Tracking Graphic</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Status Tracking Graphic</span></legend>
	<!--Unresponsive-->
	<label title='Default' class='ewd-otp-admin-input-container'><input type='radio' name='display_graphic' value='Default' <?php if($Display_Graphic == "Default") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-otp-admin-radio-button'></span> <span>Default</span></label><br />
	<label title='Streamlined' class='ewd-otp-admin-input-container'><input type='radio' name='display_graphic' value='Streamlined' <?php if($Display_Graphic == "Streamlined") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-otp-admin-radio-button'></span> <span>Streamlined</span></label><br />
	<label title='Sleek' class='ewd-otp-admin-input-container'><input type='radio' name='display_graphic' value='Sleek' <?php if($Display_Graphic == "Sleek") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-otp-admin-radio-button'></span> <span>Sleek</span></label><br />
	<!--<label title='Narrow'><input type='radio' name='display_graphic' value='Narrow' <?php if($Display_Graphic == "Narrow") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>Narrow</span></label><br />-->
	<!--Reponsive-->
	<label title='Minimalist (Responsive)' class='ewd-otp-admin-input-container'><input type='radio' name='display_graphic' value='Minimalist' <?php if($Display_Graphic == "Minimalist") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-otp-admin-radio-button'></span> <span>Minimalist</span></label><br />
	<label title='Round (Reponsive)' class='ewd-otp-admin-input-container'><input type='radio' name='display_graphic' value='Round' <?php if($Display_Graphic == "Round") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-otp-admin-radio-button'></span> <span>Round</span></label><br />
	<p>Which tracking graphic should be displayed, if the graphic is being used for your orders.</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Mobile Stylesheet</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Mobile Stylesheet</span></legend>
	<div class="ewd-otp-admin-hide-radios">
		<label title='Yes'><input type='radio' name='mobile_stylesheet' value='Yes' <?php if($Mobile_Stylesheet == "Yes") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>Yes</span></label><br />
		<label title='No'><input type='radio' name='mobile_stylesheet' value='No' <?php if($Mobile_Stylesheet == "No") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>No</span></label><br />
	</div>
	<label class="ewd-otp-admin-switch">
		<input type="checkbox" class="ewd-otp-admin-option-toggle" data-inputname="mobile_stylesheet" <?php if($Mobile_Stylesheet == "Yes") {echo "checked='checked'";} ?>>
		<span class="ewd-otp-admin-switch-slider round"></span>
	</label>		
	<p>Should the mobile stylesheet for the plugin be included, so that the tracking form better fits mobile device screens?</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Customer Notes Email</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Customer Notes Email</span></legend>
	<label title='Customer Notes Email'></label><select name='customer_notes_email' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>>
		<option value="None" <?php if($Customer_Notes_Email == "None") {echo " selected=selected";} ?>>None</option>
		<?php foreach ($Email_Messages_Array as $Email_Message_Item) { ?>
			<option value='<?php echo $Email_Message_Item['Name']; ?>' <?php if($Customer_Notes_Email == $Email_Message_Item['Name']) {echo "selected=selected";} ?>>
				<?php echo $Email_Message_Item['Name']; ?>
			</option>
		<?php } ?>
	</select>
	<p>What email, if any, should be sent to the administrator when the customer note on an order is updated?</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Customer Order Email</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Customer Order Email</span></legend>
	<label title='Customer Order Email'></label><select name='customer_order_email' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>>
		<option value="None" <?php if($Customer_Order_Email == "None") {echo " selected=selected";} ?>>None</option>
		<?php foreach ($Email_Messages_Array as $Email_Message_Item) { ?>
			<option value='<?php echo $Email_Message_Item['Name']; ?>' <?php if($Customer_Order_Email == $Email_Message_Item['Name']) {echo "selected=selected";} ?>>
				<?php echo $Email_Message_Item['Name']; ?>
			</option>
		<?php } ?>
	</select>
	<p>What email, if any, should be sent to the administrator when a new customer order is created?</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Allow Customer Downloads</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Allow Customer Downloads</span></legend>
	<div class="ewd-otp-admin-hide-radios">
		<label title='Yes'><input type='radio' name='allow_customer_downloads' value='Yes' <?php if($Allow_Customer_Downloads == "Yes") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>Yes</span></label><br />
		<label title='No'><input type='radio' name='allow_customer_downloads' value='No' <?php if($Allow_Customer_Downloads == "No") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>No</span></label><br />
	</div>
	<label class="ewd-otp-admin-switch">
		<input type="checkbox" class="ewd-otp-admin-option-toggle" data-inputname="allow_customer_downloads" <?php if($Allow_Customer_Downloads == "Yes") {echo "checked='checked'";} ?>>
		<span class="ewd-otp-admin-switch-slider round"></span>
	</label>		
	<p>Should customers be able to download all of the information on their orders as a CSV file?</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Allow Sales Rep Downloads</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Allow Sales Rep Downloads</span></legend>
	<div class="ewd-otp-admin-hide-radios">
		<label title='Yes'><input type='radio' name='allow_sales_rep_downloads' value='Yes' <?php if($Allow_Sales_Rep_Downloads == "Yes") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>Yes</span></label><br />
		<label title='No'><input type='radio' name='allow_sales_rep_downloads' value='No' <?php if($Allow_Sales_Rep_Downloads == "No") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>No</span></label><br />
	</div>
	<label class="ewd-otp-admin-switch">
		<input type="checkbox" class="ewd-otp-admin-option-toggle" data-inputname="allow_sales_rep_downloads" <?php if($Allow_Sales_Rep_Downloads == "Yes") {echo "checked='checked'";} ?>>
		<span class="ewd-otp-admin-switch-slider round"></span>
	</label>		
	<p>Should sales reps be able to download all of the information on their orders as a CSV file?</p>
	</fieldset>
</td>
</tr>
<?php if ($EWD_OTP_Full_Version != "Yes") { ?>
	<tr class="ewd-otp-premium-options-table-overlay">
		<th colspan="2">
			<div class="ewd-otp-unlock-premium">
				<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Order Tracking Premium">
				<p>Access this section by by upgrading to premium</p>
				<a href="https://www.etoilewebdesign.com/plugins/order-tracking/#buy" class="ewd-otp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
			</div>
		</th>
	</tr>
<?php } ?>
</table>

<br />

<div class="ewd-otp-admin-section-heading"><?php _e('Customer Order Form', 'order-tracking'); ?></div>

<table class="form-table ewd-otp-premium-options-table">
<tr>
<th scope="row">Allow Sales Rep Selection</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Allow Sales Rep Selection</span></legend>
	<div class="ewd-otp-admin-hide-radios">
		<label title='Yes'><input type='radio' name='allow_sales_rep_selection' value='Yes' <?php if($Allow_Sales_Rep_Selection == "Yes") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>Yes</span></label><br />
		<label title='No'><input type='radio' name='allow_sales_rep_selection' value='No' <?php if($Allow_Sales_Rep_Selection == "No") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>No</span></label><br />
	</div>
	<label class="ewd-otp-admin-switch">
		<input type="checkbox" class="ewd-otp-admin-option-toggle" data-inputname="allow_sales_rep_selection" <?php if($Allow_Sales_Rep_Selection == "Yes") {echo "checked='checked'";} ?>>
		<span class="ewd-otp-admin-switch-slider round"></span>
	</label>		
	<p>Should an option to choose a sales rep be included in the customer order form?</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Assign Orders to Customers</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Assign Orders to Customers</span></legend>
	<div class="ewd-otp-admin-hide-radios">
		<label title='Yes'><input type='radio' name='auto_assign_orders_to_customers' value='Yes' <?php if($Auto_Assign_Orders_To_Customers == "Yes") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>Yes</span></label><br />
		<label title='No'><input type='radio' name='auto_assign_orders_to_customers' value='No' <?php if($Auto_Assign_Orders_To_Customers == "No") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>No</span></label><br />
	</div>
	<label class="ewd-otp-admin-switch">
		<input type="checkbox" class="ewd-otp-admin-option-toggle" data-inputname="auto_assign_orders_to_customers" <?php if($Auto_Assign_Orders_To_Customers == "Yes") {echo "checked='checked'";} ?>>
		<span class="ewd-otp-admin-switch-slider round"></span>
	</label>		
	<p>With this enabled, orders submitted using the customer order form will be automatically assigned to a customer based on their email address.</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Order Number Prefix</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Order Number Prefix</span></legend>
	<label title='Order Number Prefix'><input type='text' name='customer_order_number_prefix' value='<?php echo $Customer_Order_Number_Prefix; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?> /></label><br />
	<p>Specify a prefix for the auto-generated order number for orders created using the customer order form</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Order Number Suffix</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Order Number Suffix</span></legend>
	<label title='Order Number Suffix'><input type='text' name='customer_order_number_suffix' value='<?php echo $Customer_Order_Number_Suffix; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?> /></label><br />
	<p>Specify a suffix for the auto-generated order number for orders created using the customer order form</p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">Default Sales Rep</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Default Sales Rep</span></legend>
	<label title='Default Sales Rep'></label>
	<select name='default_sales_rep' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>>
		<option value="None"<?php if($Default_Sales_Rep == "None") {echo " selected=selected";} ?>>None</option>
		<?php
		$Sales_Reps = $wpdb->get_results("SELECT * FROM $EWD_OTP_sales_reps");
		foreach($Sales_Reps as $Sales_Rep){
			?>
			<option value="<?php echo $Sales_Rep->Sales_Rep_ID; ?>" <?php if($Sales_Rep->Sales_Rep_ID == $Default_Sales_Rep) {echo " selected=selected";} ?>><?php echo $Sales_Rep->Sales_Rep_First_Name . " " . $Sales_Rep->Sales_Rep_Last_Name; ?></option>
			<?php
		}
		?>
	</select>
	<p>Choose a default sales rep for all orders created using the customer order form (if not using the above option to enable sales rep selection).</p>
	</fieldset>
</td>
</tr>
<?php if ($EWD_OTP_Full_Version != "Yes") { ?>
	<tr class="ewd-otp-premium-options-table-overlay">
		<th colspan="2">
			<div class="ewd-otp-unlock-premium">
				<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Order Tracking Premium">
				<p>Access this section by by upgrading to premium</p>
				<a href="https://www.etoilewebdesign.com/plugins/order-tracking/#buy" class="ewd-otp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
			</div>
		</th>
	</tr>
<?php } ?>
</table>

</div> <!--Premium-->

<div id='Payment' class='otp-option-set<?php echo ( $Display_Tab == 'Payment' ? '' : ' otp-hidden' ); ?>'>

<br />

<div class="ewd-otp-admin-section-heading"><?php _e('Payment Options', 'order-tracking'); ?></div>

<table class="form-table ewd-otp-premium-options-table">
<tr>
<th scope="row">Allow Order Payment By PayPal</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Allow Order Payment By PayPal</span></legend>
	<div class="ewd-otp-admin-hide-radios">
		<label title='Yes'><input type='radio' name='allow_order_payments' value='Yes' <?php if($Allow_Order_Payments == "Yes") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>Yes</span></label><br />
		<label title='No'><input type='radio' name='allow_order_payments' value='No' <?php if($Allow_Order_Payments == "No") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>No</span></label><br />
	</div>
	<label class="ewd-otp-admin-switch">
		<input type="checkbox" class="ewd-otp-admin-option-toggle" data-inputname="allow_order_payments" <?php if($Allow_Order_Payments == "Yes") {echo "checked='checked'";} ?>>
		<span class="ewd-otp-admin-switch-slider round"></span>
	</label>		
	<p>Should order payment be possible via PayPal?</p>
	</fieldset>
</td>
</tr>

<tr>
<th scope="row">Default Post-Payment Status</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Default Post-Payment Status</span></legend>
	<label title='Default Payment Status'></label><select name='default_payment_status' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>>
		<option value="None"<?php if($Default_Payment_Status == "None") {echo " selected=selected";} ?>>No Change</option>
		<?php
			$Statuses_Array = get_option("EWD_OTP_Statuses_Array");
			if (!is_array($Statuses_Array)) {$Statuses_Array = array();}
			foreach ($Statuses_Array as $Status_Array_Item) {
		?>
			<option value="<?php echo $Status_Array_Item['Status']; ?>" <?php if($Status_Array_Item['Status'] == $Default_Payment_Status) {echo " selected=selected";} ?>><?php echo $Status_Array_Item['Status']; ?></option>
		<?php } ?>
	</select>
	<p>What status, if any, should an order be set to after payment is received?</p>
	</fieldset>
</td>
</tr>

<tr>
<th scope="row">PayPal Email Address</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>PayPal Email Address</span></legend>
	<label title='PayPal Email Address'><input type='text' name='paypal_email_address' value='<?php echo $PayPal_Email_Address; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?> /></label><br />
	<p>If PayPal payments are possible, what email address is associated with the PayPal account?</p>
	</fieldset>
</td>
</tr>

<tr>
<th scope="row">Pricing Currency</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Pricing Currency</span></legend>
	<label title='Pricing Currency'></label><select name='pricing_currency_code' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>>
	<option value="AUD" <?php if($Pricing_Currency_Code == "AUD") {echo " selected=selected";} ?>><?php _e("Australian Dollar", 'EWD_UASP'); ?></option>
	<option value="BRL" <?php if($Pricing_Currency_Code == "BRL") {echo " selected=selected";} ?>><?php _e("Brazilian Real", 'EWD_UASP'); ?></option>
	<option value="CAD" <?php if($Pricing_Currency_Code == "CAD") {echo " selected=selected";} ?>><?php _e("Canadian Dollar", 'EWD_UASP'); ?></option>
	<option value="CZK" <?php if($Pricing_Currency_Code == "CZK") {echo " selected=selected";} ?>><?php _e("Czech Koruna", 'EWD_UASP'); ?></option>
	<option value="DKK" <?php if($Pricing_Currency_Code == "DKK") {echo " selected=selected";} ?>><?php _e("Danish Krone", 'EWD_UASP'); ?></option>
	<option value="EUR" <?php if($Pricing_Currency_Code == "EUR") {echo " selected=selected";} ?>><?php _e("Euro", 'EWD_UASP'); ?></option>
	<option value="HKD" <?php if($Pricing_Currency_Code == "HKD") {echo " selected=selected";} ?>><?php _e("Hong Kong Dollar", 'EWD_UASP'); ?></option>
	<option value="HUF" <?php if($Pricing_Currency_Code == "HUF") {echo " selected=selected";} ?>><?php _e("Hungarian Forint", 'EWD_UASP'); ?></option>
	<option value="ILS" <?php if($Pricing_Currency_Code == "ILS") {echo " selected=selected";} ?>><?php _e("Israeli New Sheqel", 'EWD_UASP'); ?></option>
	<option value="JPY" <?php if($Pricing_Currency_Code == "JPY") {echo " selected=selected";} ?>><?php _e("Japanese Yen", 'EWD_UASP'); ?></option>
	<option value="MYR" <?php if($Pricing_Currency_Code == "MYR") {echo " selected=selected";} ?>><?php _e("Malaysian Ringgit", 'EWD_UASP'); ?></option>
	<option value="MXN" <?php if($Pricing_Currency_Code == "MXN") {echo " selected=selected";} ?>><?php _e("Mexican Peso", 'EWD_UASP'); ?></option>
	<option value="NOK" <?php if($Pricing_Currency_Code == "NOK") {echo " selected=selected";} ?>><?php _e("Norwegian Krone", 'EWD_UASP'); ?></option>
	<option value="NZD" <?php if($Pricing_Currency_Code == "NZD") {echo " selected=selected";} ?>><?php _e("New Zealand Dollar", 'EWD_UASP'); ?></option>
	<option value="PHP" <?php if($Pricing_Currency_Code == "PHP") {echo " selected=selected";} ?>><?php _e("Philippine Peso", 'EWD_UASP'); ?></option>
	<option value="PLN" <?php if($Pricing_Currency_Code == "PLN") {echo " selected=selected";} ?>><?php _e("Polish Zloty", 'EWD_UASP'); ?></option>
	<option value="GBP" <?php if($Pricing_Currency_Code == "GBP") {echo " selected=selected";} ?>><?php _e("Pound Sterling", 'EWD_UASP'); ?></option>
	<option value="RUB" <?php if($Pricing_Currency_Code == "RUB") {echo " selected=selected";} ?>><?php _e("Russian Ruble", 'EWD_UASP'); ?></option>
	<option value="SGD" <?php if($Pricing_Currency_Code == "SGD") {echo " selected=selected";} ?>><?php _e("Singapore Dollar", 'EWD_UASP'); ?></option>
	<option value="SEK" <?php if($Pricing_Currency_Code == "SEK") {echo " selected=selected";} ?>><?php _e("Swedish Krona", 'EWD_UASP'); ?></option>
	<option value="CHF" <?php if($Pricing_Currency_Code == "CHF") {echo " selected=selected";} ?>><?php _e("Swiss Franc", 'EWD_UASP'); ?></option>
	<option value="TWD" <?php if($Pricing_Currency_Code == "TWD") {echo " selected=selected";} ?>><?php _e("Taiwan New Dollar", 'EWD_UASP'); ?></option>
	<option value="THB" <?php if($Pricing_Currency_Code == "THB") {echo " selected=selected";} ?>><?php _e("Thai Baht", 'EWD_UASP'); ?></option>
	<option value="TRY" <?php if($Pricing_Currency_Code == "TRY") {echo " selected=selected";} ?>><?php _e("Turkish Lira", 'EWD_UASP'); ?></option>
	<option value="USD" <?php if($Pricing_Currency_Code == "USD") {echo " selected=selected";} ?>><?php _e("U.S. Dollar", 'EWD_UASP'); ?></option>
	</select>
	<p>What currency are your orders priced in?</p>
	</fieldset>
</td>
</tr>

<tr>
<th scope="row">"Thank You" Page URL</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>"Thank You" Page URL</span></legend>
	<label title='Thank You Page URL'><input type='text' name='thank_you_url' value='<?php echo $Thank_You_URL; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?> /></label><br />
	<p>What page should customers be taken to after successfully completing a PayPal payment?</p>
	</fieldset>
</td>
</tr>
<?php if ($EWD_OTP_Full_Version != "Yes") { ?>
	<tr class="ewd-otp-premium-options-table-overlay">
		<th colspan="2">
			<div class="ewd-otp-unlock-premium">
				<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Order Tracking Premium">
				<p>Access this section by by upgrading to premium</p>
				<a href="https://www.etoilewebdesign.com/plugins/order-tracking/#buy" class="ewd-otp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
			</div>
		</th>
	</tr>
<?php } ?>
</table>
</div>








<div id='Woocommerce' class='otp-option-set<?php echo ( $Display_Tab == 'Woocommerce' ? '' : ' otp-hidden' ); ?>'>

<br />

<div class="ewd-otp-admin-section-heading"><?php _e('WooCommerce Options', 'order-tracking'); ?></div>

<table class="form-table ewd-otp-premium-options-table <?php echo $EWD_OTP_Full_Version; ?>">
<tr>
<th scope="row">WooCommerce Integration</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>WooCommerce Integration</span></legend>
	<div class="ewd-otp-admin-hide-radios">
		<label title='Yes'><input type='radio' name='woocommerce_integration' value='Yes' <?php if($WooCommerce_Integration == "Yes") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>Yes</span></label><br />
		<label title='No'><input type='radio' name='woocommerce_integration' value='No' <?php if($WooCommerce_Integration == "No") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>No</span></label><br />
	</div>
	<label class="ewd-otp-admin-switch">
		<input type="checkbox" class="ewd-otp-admin-option-toggle" data-inputname="woocommerce_integration" <?php if($WooCommerce_Integration == "Yes") {echo "checked='checked'";} ?>>
		<span class="ewd-otp-admin-switch-slider round"></span>
	</label>		
	<p>Should WooCommerce orders be automatically created inside of the Status Tracking plugin? (Only works for new orders)</p>
	</fieldset>
</td>
</tr>
<tr class="ewd-otp-admin-conditional-wc-options<?php echo ($WooCommerce_Integration != 'Yes' ? ' otp-hidden' : ''); ?>">
<th scope="row">WooCommerce Prefix</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>WooCommerce Prefix</span></legend>
	<label title='WooCommerce Prefix'><input type='text' name='woocommerce_prefix' value='<?php echo $WooCommerce_Prefix; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?> /></label><br />
	<p>What prefix, if any, should be added to WooCommerce order numbers?</p>
	</fieldset>
</td>
</tr>
<tr class="ewd-otp-admin-conditional-wc-options<?php echo ($WooCommerce_Integration != 'Yes' ? ' otp-hidden' : ''); ?>">
<th scope="row">WooCommerce Random Suffix</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>WooCommerce Random Suffix</span></legend>
	<div class="ewd-otp-admin-hide-radios">
		<label title='Yes'><input type='radio' name='woocommerce_random_suffix' value='Yes' <?php if($WooCommerce_Random_Suffix == "Yes") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>Yes</span></label><br />
		<label title='No'><input type='radio' name='woocommerce_random_suffix' value='No' <?php if($WooCommerce_Random_Suffix == "No") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>No</span></label><br />
	</div>
	<label class="ewd-otp-admin-switch">
		<input type="checkbox" class="ewd-otp-admin-option-toggle" data-inputname="woocommerce_random_suffix" <?php if($WooCommerce_Random_Suffix == "Yes") {echo "checked='checked'";} ?>>
		<span class="ewd-otp-admin-switch-slider round"></span>
	</label>		
	<p>Should a random 4 digit suffix be added to WooCommerce orders? This helps to ensure that order numbers won't overlap with manually created orders.</p>
	</fieldset>
</td>
</tr>
<tr class="ewd-otp-admin-conditional-wc-options<?php echo ($WooCommerce_Integration != 'Yes' ? ' otp-hidden' : ''); ?>">
<th scope="row">Show Tracking On Order Page</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Show Tracking On Order Page</span></legend>
	<div class="ewd-otp-admin-hide-radios">
		<label title='Yes'><input type='radio' name='woocommerce_show_on_order_page' value='Yes' <?php if($WooCommerce_Show_On_Order_Page == "Yes") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>Yes</span></label><br />
		<label title='No'><input type='radio' name='woocommerce_show_on_order_page' value='No' <?php if($WooCommerce_Show_On_Order_Page == "No") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>No</span></label><br />
	</div>
	<label class="ewd-otp-admin-switch">
		<input type="checkbox" class="ewd-otp-admin-option-toggle" data-inputname="woocommerce_show_on_order_page" <?php if($WooCommerce_Show_On_Order_Page == "Yes") {echo "checked='checked'";} ?>>
		<span class="ewd-otp-admin-switch-slider round"></span>
	</label>		
	<p>Should order status information be displayed on the order page?</p>
	</fieldset>
</td>
</tr>
<tr class="ewd-otp-admin-conditional-wc-options<?php echo ($WooCommerce_Integration != 'Yes' ? ' otp-hidden' : ''); ?>">
<th scope="row">Location Dropdown for WooCommerce Orders</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Location Dropdown for WooCommerce Orders</span></legend>
	<div class="ewd-otp-admin-hide-radios">
		<label title='Yes'><input type='radio' name='enabled_locations_for_woocommerce' value='Yes' <?php if($Enabled_Locations_For_WooCommerce == "Yes") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>Yes</span></label><br />
		<label title='No'><input type='radio' name='enabled_locations_for_woocommerce' value='No' <?php if($Enabled_Locations_For_WooCommerce == "No") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>No</span></label><br />
	</div>
	<label class="ewd-otp-admin-switch">
		<input type="checkbox" class="ewd-otp-admin-option-toggle" data-inputname="enabled_locations_for_woocommerce" <?php if($Enabled_Locations_For_WooCommerce == "Yes") {echo "checked='checked'";} ?>>
		<span class="ewd-otp-admin-switch-slider round"></span>
	</label>		
	<p>Should a location dropdown be added to the WooCommerce "Edit Order" screen?</p>
	</fieldset>
</td>
</tr>
<tr class="ewd-otp-admin-conditional-wc-options<?php echo ($WooCommerce_Integration != 'Yes' ? ' otp-hidden' : ''); ?>">
<th scope="row">Replace WooCommerce Statuses with Status Tracking Statuses</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Replace WooCommerce Statuses with Status Tracking Statuses</span></legend>
	<div class="ewd-otp-admin-hide-radios">
		<label title='Yes'><input type='radio' name='replace_woocommerce_statuses' value='Yes' <?php if($Replace_WooCommerce_Statuses == "Yes") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>Yes</span></label><br />
		<label title='No'><input type='radio' name='replace_woocommerce_statuses' value='No' <?php if($Replace_WooCommerce_Statuses == "No") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>No</span></label><br />
	</div>
	<label class="ewd-otp-admin-switch">
		<input type="checkbox" class="ewd-otp-admin-option-toggle" data-inputname="replace_woocommerce_statuses" <?php if($Replace_WooCommerce_Statuses == "Yes") {echo "checked='checked'";} ?>>
		<span class="ewd-otp-admin-switch-slider round"></span>
	</label>		
	<p>Should order tracking statuses replace the default WooCommerce statuses?</p>
	</fieldset>
</td>
</tr>
<tr class="ewd-otp-admin-conditional-wc-options<?php echo ($WooCommerce_Integration != 'Yes' ? ' otp-hidden' : ''); ?>">
<th scope="row">Revert WooCommerce Statuses on Deactivation</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Revert WooCommerce Statuses on Deactivation</span></legend>
	<div class="ewd-otp-admin-hide-radios">
		<label title='Yes'><input type='radio' name='woocommerce_revert_statuses' value='Yes' <?php if($WooCommerce_Revert_Statuses == "Yes") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>Yes</span></label><br />
		<label title='No'><input type='radio' name='woocommerce_revert_statuses' value='No' <?php if($WooCommerce_Revert_Statuses == "No") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>No</span></label><br />
	</div>
	<label class="ewd-otp-admin-switch">
		<input type="checkbox" class="ewd-otp-admin-option-toggle" data-inputname="woocommerce_revert_statuses" <?php if($WooCommerce_Revert_Statuses == "Yes") {echo "checked='checked'";} ?>>
		<span class="ewd-otp-admin-switch-slider round"></span>
	</label>		
	<p>Should WooCommerce orders have there statuses returned to one of the defaults when the plugin is deactivated?</p>
	</fieldset>
</td>
</tr>
<tr class="ewd-otp-admin-conditional-wc-options<?php echo ($WooCommerce_Integration != 'Yes' ? ' otp-hidden' : ''); ?>">
<th scope="row">WooCommerce Completed Order Status</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>WooCommerce Completed Order Status</span></legend>
	<label title='WooCommerce Paid Order Status'></label><select name='woocommerce_paid_order_status' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>>
		<?php foreach ($Statuses_Array as $Status_Array_Item) { ?>
			<option value="<?php echo $Status_Array_Item['Status']; ?>" <?php if($Status_Array_Item['Status'] == $WooCommerce_Paid_Order_Status) {echo " selected=selected";} ?>><?php echo $Status_Array_Item['Status']; ?></option>
		<?php } ?>
	</select>
	<p>What status should an order be set to when it's paid for successfully?</p>
	</fieldset>
</td>
</tr>
<tr class="ewd-otp-admin-conditional-wc-options<?php echo ($WooCommerce_Integration != 'Yes' ? ' otp-hidden' : ''); ?>">
<th scope="row">WooCommerce Unpaid Order Status</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>WooCommerce Unpaid Order Status</span></legend>
	<label title='WooCommerce Unpaid Order Status'></label><select name='woocommerce_unpaid_order_status' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>>
		<?php foreach ($Statuses_Array as $Status_Array_Item) { ?>
			<option value="<?php echo $Status_Array_Item['Status']; ?>" <?php if($Status_Array_Item['Status'] == $WooCommerce_Unpaid_Order_Status) {echo " selected=selected";} ?>><?php echo $Status_Array_Item['Status']; ?></option>
		<?php } ?>
	</select>
	<p>What status should an order be set to when it's unpaid?</p>
	</fieldset>
</td>
</tr>
<tr class="ewd-otp-admin-conditional-wc-options<?php echo ($WooCommerce_Integration != 'Yes' ? ' otp-hidden' : ''); ?>">
<th scope="row">WooCommerce Processing Order Status</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>WooCommerce Processing Order Status</span></legend>
	<label title='WooCommerce Processing Order Status'></label><select name='woocommerce_processing_order_status' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>>
		<?php foreach ($Statuses_Array as $Status_Array_Item) { ?>
			<option value="<?php echo $Status_Array_Item['Status']; ?>" <?php if($Status_Array_Item['Status'] == $WooCommerce_Processing_Order_Status) {echo " selected=selected";} ?>><?php echo $Status_Array_Item['Status']; ?></option>
		<?php } ?>
	</select>
	<p>What status should an order be set to when it's processing?</p>
	</fieldset>
</td>
</tr>
<tr class="ewd-otp-admin-conditional-wc-options<?php echo ($WooCommerce_Integration != 'Yes' ? ' otp-hidden' : ''); ?>">
<th scope="row">WooCommerce Cancelled Order Status</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>WooCommerce Cancelled Order Status</span></legend>
	<label title='WooCommerce Cancelled Order Status'></label><select name='woocommerce_cancelled_order_status' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>>
		<?php foreach ($Statuses_Array as $Status_Array_Item) { ?>
			<option value="<?php echo $Status_Array_Item['Status']; ?>" <?php if($Status_Array_Item['Status'] == $WooCommerce_Cancelled_Order_Status) {echo " selected=selected";} ?>><?php echo $Status_Array_Item['Status']; ?></option>
		<?php } ?>
	</select>
	<p>What status should an order be set to when it's cancelled?</p>
	</fieldset>
</td>
</tr>
<tr class="ewd-otp-admin-conditional-wc-options<?php echo ($WooCommerce_Integration != 'Yes' ? ' otp-hidden' : ''); ?>">
<th scope="row">WooCommerce On-Hold Order Status</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>WooCommerce On-Hold Order Status</span></legend>
	<label title='WooCommerce On-Hold Order Status'></label><select name='woocommerce_onhold_order_status' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>>
		<?php foreach ($Statuses_Array as $Status_Array_Item) { ?>
			<option value="<?php echo $Status_Array_Item['Status']; ?>" <?php if($Status_Array_Item['Status'] == $WooCommerce_OnHold_Order_Status) {echo " selected=selected";} ?>><?php echo $Status_Array_Item['Status']; ?></option>
		<?php } ?>
	</select>
	<p>What status should an order be set to when it's on-hold?</p>
	</fieldset>
</td>
</tr>
<tr class="ewd-otp-admin-conditional-wc-options<?php echo ($WooCommerce_Integration != 'Yes' ? ' otp-hidden' : ''); ?>">
<th scope="row">WooCommerce Failed Order Status</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>WooCommerce Failed Order Status</span></legend>
	<label title='WooCommerce Failed Order Status'></label><select name='woocommerce_failed_order_status' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>>
		<?php foreach ($Statuses_Array as $Status_Array_Item) { ?>
			<option value="<?php echo $Status_Array_Item['Status']; ?>" <?php if($Status_Array_Item['Status'] == $WooCommerce_Failed_Order_Status) {echo " selected=selected";} ?>><?php echo $Status_Array_Item['Status']; ?></option>
		<?php } ?>
	</select>
	<p>What status should an order be set to when it fails?</p>
	</fieldset>
</td>
</tr>
<tr class="ewd-otp-admin-conditional-wc-options<?php echo ($WooCommerce_Integration != 'Yes' ? ' otp-hidden' : ''); ?>">
<th scope="row">WooCommerce Refunded Order Status</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>WooCommerce Refunded Order Status</span></legend>
	<label title='WooCommerce Refunded Order Status'></label><select name='woocommerce_refunded_order_status' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>>
		<?php foreach ($Statuses_Array as $Status_Array_Item) { ?>
			<option value="<?php echo $Status_Array_Item['Status']; ?>" <?php if($Status_Array_Item['Status'] == $WooCommerce_Refunded_Order_Status) {echo " selected=selected";} ?>><?php echo $Status_Array_Item['Status']; ?></option>
		<?php } ?>
	</select>
	<p>What status should an order be set to when it's refunded?</p>
	</fieldset>
</td>
</tr>
<tr>
<?php if ($EWD_OTP_Full_Version != "Yes") { ?>
	<tr class="ewd-otp-premium-options-table-overlay">
		<th colspan="2">
			<div class="ewd-otp-unlock-premium">
				<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Order Tracking Premium">
				<p>Access this section by by upgrading to premium</p>
				<a href="https://www.etoilewebdesign.com/plugins/order-tracking/#buy" class="ewd-otp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
			</div>
		</th>
	</tr>
<?php } ?>
</table>
</div>










<div id='Zendesk' class='otp-option-set<?php echo ( $Display_Tab == 'Zendesk' ? '' : ' otp-hidden' ); ?>'>

<br />

<div class="ewd-otp-admin-section-heading"><?php _e('Zendesk Options', 'order-tracking'); ?></div>

<table class="form-table ewd-otp-premium-options-table <?php echo $EWD_OTP_Full_Version; ?>">
<tr>
<th scope="row">Turn on Zendesk Receiver</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Turn on Zendesk Receiver</span></legend>
	<div class="ewd-otp-admin-hide-radios">
		<label title='Yes'><input type='radio' name='zendesk_integration' value='Yes' <?php if($Zendesk_Integration == "Yes") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>Yes</span></label><br />
		<label title='No'><input type='radio' name='zendesk_integration' value='No' <?php if($Zendesk_Integration == "No") {echo "checked='checked'";} ?> <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/> <span>No</span></label><br />
	</div>
	<label class="ewd-otp-admin-switch">
		<input type="checkbox" class="ewd-otp-admin-option-toggle" data-inputname="zendesk_integration" <?php if($Zendesk_Integration == "Yes") {echo "checked='checked'";} ?>>
		<span class="ewd-otp-admin-switch-slider round"></span>
	</label>		
	<p>Should the plugin listen for new tickets from Zendesk?<br />
	Check out our <a style='display:inline; padding-left:0px;' href='http://www.etoilewebdesign.com/status-tracking-zendesk-integration/'>tutorial on setting up Status Tracking-Zendesk integration</a>.</p>
	</fieldset>
</td>
</tr>

<tr>
<th scope="row">Zendesk API Key (optional)</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Zendesk API Key (optional)</span></legend>
	<label title='Zendesk API Key'><input type='text' name='zendesk_api_key' value='<?php echo $Zendesk_API_Key; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?> /></label><br />
	<p>The (optional) key you're using to make sure that fake tickets can't be created by a 3rd party.</p>
	</fieldset>
</td>
</tr>
<?php if ($EWD_OTP_Full_Version != "Yes") { ?>
	<tr class="ewd-otp-premium-options-table-overlay">
		<th colspan="2">
			<div class="ewd-otp-unlock-premium">
				<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Order Tracking Premium">
				<p>Access this section by by upgrading to premium</p>
				<a href="https://www.etoilewebdesign.com/plugins/order-tracking/#buy" class="ewd-otp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
			</div>
		</th>
	</tr>
<?php } ?>
</table>
</div>

<div id='Labelling' class='otp-option-set<?php echo ( $Display_Tab == 'Labelling' ? '' : ' otp-hidden' ); ?>'>
	<h2 id="label-order-options" class="otp-options-tab-title">Labelling Options</h2>

	<br />

	<div class="ewd-otp-admin-section-heading"><?php _e('Tracking Forms', 'order-tracking'); ?></div>

	<div class="ewd-otp-admin-styling-section">
		<div class="ewd-otp-admin-styling-subsection" style="padding-bottom: 20px;">
			<h3 style="margin-top: 0"><?php _e('Tracking Form', 'order-tracking'); ?></h3>
			<p>Replace the default text in the tracking forms</p>
			<div class="ewd-admin-labelling-section">
				<label>
					<p><?php _e("Tracking Form Title", 'order-tracking')?></p>
					<input type='text' name='tracking_title_label' value='<?php echo $Tracking_Title_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Order Number Label", 'order-tracking')?></p>
					<input type='text' name='tracking_ordernumber_label' value='<?php echo $Tracking_Ordernumber_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Order Number Placeholder", 'order-tracking')?></p>
					<input type='text' name='tracking_ordernumber_placeholder_label' value='<?php echo $Tracking_Ordernumber_Placeholder_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Email Address", 'order-tracking')?></p>
					<input type='text' name='tracking_email_label' value='<?php echo $Tracking_Email_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Email Address Placeholder", 'order-tracking')?></p>
					<input type='text' name='tracking_email_placeholder_label' value='<?php echo $Tracking_Email_Placeholder_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Track button", 'order-tracking')?></p>
					<input type='text' name='tracking_button_label' value='<?php echo $Tracking_Button_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Retrieving Results", 'order-tracking')?></p>
					<input type='text' name='retrieving_results_label' value='<?php echo $Retrieving_Results_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
			</div>
		</div>
		<div class="ewd-otp-admin-styling-subsection" style="padding-bottom: 20px;">
			<h3 style="margin-top: 0"><?php _e('Customer Form', 'order-tracking'); ?></h3>
			<div class="ewd-admin-labelling-section">
				<label>
					<p><?php _e("Form Title", 'order-tracking')?></p>
					<input type='text' name='customer_form_title_label' value='<?php echo $Customer_Form_Title_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Instructions", 'order-tracking')?></p>
					<input type='text' name='customer_form_description_label' value='<?php echo $Customer_Form_Description_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Customer Number Label", 'order-tracking')?></p>
					<input type='text' name='customer_form_number_label' value='<?php echo $Customer_Form_Number_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Customer Number Placeholder", 'order-tracking')?></p>
					<input type='text' name='customer_form_number_placeholder_label' value='<?php echo $Customer_Form_Number_Placeholder_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Email Address", 'order-tracking')?></p>
					<input type='text' name='customer_form_email_label' value='<?php echo $Customer_Form_Email_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Email Address Placeholder", 'order-tracking')?></p>
					<input type='text' name='customer_form_email_placeholder_label' value='<?php echo $Customer_Form_Email_Placeholder_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Track button", 'order-tracking')?></p>
					<input type='text' name='customer_form_button_label' value='<?php echo $Customer_Form_Button_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
			</div>
		</div>
		<div class="ewd-otp-admin-styling-subsection">
			<h3 style="margin-top: 0"><?php _e('Sales Rep Form', 'order-tracking'); ?></h3>
			<div class="ewd-admin-labelling-section">
				<label>
					<p><?php _e("Form Title", 'order-tracking')?></p>
					<input type='text' name='sales_rep_form_title_label' value='<?php echo $Sales_Rep_Form_Title_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Instructions", 'order-tracking')?></p>
					<input type='text' name='sales_rep_form_description_label' value='<?php echo $Sales_Rep_Form_Description_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Sales Rep Number Label", 'order-tracking')?></p>
					<input type='text' name='sales_rep_form_number_label' value='<?php echo $Sales_Rep_Form_Number_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Sales Rep Number Placeholder", 'order-tracking')?></p>
					<input type='text' name='sales_rep_form_number_placeholder_label' value='<?php echo $Sales_Rep_Form_Number_Placeholder_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Email Address", 'order-tracking')?></p>
					<input type='text' name='sales_rep_form_email_label' value='<?php echo $Sales_Rep_Form_Email_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Email Address Placeholder", 'order-tracking')?></p>
					<input type='text' name='sales_rep_form_email_placeholder_label' value='<?php echo $Sales_Rep_Form_Email_Placeholder_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Track button", 'order-tracking')?></p>
					<input type='text' name='sales_rep_form_button_label' value='<?php echo $Sales_Rep_Form_Button_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
			</div>
		</div>
		<?php if ($EWD_OTP_Full_Version != "Yes") { ?>
			<div class="ewd-otp-premium-options-table-overlay">
				<div class="ewd-otp-unlock-premium">
					<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Order Tracking Premium">
					<p>Access this section by by upgrading to premium</p>
					<a href="https://www.etoilewebdesign.com/plugins/order-tracking/#buy" class="ewd-otp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
				</div>
			</div>
		<?php } ?>
	</div>

	<br />

	<div class="ewd-otp-admin-section-heading"><?php _e('Order Display Pages', 'order-tracking'); ?></div>

	<div class="ewd-otp-admin-styling-section">
		<div class="ewd-otp-admin-styling-subsection" style="padding-bottom: 20px;">
			<h3 style="margin-top: 0"><?php _e('Order Display Page', 'order-tracking'); ?></h3>
			<p>Replace the default text on the order display pages</p>
			<div class="ewd-admin-labelling-section">
				<label>
					<p><?php _e("Order Information", 'order-tracking')?></p>
					<input type='text' name='order_information_label' value='<?php echo $Order_Information_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Order Number", 'order-tracking')?></p>
					<input type='text' name='order_number_label' value='<?php echo $Order_Number_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Order Name", 'order-tracking')?></p>
					<input type='text' name='order_name_label' value='<?php echo $Order_Name_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Order Notes", 'order-tracking')?></p>
					<input type='text' name='order_notes_label' value='<?php echo $Order_Notes_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Customer Notes", 'order-tracking')?></p>
					<input type='text' name='customer_notes_label' value='<?php echo $Customer_Notes_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Order Status", 'order-tracking')?></p>
					<input type='text' name='order_status_label' value='<?php echo $Order_Status_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Order Location", 'order-tracking')?></p>
					<input type='text' name='order_location_label' value='<?php echo $Order_Location_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Order Updated", 'order-tracking')?></p>
					<input type='text' name='order_updated_label' value='<?php echo $Order_Updated_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Current Location", 'order-tracking')?></p>
					<input type='text' name='order_current_location_label' value='<?php echo $Order_Current_Location_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Print Button", 'order-tracking')?></p>
					<input type='text' name='order_print_button_label' value='<?php echo $Order_Print_Button_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Add Note Button", 'order-tracking')?></p>
					<input type='text' name='order_add_note_button_label' value='<?php echo $Order_Add_Note_Button_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Update Status Button", 'order-tracking')?></p>
					<input type='text' name='order_update_status_button_label' value='<?php echo $Order_Update_Status_Button_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
			</div>
		</div>
		<div class="ewd-otp-admin-styling-subsection" style="padding-bottom: 20px;">
			<h3 style="margin-top: 0"><?php _e('Customer Form Display Page', 'order-tracking'); ?></h3>
			<div class="ewd-admin-labelling-section">
				<label>
					<p><?php _e("Customer Name", 'order-tracking')?></p>
					<input type='text' name='customer_display_name_label' value='<?php echo $Customer_Display_Name_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Customer Email", 'order-tracking')?></p>
					<input type='text' name='customer_display_email_label' value='<?php echo $Customer_Display_Email_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Download All Orders", 'order-tracking')?></p>
					<input type='text' name='customer_display_download_label' value='<?php echo $Customer_Display_Download_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
			</div>
		</div>
		<div class="ewd-otp-admin-styling-subsection">
			<h3 style="margin-top: 0"><?php _e('Sales Rep Form Display Page', 'order-tracking'); ?></h3>
			<div class="ewd-admin-labelling-section">
				<label>
					<p><?php _e("Sales Rep First Name", 'order-tracking')?></p>
					<input type='text' name='sales_rep_display_first_name_label' value='<?php echo $Sales_Rep_Display_First_Name_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Sales Rep Last Name", 'order-tracking')?></p>
					<input type='text' name='sales_rep_display_last_name_label' value='<?php echo $Sales_Rep_Display_Last_Name_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
			</div>
		</div>
		<?php if ($EWD_OTP_Full_Version != "Yes") { ?>
			<div class="ewd-otp-premium-options-table-overlay">
				<div class="ewd-otp-unlock-premium">
					<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Order Tracking Premium">
					<p>Access this section by by upgrading to premium</p>
					<a href="https://www.etoilewebdesign.com/plugins/order-tracking/#buy" class="ewd-otp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
				</div>
			</div>
		<?php } ?>
	</div>

	<br />

	<div class="ewd-otp-admin-section-heading"><?php _e('Customer Order Form', 'order-tracking'); ?></div>

	<div class="ewd-otp-admin-styling-section <?php echo $EWD_OTP_Full_Version; ?>">
		<div class="ewd-otp-admin-styling-subsection">
			<p>Replace the default text in the customer order form</p>
			<div class="ewd-admin-labelling-section">
				<label>
					<p><?php _e("Order Name", 'order-tracking')?></p>
					<input type='text' name='customer_order_name_label' value='<?php echo $Customer_Order_Name_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Order Email Address", 'order-tracking')?></p>
					<input type='text' name='customer_order_email_label' value='<?php echo $Customer_Order_Email_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Email Instructions", 'order-tracking')?></p>
					<input type='text' name='customer_order_email_instructions_label' value='<?php echo $Customer_Order_Email_Instructions_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Customer Notes", 'order-tracking')?></p>
					<input type='text' name='customer_order_notes_label' value='<?php echo $Customer_Order_Notes_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Send Order button", 'order-tracking')?></p>
					<input type='text' name='customer_order_button_label' value='<?php echo $Customer_Order_Button_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Thank You Message", 'order-tracking')?></p>
					<input type='text' name='customer_order_thank_you_label' value='<?php echo $Customer_Order_Thank_You_Label; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
			</div>
		</div>
		<?php if ($EWD_OTP_Full_Version != "Yes") { ?>
			<div class="ewd-otp-premium-options-table-overlay">
				<div class="ewd-otp-unlock-premium">
					<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Order Tracking Premium">
					<p>Access this section by by upgrading to premium</p>
					<a href="https://www.etoilewebdesign.com/plugins/order-tracking/#buy" class="ewd-otp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
				</div>
			</div>
		<?php } ?>
	</div>

</div>

	<div id='Styling' class='otp-option-set<?php echo ( $Display_Tab == 'Styling' ? '' : ' otp-hidden' ); ?>'>

		<br />

		<div class="ewd-otp-admin-section-heading"><?php _e('Title - Order Information', 'order-tracking'); ?></div>

		<div class="ewd-otp-admin-styling-section <?php echo $EWD_OTP_Full_Version; ?>">
			<div class="ewd-otp-admin-styling-subsection">
				<div class="ewd-otp-admin-styling-subsection-label"><?php _e('Text', 'order-tracking'); ?></div>
				<div class="ewd-otp-admin-styling-subsection-content">
					<div class="ewd-otp-admin-styling-subsection-content-each">
						<div class="ewd-otp-admin-styling-subsection-content-label"><?php _e('Color', 'order-tracking'); ?></div>
						<div class="ewd-otp-admin-styling-subsection-content-right">
							<div class="ewd-otp-admin-styling-subsection-content-color-picker">
								<div class="ewd-otp-admin-styling-subsection-content-color-picker-label"></div>
								<input type='text' class='ewd-otp-spectrum' name='otp_styling_title_font_color' value='<?php echo $OTP_Styling_Title_Font_Color; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?> />
							</div>
						</div>
					</div>
					<div class="ewd-otp-admin-styling-subsection-content-each">
						<div class="ewd-otp-admin-styling-subsection-content-label"><?php _e('Font Family', 'order-tracking'); ?></div>
						<div class="ewd-otp-admin-styling-subsection-content-right">
							<input type='text' name='otp_styling_title_font' class='ewd-otp-admin-font-size' value='<?php echo $OTP_Styling_Title_Font; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
					<div class="ewd-otp-admin-styling-subsection-content-each">
						<div class="ewd-otp-admin-styling-subsection-content-label"><?php _e('Font Size', 'order-tracking'); ?></div>
						<div class="ewd-otp-admin-styling-subsection-content-right">
							<input type='text' name='otp_styling_title_font_size' class='ewd-otp-admin-font-size' value='<?php echo $OTP_Styling_Title_Font_Size; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
				</div>
			</div>
			<div class="ewd-otp-admin-styling-subsection">
				<div class="ewd-otp-admin-styling-subsection-label"><?php _e('Spacing', 'order-tracking'); ?></div>
				<div class="ewd-otp-admin-styling-subsection-content">
					<div class="ewd-otp-admin-styling-subsection-content-each">
						<div class="ewd-otp-admin-styling-subsection-content-label"><?php _e('Title Margin', 'order-tracking'); ?></div>
						<div class="ewd-otp-admin-styling-subsection-content-right">
							<input type='text' name='otp_styling_title_margin' class='ewd-otp-admin-font-size' value='<?php echo $OTP_Styling_Title_Margin; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
					<div class="ewd-otp-admin-styling-subsection-content-each">
						<div class="ewd-otp-admin-styling-subsection-content-label"><?php _e('Title Padding', 'order-tracking'); ?></div>
						<div class="ewd-otp-admin-styling-subsection-content-right">
							<input type='text' name='otp_styling_title_padding' class='ewd-otp-admin-font-size' value='<?php echo $OTP_Styling_Title_Padding; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
				</div>
			</div>
			<?php if ($EWD_OTP_Full_Version != "Yes") { ?>
				<div class="ewd-otp-premium-options-table-overlay">
					<div class="ewd-otp-unlock-premium">
						<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Order Tracking Premium">
						<p>Access this section by by upgrading to premium</p>
						<a href="https://www.etoilewebdesign.com/plugins/order-tracking/#buy" class="ewd-otp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
					</div>
				</div>
			<?php } ?>
		</div>

		<br />

		<div class="ewd-otp-admin-section-heading"><?php _e('Body', 'order-tracking'); ?></div>

		<div class="ewd-otp-admin-styling-section <?php echo $EWD_OTP_Full_Version; ?>">
			<div class="ewd-otp-admin-styling-subsection">
				<div class="ewd-otp-admin-styling-subsection-label"><?php _e('Field Labels', 'order-tracking'); ?></div>
				<div class="ewd-otp-admin-styling-subsection-content">
					<div class="ewd-otp-admin-styling-subsection-content-each">
						<div class="ewd-otp-admin-styling-subsection-content-label"><?php _e('Color', 'order-tracking'); ?></div>
						<div class="ewd-otp-admin-styling-subsection-content-right">
							<div class="ewd-otp-admin-styling-subsection-content-color-picker">
								<div class="ewd-otp-admin-styling-subsection-content-color-picker-label"></div>
								<input type='text' class='ewd-otp-spectrum' name='otp_styling_label_font_color' value='<?php echo $OTP_Styling_Label_Font_Color; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?> />
							</div>
						</div>
					</div>
					<div class="ewd-otp-admin-styling-subsection-content-each">
						<div class="ewd-otp-admin-styling-subsection-content-label"><?php _e('Font Family', 'order-tracking'); ?></div>
						<div class="ewd-otp-admin-styling-subsection-content-right">
							<input type='text' name='otp_styling_label_font' class='ewd-otp-admin-font-size' value='<?php echo $OTP_Styling_Label_Font; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
					<div class="ewd-otp-admin-styling-subsection-content-each">
						<div class="ewd-otp-admin-styling-subsection-content-label"><?php _e('Font Size', 'order-tracking'); ?></div>
						<div class="ewd-otp-admin-styling-subsection-content-right">
							<input type='text' name='otp_styling_label_font_size' class='ewd-otp-admin-font-size' value='<?php echo $OTP_Styling_Label_Font_Size; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
				</div>
			</div>
			<div class="ewd-otp-admin-styling-subsection">
				<div class="ewd-otp-admin-styling-subsection-label"><?php _e('Field Content', 'order-tracking'); ?></div>
				<div class="ewd-otp-admin-styling-subsection-content">
					<div class="ewd-otp-admin-styling-subsection-content-each">
						<div class="ewd-otp-admin-styling-subsection-content-label"><?php _e('Color', 'order-tracking'); ?></div>
						<div class="ewd-otp-admin-styling-subsection-content-right">
							<div class="ewd-otp-admin-styling-subsection-content-color-picker">
								<div class="ewd-otp-admin-styling-subsection-content-color-picker-label"></div>
								<input type='text' class='ewd-otp-spectrum' name='otp_styling_content_font_color' value='<?php echo $OTP_Styling_Content_Font_Color; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?> />
							</div>
						</div>
					</div>
					<div class="ewd-otp-admin-styling-subsection-content-each">
						<div class="ewd-otp-admin-styling-subsection-content-label"><?php _e('Font Family', 'order-tracking'); ?></div>
						<div class="ewd-otp-admin-styling-subsection-content-right">
							<input type='text' name='otp_styling_content_font' class='ewd-otp-admin-font-size' value='<?php echo $OTP_Styling_Content_Font; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
					<div class="ewd-otp-admin-styling-subsection-content-each">
						<div class="ewd-otp-admin-styling-subsection-content-label"><?php _e('Font Size', 'order-tracking'); ?></div>
						<div class="ewd-otp-admin-styling-subsection-content-right">
							<input type='text' name='otp_styling_content_font_size' class='ewd-otp-admin-font-size' value='<?php echo $OTP_Styling_Content_Font_Size; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
				</div>
			</div>
			<div class="ewd-otp-admin-styling-subsection">
				<div class="ewd-otp-admin-styling-subsection-label"><?php _e('Spacing', 'order-tracking'); ?></div>
				<div class="ewd-otp-admin-styling-subsection-content">
					<div class="ewd-otp-admin-styling-subsection-content-each">
						<div class="ewd-otp-admin-styling-subsection-content-label"><?php _e('Body Margin', 'order-tracking'); ?></div>
						<div class="ewd-otp-admin-styling-subsection-content-right">
							<input type='text' name='otp_styling_body_margin' class='ewd-otp-admin-font-size' value='<?php echo $OTP_Styling_Body_Margin; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
					<div class="ewd-otp-admin-styling-subsection-content-each">
						<div class="ewd-otp-admin-styling-subsection-content-label"><?php _e('Body Padding', 'order-tracking'); ?></div>
						<div class="ewd-otp-admin-styling-subsection-content-right">
							<input type='text' name='otp_styling_body_padding' class='ewd-otp-admin-font-size' value='<?php echo $OTP_Styling_Body_Padding; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
				</div>
			</div>
			<?php if ($EWD_OTP_Full_Version != "Yes") { ?>
				<div class="ewd-otp-premium-options-table-overlay">
					<div class="ewd-otp-unlock-premium">
						<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Order Tracking Premium">
						<p>Access this section by by upgrading to premium</p>
						<a href="https://www.etoilewebdesign.com/plugins/order-tracking/#buy" class="ewd-otp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
					</div>
				</div>
			<?php } ?>
		</div>

		<br />

		<div class="ewd-otp-admin-section-heading"><?php _e('Buttons', 'order-tracking'); ?></div>

		<div class="ewd-otp-admin-styling-section <?php echo $EWD_OTP_Full_Version; ?>">
			<div class="ewd-otp-admin-styling-subsection">
				<div class="ewd-otp-admin-styling-subsection-label"><?php _e('Buttons', 'order-tracking'); ?></div>
				<div class="ewd-otp-admin-styling-subsection-content">
					<div class="ewd-otp-admin-styling-subsection-content-each">
						<div class="ewd-otp-admin-styling-subsection-content-label"><?php _e('Colors', 'order-tracking'); ?></div>
						<div class="ewd-otp-admin-styling-subsection-content-right">
							<div class="ewd-otp-admin-styling-subsection-content-color-picker">
								<div class="ewd-otp-admin-styling-subsection-content-color-picker-label"><?php _e('Text', 'order-tracking'); ?></div>
								<input type='text' class='ewd-otp-spectrum' name='otp_styling_button_font_color' value='<?php echo $OTP_Styling_Button_Font_Color; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?> />
							</div>
							<div class="ewd-otp-admin-styling-subsection-content-color-picker">
								<div class="ewd-otp-admin-styling-subsection-content-color-picker-label"><?php _e('Background', 'order-tracking'); ?></div>
								<input type='text' class='ewd-otp-spectrum' name='otp_styling_button_bg_color' value='<?php echo $OTP_Styling_Button_Bg_Color; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?> />
							</div>
						</div>
					</div>
					<div class="ewd-otp-admin-styling-subsection-content-each">
						<div class="ewd-otp-admin-styling-subsection-content-label"><?php _e('Border', 'order-tracking'); ?></div>
						<div class="ewd-otp-admin-styling-subsection-content-right">
							<input type='text' name='otp_styling_button_border' class='ewd-otp-admin-font-size' value='<?php echo $OTP_Styling_Button_Border; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
					<div class="ewd-otp-admin-styling-subsection-content-each">
						<div class="ewd-otp-admin-styling-subsection-content-label"><?php _e('Margin', 'order-tracking'); ?></div>
						<div class="ewd-otp-admin-styling-subsection-content-right">
							<input type='text' name='otp_styling_button_margin' class='ewd-otp-admin-font-size' value='<?php echo $OTP_Styling_Button_Margin; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
					<div class="ewd-otp-admin-styling-subsection-content-each">
						<div class="ewd-otp-admin-styling-subsection-content-label"><?php _e('Padding', 'order-tracking'); ?></div>
						<div class="ewd-otp-admin-styling-subsection-content-right">
							<input type='text' name='otp_styling_button_padding' class='ewd-otp-admin-font-size' value='<?php echo $OTP_Styling_Button_Padding; ?>' <?php if ($EWD_OTP_Full_Version != "Yes") {echo "disabled";} ?> />
						</div>
					</div>
				</div>
			</div>
			<?php if ($EWD_OTP_Full_Version != "Yes") { ?>
				<div class="ewd-otp-premium-options-table-overlay">
					<div class="ewd-otp-unlock-premium">
						<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Order Tracking Premium">
						<p>Access this section by by upgrading to premium</p>
						<a href="https://www.etoilewebdesign.com/plugins/order-tracking/#buy" class="ewd-otp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
					</div>
				</div>
			<?php } ?>
		</div>

	</div>

<p class="submit"><input type="submit" name="Options_Submit" id="submit" class="button button-primary" value="Save Changes"  /></p></form>

</div>
</div>
